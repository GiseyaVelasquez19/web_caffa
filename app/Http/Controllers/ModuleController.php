<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;

class ModuleController extends Controller
{
    public function index()
    {
        auth()->user()->can('modules view') ?: abort(403);
        $modules = Module::orderBy('orden')->paginate(15);

        return view('modules.index', compact('modules'));
    }

    public function show(Module $module)
    {
        return redirect()->route('modules.index');
    }

    public function create()
    {
        auth()->user()->can('modules create') ?: abort(403);

        $routePrefixes = $this->getRoutePrefixes();

        return view('modules.create', compact('routePrefixes'));
    }

    public function store(Request $request)
    {
        auth()->user()->can('modules create') ?: abort(403);

        $routePrefixes = $this->getRoutePrefixes();

        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:modulos',
            'slug' => [
                'required', 'string', 'max:255', 'unique:modulos',
                'regex:/^[a-z0-9_]+$/',
                Rule::in($routePrefixes),
            ],
            'icono' => 'nullable|string|max:50',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
            'orden' => 'nullable|integer',
        ]);

        $module = Module::create($validated);

        $this->createDefaultPermissions($module);

        return redirect()->route('modules.index')->with('success', 'Módulo creado exitosamente con sus permisos por defecto.');
    }

    public function edit(Module $module)
    {
        auth()->user()->can('modules edit') ?: abort(403);

        $routePrefixes = $this->getRoutePrefixes();

        return view('modules.edit', compact('module', 'routePrefixes'));
    }

    public function update(Request $request, Module $module)
    {
        auth()->user()->can('modules edit') ?: abort(403);

        $routePrefixes = $this->getRoutePrefixes();

        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:modulos,nombre,'.$module->id,
            'slug' => [
                'required', 'string', 'max:255',
                'unique:modulos,slug,'.$module->id,
                'regex:/^[a-z0-9_]+$/',
                Rule::in($routePrefixes),
            ],
            'icono' => 'nullable|string|max:50',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
            'orden' => 'nullable|integer',
        ]);

        $oldSlug = $module->slug;

        $module->update($validated);

        if ($oldSlug !== $module->slug) {
            $this->syncPermissions($oldSlug, $module->slug);
        }

        return redirect()->route('modules.index')->with('success', 'Módulo actualizado exitosamente.');
    }

    public function destroy(Module $module)
    {
        auth()->user()->can('modules delete') ?: abort(403);

        $module->delete();

        return redirect()->route('modules.index')->with('success', 'Módulo eliminado exitosamente.');
    }

    public function managePermissions(Module $module)
    {
        auth()->user()->can('modules manage') ?: abort(403);

        $permissions = $module->permissions();
        $actions = ['view', 'create', 'edit', 'delete', 'manage'];

        return view('modules.permissions', compact('module', 'permissions', 'actions'));
    }

    private function createDefaultPermissions(Module $module): void
    {
        $actions = ['view', 'create', 'edit', 'delete', 'manage'];

        foreach ($actions as $action) {
            Permission::firstOrCreate(
                ['name' => "{$module->slug} {$action}"],
                ['guard_name' => 'web']
            );
        }
    }

    private function syncPermissions(string $oldSlug, string $newSlug): void
    {
        $actions = ['view', 'create', 'edit', 'delete', 'manage'];

        foreach ($actions as $action) {
            Permission::where('name', "{$oldSlug} {$action}")->delete();
            Permission::firstOrCreate(
                ['name' => "{$newSlug} {$action}"],
                ['guard_name' => 'web']
            );
        }
    }

    private function getRoutePrefixes(): array
    {
        $routes = Route::getRoutes()->getRoutesByName();
        $prefixes = [];

        foreach ($routes as $name => $route) {
            $parts = explode('.', $name);
            $prefixes[$parts[0]] = true;
        }

        $prefixes = array_keys($prefixes);
        sort($prefixes);

        return $prefixes;
    }
}

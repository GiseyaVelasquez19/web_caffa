<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class ModuleController extends Controller
{
    public function index()
    {
        auth()->user()->can('view modules') ?: abort(403);
        $modules = Module::orderBy('orden')->paginate(15);

        return view('modules.index', compact('modules'));
    }

    public function create()
    {
        auth()->user()->can('create modules') ?: abort(403);

        return view('modules.create');
    }

    public function store(Request $request)
    {
        auth()->user()->can('create modules') ?: abort(403);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:modulos',
            'slug' => 'required|string|max:255|unique:modulos|regex:/^[a-z0-9_]+$/',
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
        auth()->user()->can('edit modules') ?: abort(403);

        return view('modules.edit', compact('module'));
    }

    public function update(Request $request, Module $module)
    {
        auth()->user()->can('edit modules') ?: abort(403);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:modulos,nombre,' . $module->id,
            'slug' => 'required|string|max:255|unique:modulos,slug,' . $module->id . '|regex:/^[a-z0-9_]+$/',
            'icono' => 'nullable|string|max:50',
            'descripcion' => 'nullable|string',
            'activo' => 'boolean',
            'orden' => 'nullable|integer',
        ]);

        $module->update($validated);

        return redirect()->route('modules.index')->with('success', 'Módulo actualizado exitosamente.');
    }

    public function destroy(Module $module)
    {
        auth()->user()->can('delete modules') ?: abort(403);

        $module->delete();

        return redirect()->route('modules.index')->with('success', 'Módulo eliminado exitosamente.');
    }

    public function managePermissions(Module $module)
    {
        auth()->user()->can('manage modules') ?: abort(403);

        $permissions = $module->permissions();
        $actions = ['view', 'create', 'edit', 'delete'];

        return view('modules.permissions', compact('module', 'permissions', 'actions'));
    }

    private function createDefaultPermissions(Module $module): void
    {
        $actions = ['view', 'create', 'edit', 'delete'];

        foreach ($actions as $action) {
            Permission::firstOrCreate(
                ['name' => "{$module->slug} {$action}"],
                ['guard_name' => 'web']
            );
        }
    }
}

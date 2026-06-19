<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    public function index()
    {
        auth()->user()->can('view permissions') ?: abort(403);
        $permissions = Permission::paginate(15);

        return view('permissions.index', compact('permissions'));
    }

    public function create()
    {
        auth()->user()->can('create permissions') ?: abort(403);

        return view('permissions.create');
    }

    public function store(Request $request)
    {
        auth()->user()->can('create permissions') ?: abort(403);

        $validated = $request->validate([
            'name' => 'required|string|unique:permissions',
            'description' => 'nullable|string',
        ]);

        Permission::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permiso creado exitosamente.');
    }

    public function edit(Permission $permission)
    {
        auth()->user()->can('edit permissions') ?: abort(403);

        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        auth()->user()->can('edit permissions') ?: abort(403);

        $validated = $request->validate([
            'name' => 'required|string|unique:permissions,name,'.$permission->id,
            'description' => 'nullable|string',
        ]);

        $permission->update(['name' => $validated['name']]);

        return redirect()->route('permissions.index')->with('success', 'Permiso actualizado exitosamente.');
    }

    public function destroy(Permission $permission)
    {
        auth()->user()->can('delete permissions') ?: abort(403);

        $permission->delete();

        return redirect()->route('permissions.index')->with('success', 'Permiso eliminado exitosamente.');
    }

    public function assignToRole(Role $role)
    {
        auth()->user()->can('assign permissions') ?: abort(403);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('permissions.assign', compact('role', 'permissions', 'rolePermissions'));
    }

    public function syncRolePermissions(Request $request, Role $role)
    {
        auth()->user()->can('assign permissions') ?: abort(403);

        $validated = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $permissions = Permission::whereIn('id', $validated['permissions'] ?? [])->get();
        $role->syncPermissions($permissions);

        return redirect()->route('permissions.assign', $role)->with('success', 'Permisos actualizados exitosamente.');
    }
}

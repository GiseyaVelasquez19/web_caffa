<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index()
    {
        auth()->user()->can('roles view') ?: abort(403);
        $roles = Role::paginate(15);

        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        auth()->user()->can('roles create') ?: abort(403);
        $permissions = Permission::all();

        return view('roles.create', compact('permissions'));
    }

    public function store(Request $request)
    {
        auth()->user()->can('roles create') ?: abort(403);

        $validated = $request->validate([
            'name' => 'required|string|unique:roles',
            'permissions' => 'array',
        ]);

        $role = Role::create(['name' => $validated['name'], 'guard_name' => 'web']);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');
    }

    public function edit(Role $role)
    {
        auth()->user()->can('roles edit') ?: abort(403);
        $permissions = Permission::all();
        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, Role $role)
    {
        auth()->user()->can('roles edit') ?: abort(403);

        $validated = $request->validate([
            'name' => 'required|string|unique:roles,name,'.$role->id,
            'permissions' => 'array',
        ]);

        $role->update(['name' => $validated['name']]);

        if ($request->has('permissions')) {
            $role->syncPermissions($request->permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');
    }

    public function destroy(Role $role)
    {
        auth()->user()->can('roles delete') ?: abort(403);

        $role->delete();

        return redirect()->route('roles.index')->with('success', 'Rol eliminado exitosamente.');
    }
}

@extends('layouts.app')

@section('title', 'Roles - Caffa')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-amber-900">Gestión de Roles</h1>
        @can('create roles')
            <a href="{{ route('roles.create') }}" class="bg-amber-900 hover:bg-amber-800 text-white font-bold py-2 px-4 rounded-lg transition">
                + Nuevo Rol
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-amber-900 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nombre</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Permisos</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($roles as $role)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $role->name }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-wrap gap-1">
                                @forelse ($role->permissions->take(3) as $permission)
                                    <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">
                                        {{ $permission->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400 text-xs">Sin permisos</span>
                                @endforelse
                                @if ($role->permissions->count() > 3)
                                    <span class="inline-block bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">
                                        +{{ $role->permissions->count() - 3 }} más
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-center space-x-2">
                            @can('assign permissions')
                                <a href="{{ route('permissions.assign', $role) }}" class="text-green-600 hover:text-green-900">Permisos</a>
                            @endcan
                            @can('edit roles')
                                <a href="{{ route('roles.edit', $role) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                            @endcan
                            @can('delete roles')
                                <form method="POST" action="{{ route('roles.destroy', $role) }}" class="inline" onsubmit="return confirm('¿Estás seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-center text-gray-500">No hay roles registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $roles->links() }}
    </div>
@endsection

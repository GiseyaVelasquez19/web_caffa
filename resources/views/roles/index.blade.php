@extends('layouts.app')

@section('title', 'Roles - Caffa')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Roles</h1>
            <p class="text-gray-500 text-sm">Gestiona los roles y permisos</p>
        </div>
        @can('create roles')
            <a href="{{ route('roles.create') }}" class="text-white font-medium py-2 px-4 rounded-lg transition text-sm" style="background-color: #6F4E37" onmouseover="this.style.backgroundColor='#5A3E2B'" onmouseout="this.style.backgroundColor='#6F4E37'">
                + Nuevo Rol
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Permisos</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($roles as $role)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $role->name }}</td>
                        <td class="px-6 py-4 text-sm">
                            <div class="flex flex-wrap gap-1">
                                @forelse ($role->permissions->take(3) as $permission)
                                    <span class="inline-block bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">
                                        {{ $permission->name }}
                                    </span>
                                @empty
                                    <span class="text-gray-400 text-xs">Sin permisos</span>
                                @endforelse
                                @if ($role->permissions->count() > 3)
                                    <span class="inline-block bg-gray-200 text-gray-600 px-2 py-1 rounded text-xs">
                                        +{{ $role->permissions->count() - 3 }} más
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm space-x-3">
                            @can('assign permissions')
                                <a href="{{ route('permissions.assign', $role) }}" class="font-medium transition hover:underline" style="color: #6F4E37">
                                    Permisos
                                </a>
                            @endcan
                            @can('edit roles')
                                <a href="{{ route('roles.edit', $role) }}" class="font-medium transition hover:underline" style="color: #6F4E37">
                                    Editar
                                </a>
                            @endcan
                            @can('delete roles')
                                <form method="POST" action="{{ route('roles.destroy', $role) }}" class="inline" onsubmit="return confirm('¿Estás seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition">
                                        Eliminar
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-6 py-8 text-center text-gray-400 text-sm">No hay roles registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $roles->links() }}
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Usuarios - Caffa')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-amber-900">Gestión de Usuarios</h1>
        @can('create users')
            <a href="{{ route('users.create') }}" class="bg-amber-900 hover:bg-amber-800 text-white font-bold py-2 px-4 rounded-lg transition">
                + Nuevo Usuario
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-amber-900 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nombre</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Roles</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Super Admin</th>
                    <th class="px-6 py-3 text-center text-sm font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($users as $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $user->email }}</td>
                        <td class="px-6 py-4 text-sm">
                            @forelse ($user->roles as $role)
                                <span class="inline-block bg-amber-100 text-amber-800 px-2 py-1 rounded text-xs mr-1">
                                    {{ $role->name }}
                                </span>
                            @empty
                                <span class="text-gray-400 text-xs">Sin roles</span>
                            @endforelse
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if ($user->is_superadmin)
                                <span class="inline-block bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">
                                    👑 Sí
                                </span>
                            @else
                                <span class="text-gray-400 text-xs">No</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-center space-x-2">
                            @can('edit users')
                                <a href="{{ route('users.edit', $user) }}" class="text-blue-600 hover:text-blue-900">Editar</a>
                            @endcan
                            @can('delete users')
                                <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline" onsubmit="return confirm('¿Estás seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No hay usuarios registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $users->links() }}
    </div>
@endsection

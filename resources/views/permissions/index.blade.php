@extends('layouts.app')

@section('title', 'Permisos - Caffa')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-amber-900">Gestión de Permisos</h1>
        @can('create permissions')
            <a href="{{ route('permissions.create') }}" class="bg-amber-900 hover:bg-amber-800 text-white font-bold py-2 px-4 rounded-lg transition">
                + Nuevo Permiso
            </a>
        @endcan
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-amber-900 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nombre</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Guard</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Creado</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($permissions as $permission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $permission->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $permission->guard_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $permission->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            @can('edit permissions')
                                <a href="{{ route('permissions.edit', $permission) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                    Editar
                                </a>
                            @endcan
                            @can('delete permissions')
                                <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">
                                        Eliminar
                                    </button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No hay permisos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $permissions->links() }}
    </div>
@endsection

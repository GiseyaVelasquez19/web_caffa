@extends('layouts.app')

@section('title', 'Permisos - Caffa')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Permisos</h1>
            <p class="text-gray-500 text-sm">Gestiona los permisos del sistema</p>
        </div>
        @can('create permissions')
            <a href="{{ route('permissions.create') }}" class="text-white font-medium py-2 px-4 rounded-lg transition text-sm" style="background-color: #6F4E37" onmouseover="this.style.backgroundColor='#5A3E2B'" onmouseout="this.style.backgroundColor='#6F4E37'">
                + Nuevo Permiso
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Guard</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Creado</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($permissions as $permission)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $permission->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $permission->guard_name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $permission->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-6 py-4 text-sm space-x-3">
                            @can('edit permissions')
                                <a href="{{ route('permissions.edit', $permission) }}" class="font-medium transition hover:underline" style="color: #6F4E37">
                                    Editar
                                </a>
                            @endcan
                            @can('delete permissions')
                                <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro?')">
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
                        <td colspan="4" class="px-6 py-8 text-center text-gray-400 text-sm">No hay permisos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $permissions->links() }}
    </div>
@endsection

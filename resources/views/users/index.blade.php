@extends('layouts.app')

@section('title', 'Usuarios - Caffa')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Usuarios</h1>
            <p class="text-gray-500 text-sm">Gestiona los usuarios del sistema</p>
        </div>
        @can('users create')
            <a href="{{ route('users.create') }}" class="text-white font-medium py-2 px-4 rounded-lg transition text-sm whitespace-nowrap" style="background-color: #6F4E37" onmouseover="this.style.backgroundColor='#5A3E2B'" onmouseout="this.style.backgroundColor='#6F4E37'">
                + Nuevo Usuario
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[500px]">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Roles</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold text-white flex-shrink-0" style="background-color: #6F4E37">
                                        {{ strtoupper(substr($user->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500 sm:hidden">{{ $user->email }}</p>
                                        @if ($user->is_superadmin)
                                            <span class="text-xs flex items-center gap-1" style="color: #6F4E37"><i class="fas fa-crown"></i> Super Admin</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 hidden sm:table-cell">{{ $user->email }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex flex-wrap gap-1">
                                    @forelse ($user->roles as $role)
                                        <span class="inline-block bg-gray-100 text-gray-600 px-2 py-1 rounded text-xs">
                                            {{ $role->name }}
                                        </span>
                                    @empty
                                        <span class="text-gray-400 text-xs">Sin roles</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex flex-col sm:flex-row gap-2">
                                    @can('users edit')
                                        <a href="{{ route('users.edit', $user) }}" class="font-medium transition hover:underline" style="color: #6F4E37">
                                            Editar
                                        </a>
                                    @endcan
                                    @can('users delete')
                                        <form method="POST" action="{{ route('users.destroy', $user) }}" class="inline" onsubmit="return confirm('¿Estás seguro?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-medium transition">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-gray-400 text-sm">No hay usuarios registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
@endsection

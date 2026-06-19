@extends('layouts.app')

@section('title', 'Módulos - Caffa')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Módulos</h1>
            <p class="text-gray-500 text-sm">Gestiona los módulos del sistema</p>
        </div>
        @can('modules create')
            <a href="{{ route('modules.create') }}" class="text-white font-medium py-2 px-4 rounded-lg transition text-sm" style="background-color: #6F4E37" onmouseover="this.style.backgroundColor='#5A3E2B'" onmouseout="this.style.backgroundColor='#6F4E37'">
                + Nuevo Módulo
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Icono</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Slug</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($modules as $module)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4 text-sm text-center">{{ $module->icono ?? '📦' }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">{{ $module->nombre }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <code class="bg-gray-100 px-2 py-1 rounded text-xs">{{ $module->slug }}</code>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ Str::limit($module->descripcion, 50) }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if ($module->activo)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-50 text-green-600">Activo</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-500">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm space-x-3">
                            @can('modules edit')
                                <a href="{{ route('modules.edit', $module) }}" class="font-medium transition hover:underline" style="color: #6F4E37">
                                    Editar
                                </a>
                            @endcan
                            @can('modules manage')
                                <a href="{{ route('modules.permissions', $module) }}" class="font-medium transition hover:underline" style="color: #6F4E37">
                                    Permisos
                                </a>
                            @endcan
                            @can('modules delete')
                                <form action="{{ route('modules.destroy', $module) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro?')">
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
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400 text-sm">No hay módulos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $modules->links() }}
    </div>
@endsection

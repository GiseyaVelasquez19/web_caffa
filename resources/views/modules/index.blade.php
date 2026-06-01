@extends('layouts.app')

@section('title', 'Módulos - Caffa')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-amber-900">Gestión de Módulos</h1>
        @can('create modules')
            <a href="{{ route('modules.create') }}" class="bg-amber-900 hover:bg-amber-800 text-white font-bold py-2 px-4 rounded-lg transition">
                + Nuevo Módulo
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
                    <th class="px-6 py-3 text-left text-sm font-semibold">Icono</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Nombre</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Slug</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Descripción</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Estado</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($modules as $module)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-center">{{ $module->icono ?? '📦' }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $module->nombre }}</td>
                        <td class="px-6 py-4 text-sm text-gray-600">
                            <code class="bg-gray-100 px-2 py-1 rounded">{{ $module->slug }}</code>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ Str::limit($module->descripcion, 50) }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if ($module->activo)
                                <span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Activo</span>
                            @else
                                <span class="bg-gray-100 text-gray-800 px-3 py-1 rounded-full text-xs font-semibold">Inactivo</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm space-x-2">
                            @can('edit modules')
                                <a href="{{ route('modules.edit', $module) }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                                    Editar
                                </a>
                            @endcan
                            @can('manage modules')
                                <a href="{{ route('modules.permissions', $module) }}" class="text-purple-600 hover:text-purple-800 font-semibold">
                                    Permisos
                                </a>
                            @endcan
                            @can('delete modules')
                                <form action="{{ route('modules.destroy', $module) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro?')">
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
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">No hay módulos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $modules->links() }}
    </div>

    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-3">💡 Cómo usar Módulos</h3>
        <ul class="text-sm text-blue-800 space-y-2">
            <li>✓ Crea un nuevo módulo con un nombre y slug único</li>
            <li>✓ Se crearán automáticamente 4 permisos: view, create, edit, delete</li>
            <li>✓ Asigna estos permisos a roles según sea necesario</li>
            <li>✓ Usa los permisos en tus vistas y controladores</li>
        </ul>
    </div>
@endsection

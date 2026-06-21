@extends('layouts.app')

@section('title', 'Categorías - Caffa')

@section('content')
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Categorías</h1>
            <p class="text-gray-500 text-sm">Gestiona las categorías de productos</p>
        </div>
        @can('categories create')
            <a href="{{ route('categories.create') }}" class="text-white font-medium py-2 px-4 rounded-lg transition text-sm whitespace-nowrap" style="background-color: #6F4E37" onmouseover="this.style.backgroundColor='#5A3E2B'" onmouseout="this.style.backgroundColor='#6F4E37'">
                + Nueva Categoría
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[400px]">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Nombre</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide hidden sm:table-cell">Descripción</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($categories as $category)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-gray-800">{{ $category->nombre }}</p>
                                @if ($category->descripcion)
                                    <p class="text-xs text-gray-400 sm:hidden mt-1">{{ Str::limit($category->descripcion, 40) }}</p>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500 hidden sm:table-cell">{{ $category->descripcion ?? '—' }}</td>
                            <td class="px-6 py-4 text-sm">
                                <div class="flex flex-col sm:flex-row gap-2">
                                    @can('categories edit')
                                        <a href="{{ route('categories.edit', $category) }}" class="font-medium transition hover:underline" style="color: #6F4E37">
                                            Editar
                                        </a>
                                    @endcan
                                    @can('categories delete')
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro?')">
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
                            <td colspan="3" class="px-6 py-8 text-center text-gray-400 text-sm">No hay categorías registradas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $categories->links() }}
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Productos - Caffa')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Productos</h1>
            <p class="text-gray-500 text-sm">Gestiona el catálogo de productos</p>
        </div>
        @can('products create')
            <a href="{{ route('products.create') }}" class="text-white font-medium py-2 px-4 rounded-lg transition text-sm" style="background-color: #6F4E37" onmouseover="this.style.backgroundColor='#5A3E2B'" onmouseout="this.style.backgroundColor='#6F4E37'">
                + Nuevo Producto
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Producto</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Categoría</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Precio</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Stock</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wide">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($products as $product)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden">
                                    @if ($product->imagen)
                                        <img src="{{ Storage::url($product->imagen) }}" alt="{{ $product->nombre }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-lg">☕</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $product->nombre }}</p>
                                    <p class="text-xs text-gray-400">{{ $product->codigo ?? 'Sin código' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">{{ $product->category->nombre ?? '—' }}</td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-800">${{ number_format($product->precio, 0, ',', '.') }}</td>
                        <td class="px-6 py-4 text-sm">
                            @if ($product->stock > 0)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-50 text-green-600">
                                    {{ $product->stock }} unidades
                                </span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-50 text-red-600">
                                    Sin stock
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm space-x-3">
                            @can('products edit')
                                <a href="{{ route('products.edit', $product) }}" class="font-medium transition hover:underline" style="color: #6F4E37">
                                    Editar
                                </a>
                            @endcan
                            @can('products delete')
                                <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este producto?')">
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
                        <td colspan="5" class="px-6 py-8 text-center text-gray-400 text-sm">No hay productos registrados</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $products->links() }}
    </div>
@endsection

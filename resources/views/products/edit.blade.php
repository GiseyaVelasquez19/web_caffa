@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-amber-900 mb-6">Editar Producto</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="nombre" class="block text-sm font-semibold text-amber-900 mb-2">Nombre del Producto *</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $product->nombre) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500"
                    required>
            </div>

            <div class="mb-6">
                <label for="codigo" class="block text-sm font-semibold text-amber-900 mb-2">Código (SKU)</label>
                <input type="text" id="codigo" name="codigo" value="{{ old('codigo', $product->codigo) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500">
                <p class="text-xs text-gray-600 mt-1">Código único de identificación del producto</p>
            </div>

            <div class="mb-6">
                <label for="categoria_id" class="block text-sm font-semibold text-amber-900 mb-2">Categoría *</label>
                <select id="categoria_id" name="categoria_id" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500 bg-white">
                    <option value="">Selecciona una categoría...</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('categoria_id', $product->categoria_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label for="precio" class="block text-sm font-semibold text-amber-900 mb-2">Precio *</label>
                    <input type="number" id="precio" name="precio" value="{{ old('precio', $product->precio) }}" step="0.01" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500"
                        required>
                </div>
                <div>
                    <label for="stock" class="block text-sm font-semibold text-amber-900 mb-2">Stock *</label>
                    <input type="number" id="stock" name="stock" value="{{ old('stock', $product->stock) }}" min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500"
                        required>
                </div>
            </div>

            <div class="mb-6">
                <label for="descripcion" class="block text-sm font-semibold text-amber-900 mb-2">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500">{{ old('descripcion', $product->descripcion) }}</textarea>
            </div>

            <div class="mb-6">
                <label for="imagen" class="block text-sm font-semibold text-amber-900 mb-2">Imagen</label>
                @if ($product->imagen)
                    <div class="mb-2">
                        <img src="{{ Storage::url($product->imagen) }}" alt="{{ $product->nombre }}" class="w-32 h-32 object-cover rounded">
                    </div>
                @endif
                <input type="file" id="imagen" name="imagen" accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500">
                <p class="text-xs text-gray-600 mt-1">Formatos permitidos: JPG, PNG. Tamaño máximo: 2MB</p>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-amber-900 hover:bg-amber-800 text-white font-bold py-2 px-6 rounded-lg transition">
                    Actualizar Producto
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

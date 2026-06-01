@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-amber-900 mb-6">Crear Nuevo Producto</h1>

        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
            <p class="text-sm text-blue-900">
                <strong>ℹ️ Nota:</strong> Este es un formulario de ejemplo. Implementa los campos según tus necesidades.
            </p>
        </div>

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <div class="mb-6">
                <label for="name" class="block text-sm font-semibold text-amber-900 mb-2">Nombre del Producto</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500"
                    placeholder="ej: Café Arábica Premium"
                    required>
            </div>

            <div class="mb-6">
                <label for="description" class="block text-sm font-semibold text-amber-900 mb-2">Descripción</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-amber-500"
                    placeholder="Describe el producto">{{ old('description') }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-amber-900 hover:bg-amber-800 text-white font-bold py-2 px-6 rounded-lg transition">
                    Crear Producto
                </button>
                <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg transition">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

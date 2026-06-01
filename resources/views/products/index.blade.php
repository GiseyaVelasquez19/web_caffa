@extends('layouts.app')

@section('title', 'Productos - Caffa')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-amber-900">Gestión de Productos</h1>
        @can('products create')
            <a href="{{ route('products.create') }}" class="bg-amber-900 hover:bg-amber-800 text-white font-bold py-2 px-4 rounded-lg transition">
                + Nuevo Producto
            </a>
        @endcan
    </div>

    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-8 text-center text-gray-500">
            <p class="text-lg">📦 Módulo de Productos</p>
            <p class="text-sm mt-2">Este es un módulo de ejemplo. Aquí irían tus productos de café.</p>
            <p class="text-sm mt-4">Puedes crear nuevos módulos parametrizados en la sección de Módulos.</p>
        </div>
    </div>

    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-6">
        <h3 class="text-lg font-semibold text-blue-900 mb-3">💡 Próximos Pasos</h3>
        <ul class="text-sm text-blue-800 space-y-2">
            <li>✓ Crea un modelo Product con migración</li>
            <li>✓ Implementa el CRUD completo en ProductController</li>
            <li>✓ Crea las vistas para crear, editar y listar productos</li>
            <li>✓ Los permisos ya están listos: products view, create, edit, delete</li>
        </ul>
    </div>
@endsection

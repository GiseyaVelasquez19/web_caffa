@extends('layouts.app')

@section('title', 'Dashboard - Caffa')

@section('content')
    <div class="mb-8">
        <h1 class="text-4xl font-bold text-amber-900 mb-2">Bienvenido, {{ auth()->user()->name }}</h1>
        <p class="text-gray-600">Gestiona tu tienda de café en grano con sabores</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total de Usuarios</p>
                    <p class="text-3xl font-bold text-amber-900">{{ $totalUsers }}</p>
                </div>
                <div class="text-4xl text-amber-200">👥</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total de Roles</p>
                    <p class="text-3xl font-bold text-amber-900">{{ $totalRoles }}</p>
                </div>
                <div class="text-4xl text-amber-200">🎭</div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-amber-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-500 text-sm">Total de Permisos</p>
                    <p class="text-3xl font-bold text-amber-900">{{ $totalPermissions }}</p>
                </div>
                <div class="text-4xl text-amber-200">🔐</div>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-8 mb-8">
        <h2 class="text-2xl font-bold text-amber-900 mb-4">Sobre Caffa</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div>
                <h3 class="text-lg font-semibold text-amber-800 mb-3">☕ Nuestro Producto</h3>
                <p class="text-gray-700 mb-4">
                    Caffa ofrece café en grano con una variedad de sabores únicos y deliciosos. 
                    Cada grano de café está cuidadosamente seleccionado y procesado para garantizar la mejor calidad.
                </p>
                <ul class="text-gray-700 space-y-2">
                    <li>✓ Café Arábica Premium</li>
                    <li>✓ Sabores Naturales Variados</li>
                    <li>✓ Tostado Artesanal</li>
                    <li>✓ Empaque Ecológico</li>
                </ul>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-amber-800 mb-3">🎯 Sabores Disponibles</h3>
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-amber-50 p-3 rounded">
                        <p class="font-semibold text-amber-900">Clásico</p>
                        <p class="text-sm text-gray-600">Sabor tradicional</p>
                    </div>
                    <div class="bg-amber-50 p-3 rounded">
                        <p class="font-semibold text-amber-900">Chocolate</p>
                        <p class="text-sm text-gray-600">Notas de cacao</p>
                    </div>
                    <div class="bg-amber-50 p-3 rounded">
                        <p class="font-semibold text-amber-900">Vainilla</p>
                        <p class="text-sm text-gray-600">Suave y aromático</p>
                    </div>
                    <div class="bg-amber-50 p-3 rounded">
                        <p class="font-semibold text-amber-900">Caramelo</p>
                        <p class="text-sm text-gray-600">Dulce y sofisticado</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (auth()->user()->is_superadmin)
        <div class="bg-amber-50 border-l-4 border-amber-500 p-6 rounded">
            <h3 class="text-lg font-semibold text-amber-900 mb-2">👑 Acceso de Super Administrador</h3>
            <p class="text-gray-700">Tienes acceso completo a todas las funciones de administración del sistema.</p>
        </div>
    @endif
@endsection

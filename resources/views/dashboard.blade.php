@extends('layouts.app')

@section('title', 'Dashboard - Caffa')

@section('content')
    <!-- Hero Banner -->
    <div class="relative rounded-2xl overflow-hidden mb-8" style="background: url('{{ asset("images/dasboard_cafe.png") }}') center/cover no-repeat, linear-gradient(135deg, #6F4E37 0%, #5A3E2B 50%, #4A3325 100%)">
        <div class="absolute inset-0 bg-gradient-to-r from-[#4A3325]/90 via-[#4A3325]/60 to-transparent"></div>
        <div class="relative flex flex-col md:flex-row items-center justify-between p-8 md:p-12">
            <div class="text-white mb-6 md:mb-0">
                <h1 class="text-3xl md:text-4xl font-bold mb-2">Bienvenido, {{ auth()->user()->name }}</h1>
                <p class="text-white/70 text-lg">Gestiona tu tienda de café premium colombiano</p>
                <div class="flex gap-4 mt-6">
                    @can('products view')
                        <a href="{{ route('products.index') }}" class="bg-white/20 hover:bg-white/30 text-white px-5 py-2.5 rounded-lg transition text-sm font-medium backdrop-blur-sm">
                            Ver Productos
                        </a>
                    @endcan
                    @can('products create')
                        <a href="{{ route('products.create') }}" class="bg-white text-[#6F4E37] px-5 py-2.5 rounded-lg transition text-sm font-medium hover:bg-white/90">
                            + Nuevo Producto
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">
                    ☕
                </div>
                <div>
                    <p class="text-gray-400 text-xs font-medium uppercase tracking-wider">Productos</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalProducts }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">
                    🏷️
                </div>
                <div>
                    <p class="text-gray-400 text-xs font-medium uppercase tracking-wider">Categorías</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalCategories }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">
                    👥
                </div>
                <div>
                    <p class="text-gray-400 text-xs font-medium uppercase tracking-wider">Usuarios</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $totalUsers }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-2xl {{ $lowStockProducts > 0 ? 'bg-red-50' : '' }}" style="{{ $lowStockProducts == 0 ? 'background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)' : '' }}">
                    {{ $lowStockProducts > 0 ? '⚠️' : '📦' }}
                </div>
                <div>
                    <p class="text-gray-400 text-xs font-medium uppercase tracking-wider">{{ $lowStockProducts > 0 ? 'Stock Bajo' : 'En Stock' }}</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $lowStockProducts > 0 ? $lowStockProducts : $totalProducts }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <!-- Featured Products (2 columns) -->
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-800">Productos Destacados</h2>
                @can('products view')
                    <a href="{{ route('products.index') }}" class="text-sm font-medium hover:underline" style="color: #6F4E37">
                        Ver todos →
                    </a>
                @endcan
            </div>

            @if ($featuredProducts->isEmpty())
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
                    <div class="text-6xl mb-4">☕</div>
                    <p class="text-gray-500 mb-2">No hay productos registrados</p>
                    <p class="text-gray-400 text-sm mb-4">Comienza agregando tu primer café al catálogo</p>
                    @can('products create')
                        <a href="{{ route('products.create') }}" class="inline-flex items-center gap-2 text-white px-5 py-2.5 rounded-lg transition text-sm font-medium" style="background-color: #6F4E37">
                            <span>+</span> Crear Producto
                        </a>
                    @endcan
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($featuredProducts as $product)
                        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                            <div class="h-44 bg-gradient-to-br from-[#F5EDE6] to-[#EDE0D4] flex items-center justify-center relative overflow-hidden">
                                @if ($product->imagen)
                                    <img src="{{ Storage::url($product->imagen) }}" alt="{{ $product->nombre }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <span class="text-7xl opacity-60 group-hover:scale-110 transition duration-300">☕</span>
                                @endif
                                @if ($product->stock <= 5 && $product->stock > 0)
                                    <span class="absolute top-3 right-3 bg-amber-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                                        Últimas {{ $product->stock }} unidades
                                    </span>
                                @elseif ($product->stock == 0)
                                    <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                                        Agotado
                                    </span>
                                @endif
                            </div>
                            <div class="p-4">
                                <p class="text-xs font-medium mb-1" style="color: #6F4E37">{{ $product->category->nombre ?? 'Sin categoría' }}</p>
                                <h3 class="font-semibold text-gray-800 mb-2">{{ $product->nombre }}</h3>
                                <div class="flex items-center justify-between">
                                    <span class="text-xl font-bold text-gray-800">${{ number_format($product->precio, 0, ',', '.') }}</span>
                                    @if ($product->stock > 0)
                                        <span class="text-xs bg-green-50 text-green-600 px-2 py-1 rounded-full">Disponible</span>
                                    @else
                                        <span class="text-xs bg-red-50 text-red-600 px-2 py-1 rounded-full">Sin stock</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Right Sidebar -->
        <div class="space-y-6">
            <!-- System Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">📊</span>
                    Resumen
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500 text-sm">Roles</span>
                        <span class="font-semibold text-gray-800">{{ $totalRoles }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500 text-sm">Permisos</span>
                        <span class="font-semibold text-gray-800">{{ $totalPermissions }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-gray-50">
                        <span class="text-gray-500 text-sm">Productos</span>
                        <span class="font-semibold text-gray-800">{{ $totalProducts }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-gray-500 text-sm">Categorías</span>
                        <span class="font-semibold text-gray-800">{{ $totalCategories }}</span>
                    </div>
                </div>
            </div>

            <!-- Super Admin Badge -->
            @if (auth()->user()->is_superadmin)
                <div class="rounded-2xl shadow-sm p-6 text-white relative overflow-hidden" style="background: linear-gradient(135deg, #6F4E37 0%, #5A3E2B 100%)">
                    <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
                        <svg viewBox="0 0 100 100" class="w-full h-full">
                            <circle cx="50" cy="50" r="40" fill="white"/>
                            <circle cx="50" cy="50" r="30" fill="none" stroke="white" stroke-width="2"/>
                        </svg>
                    </div>
                    <div class="relative">
                        <span class="text-3xl mb-3 block">👑</span>
                        <h4 class="font-semibold mb-1">Super Administrador</h4>
                        <p class="text-white/70 text-sm">Acceso completo al sistema</p>
                    </div>
                </div>
            @endif

            <!-- Quick Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Acciones Rápidas</h3>
                <div class="space-y-2">
                    @can('products create')
                        <a href="{{ route('products.create') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition group">
                            <span class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">➕</span>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Nuevo Producto</span>
                        </a>
                    @endcan
                    @can('categories create')
                        <a href="{{ route('categories.create') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition group">
                            <span class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">🏷️</span>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Nueva Categoría</span>
                        </a>
                    @endcan
                    @can('users create')
                        <a href="{{ route('users.create') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-gray-50 transition group">
                            <span class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">👤</span>
                            <span class="text-sm font-medium text-gray-700 group-hover:text-gray-900">Nuevo Usuario</span>
                        </a>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection

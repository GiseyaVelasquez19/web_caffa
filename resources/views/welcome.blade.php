<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Web Caffa - Café en Grano con Sabores</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-gradient-to-br from-amber-50 to-amber-100 min-h-screen">
        <header class="bg-amber-900 text-white shadow-lg">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-3">
                        <div class="text-3xl">☕</div>
                        <div>
                            <h1 class="text-2xl font-bold">Web Caffa</h1>
                            <p class="text-sm text-amber-100">Café en Grano con Sabores</p>
                        </div>
                    </div>
                    <nav class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-amber-700 hover:bg-amber-600 px-4 py-2 rounded-lg transition">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-amber-700 hover:bg-amber-600 px-4 py-2 rounded-lg transition">
                                Iniciar Sesión
                            </a>
                        @endauth
                    </nav>
                </div>
            </div>
        </header>

        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-amber-900 mb-4">Bienvenido a Caffa</h2>
                    <p class="text-gray-700 mb-6">
                        Caffa es tu plataforma de gestión para vender café en grano con una variedad de sabores únicos y deliciosos.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <span class="text-2xl">☕</span>
                            <div>
                                <h3 class="font-semibold text-amber-900">Café Premium</h3>
                                <p class="text-sm text-gray-600">Granos seleccionados y tostados artesanalmente</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="text-2xl">🎯</span>
                            <div>
                                <h3 class="font-semibold text-amber-900">Sabores Variados</h3>
                                <p class="text-sm text-gray-600">Clásico, Chocolate, Vainilla, Caramelo y más</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="text-2xl">🚀</span>
                            <div>
                                <h3 class="font-semibold text-amber-900">Gestión Completa</h3>
                                <p class="text-sm text-gray-600">Sistema de administración profesional</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-lg shadow-lg p-8">
                    <h2 class="text-3xl font-bold text-amber-900 mb-4">Nuestros Sabores</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-amber-50 p-4 rounded-lg">
                            <p class="font-semibold text-amber-900">Clásico</p>
                            <p class="text-sm text-gray-600">Sabor tradicional</p>
                        </div>
                        <div class="bg-amber-50 p-4 rounded-lg">
                            <p class="font-semibold text-amber-900">Chocolate</p>
                            <p class="text-sm text-gray-600">Notas de cacao</p>
                        </div>
                        <div class="bg-amber-50 p-4 rounded-lg">
                            <p class="font-semibold text-amber-900">Vainilla</p>
                            <p class="text-sm text-gray-600">Suave y aromático</p>
                        </div>
                        <div class="bg-amber-50 p-4 rounded-lg">
                            <p class="font-semibold text-amber-900">Caramelo</p>
                            <p class="text-sm text-gray-600">Dulce y sofisticado</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-lg shadow-lg p-8 mb-12">
                <h2 class="text-2xl font-bold text-amber-900 mb-6">¿Por qué elegir Caffa?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-4xl mb-3">🌍</div>
                        <h3 class="font-semibold text-amber-900 mb-2">Café de Calidad</h3>
                        <p class="text-gray-600 text-sm">Seleccionamos los mejores granos de café de todo el mundo</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl mb-3">🎨</div>
                        <h3 class="font-semibold text-amber-900 mb-2">Sabores Únicos</h3>
                        <p class="text-gray-600 text-sm">Aromatizamos nuestro café con sabores naturales y deliciosos</p>
                    </div>
                    <div class="text-center">
                        <div class="text-4xl mb-3">📦</div>
                        <h3 class="font-semibold text-amber-900 mb-2">Entrega Rápida</h3>
                        <p class="text-gray-600 text-sm">Recibe tu café fresco en la puerta de tu casa</p>
                    </div>
                </div>
            </div>

            <div class="text-center">
                <h2 class="text-2xl font-bold text-amber-900 mb-4">¿Listo para comenzar?</h2>
                <p class="text-gray-700 mb-6">Inicia sesión en tu cuenta para acceder al panel de administración</p>
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-block bg-amber-900 hover:bg-amber-800 text-white font-bold py-3 px-8 rounded-lg transition">
                        Ir al Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-block bg-amber-900 hover:bg-amber-800 text-white font-bold py-3 px-8 rounded-lg transition">
                        Iniciar Sesión
                    </a>
                @endauth
            </div>
        </main>

        <footer class="bg-amber-900 text-white text-center py-6 mt-12">
            <p>&copy; 2026 Web Caffa - Café en Grano. Todos los derechos reservados.</p>
        </footer>
    </body>
</html>

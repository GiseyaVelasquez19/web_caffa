<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Web Caffa - Café en Grano con Sabores</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="bg-[#FAF7F4] min-h-screen">
        <!-- Header -->
        <header class="text-white shadow-lg" style="background: linear-gradient(135deg, #6F4E37 0%, #5A3E2B 100%)">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                <div class="flex justify-between items-center">
                    <a href="/" class="flex items-center space-x-3">
                        <img src="{{ asset('images/logo_web_caffa.png') }}" alt="Logo Caffa" class="h-12 w-auto">
                        <div>
                            <h1 class="text-2xl font-bold">Web Caffa</h1>
                            <p class="text-sm text-white/70">Café en Grano con Sabores</p>
                        </div>
                    </a>
                    <nav class="flex items-center space-x-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition text-sm font-medium backdrop-blur-sm">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-white text-[#6F4E37] hover:bg-white/90 px-4 py-2 rounded-lg transition text-sm font-medium">
                                Iniciar Sesión
                            </a>
                        @endauth
                    </nav>
                </div>
            </div>
        </header>

        <!-- Hero Banner -->
        <section class="relative overflow-hidden" style="background: url('{{ asset("images/dasboard_cafe.png") }}') center/cover no-repeat, linear-gradient(135deg, #6F4E37 0%, #5A3E2B 50%, #4A3325 100%)">
            <div class="absolute inset-0 bg-gradient-to-r from-[#4A3325]/90 via-[#4A3325]/70 to-transparent"></div>
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-28">
                <div class="max-w-2xl">
                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                        Café Premium <br><span class="text-white/80">Colombiano</span>
                    </h1>
                    <p class="text-xl text-white/80 mb-8">
                        Descubre la exquisitez de nuestros granos seleccionados y tostados artesanalmente.
                    </p>
                    <div class="flex gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="bg-white text-[#6F4E37] hover:bg-white/90 px-6 py-3 rounded-lg transition font-medium">
                                Ir al Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="bg-white text-[#6F4E37] hover:bg-white/90 px-6 py-3 rounded-lg transition font-medium">
                                Iniciar Sesión
                            </a>
                        @endauth
                        <a href="#features" class="bg-white/20 hover:bg-white/30 text-white px-6 py-3 rounded-lg transition font-medium backdrop-blur-sm">
                            Conocer Más
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features -->
        <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16" id="features">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
                <!-- About -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Bienvenido a Caffa</h2>
                    <p class="text-gray-600 mb-6">
                        Caffa es tu plataforma de gestión para vender café en grano con una variedad de sabores únicos y deliciosos.
                    </p>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <span class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">☕</span>
                            <div>
                                <h3 class="font-semibold text-gray-800">Café Premium</h3>
                                <p class="text-sm text-gray-500">Granos seleccionados y tostados artesanalmente</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">🎯</span>
                            <div>
                                <h3 class="font-semibold text-gray-800">Sabores Variados</h3>
                                <p class="text-sm text-gray-500">Clásico, Chocolate, Vainilla, Caramelo y más</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-3">
                            <span class="w-10 h-10 rounded-lg flex items-center justify-center text-lg" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">🚀</span>
                            <div>
                                <h3 class="font-semibold text-gray-800">Gestión Completa</h3>
                                <p class="text-sm text-gray-500">Sistema de administración profesional</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Flavors -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h2 class="text-2xl font-bold text-gray-800 mb-4">Nuestros Sabores</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 rounded-xl" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">
                            <p class="font-semibold text-gray-800">Clásico</p>
                            <p class="text-sm text-gray-500">Sabor tradicional</p>
                        </div>
                        <div class="p-4 rounded-xl" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">
                            <p class="font-semibold text-gray-800">Chocolate</p>
                            <p class="text-sm text-gray-500">Notas de cacao</p>
                        </div>
                        <div class="p-4 rounded-xl" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">
                            <p class="font-semibold text-gray-800">Vainilla</p>
                            <p class="text-sm text-gray-500">Suave y aromático</p>
                        </div>
                        <div class="p-4 rounded-xl" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">
                            <p class="font-semibold text-gray-800">Caramelo</p>
                            <p class="text-sm text-gray-500">Dulce y sofisticado</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Why Choose Us -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 mb-16">
                <h2 class="text-2xl font-bold text-gray-800 mb-8 text-center">¿Por qué elegir Caffa?</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">🌍</div>
                        <h3 class="font-semibold text-gray-800 mb-2">Café de Calidad</h3>
                        <p class="text-gray-500 text-sm">Seleccionamos los mejores granos de café de todo el mundo</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">🎨</div>
                        <h3 class="font-semibold text-gray-800 mb-2">Sabores Únicos</h3>
                        <p class="text-gray-500 text-sm">Aromatizamos nuestro café con sabores naturales y deliciosos</p>
                    </div>
                    <div class="text-center">
                        <div class="w-16 h-16 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-4" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">📦</div>
                        <h3 class="font-semibold text-gray-800 mb-2">Entrega Rápida</h3>
                        <p class="text-gray-500 text-sm">Recibe tu café fresco en la puerta de tu casa</p>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">¿Listo para comenzar?</h2>
                <p class="text-gray-600 mb-6">Inicia sesión en tu cuenta para acceder al panel de administración</p>
                @auth
                    <a href="{{ url('/dashboard') }}" class="inline-block text-white font-medium py-3 px-8 rounded-lg transition" style="background-color: #6F4E37" onmouseover="this.style.backgroundColor='#5A3E2B'" onmouseout="this.style.backgroundColor='#6F4E37'">
                        Ir al Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-block text-white font-medium py-3 px-8 rounded-lg transition" style="background-color: #6F4E37" onmouseover="this.style.backgroundColor='#5A3E2B'" onmouseout="this.style.backgroundColor='#6F4E37'">
                        Iniciar Sesión
                    </a>
                @endauth
            </div>
        </main>

        <!-- Footer -->
        <footer class="text-white text-center py-6 mt-12" style="background: linear-gradient(135deg, #6F4E37 0%, #5A3E2B 100%)">
            <p>&copy; 2026 Web Caffa - Café en Grano. Todos los derechos reservados.</p>
        </footer>
    </body>
</html>

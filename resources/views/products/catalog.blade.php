<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo - Web Caffa</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FAF7F4] min-h-screen">
    <!-- Header -->
    <header class="text-white shadow-lg" style="background: linear-gradient(135deg, #6F4E37 0%, #5A3E2B 100%)">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex justify-between items-center">
                <a href="/" class="flex items-center space-x-3">
                    <img src="{{ asset('images/logo_web_caffa.png') }}" alt="Logo Caffa" class="h-12 w-auto">
                    <span class="text-xl font-bold">Web Caffa</span>
                </a>
                <nav class="flex items-center space-x-4">
                    <a href="/" class="text-white/80 hover:text-white transition text-sm">Inicio</a>
                    @auth
                        <a href="{{ route('cart.index') }}" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg transition text-sm font-medium">
                            🛒 Carrito
                        </a>
                        <a href="{{ url('/dashboard') }}" class="bg-white text-[#6F4E37] hover:bg-white/90 px-4 py-2 rounded-lg transition text-sm font-medium">
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

    <!-- Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="text-center mb-10">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Nuestros Cafés</h1>
            <p class="text-gray-500">Explora nuestra selección de granos premium colombianos</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                    <div class="h-48 bg-gradient-to-br from-[#F5EDE6] to-[#EDE0D4] flex items-center justify-center relative overflow-hidden">
                        @if ($product->imagen)
                            <img src="{{ Storage::url($product->imagen) }}" alt="{{ $product->nombre }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                        @else
                            <span class="text-7xl opacity-60 group-hover:scale-110 transition duration-300">☕</span>
                        @endif
                        @if ($product->stock <= 5 && $product->stock > 0)
                            <span class="absolute top-3 right-3 bg-amber-500 text-white text-xs px-2 py-1 rounded-full font-medium">
                                Últimas {{ $product->stock }} unidades
                            </span>
                        @endif
                    </div>

                    <div class="p-5">
                        <p class="text-xs font-medium mb-1" style="color: #6F4E37">{{ $product->category->nombre ?? 'Sin categoría' }}</p>
                        <h3 class="font-semibold text-gray-800 mb-1">{{ $product->nombre }}</h3>
                        @if ($product->descripcion)
                            <p class="text-gray-500 text-sm mb-3 line-clamp-2">{{ $product->descripcion }}</p>
                        @endif

                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-gray-800">${{ number_format($product->precio, 0, ',', '.') }}</span>

                            @auth
                                <form method="POST" action="{{ route('cart.add') }}">
                                    @csrf
                                    <input type="hidden" name="producto_id" value="{{ $product->id }}">
                                    <input type="hidden" name="cantidad" value="1">
                                    <button type="submit" class="text-white px-4 py-2 rounded-lg transition text-sm font-medium" style="background-color: #6F4E37" onmouseover="this.style.backgroundColor='#5A3E2B'" onmouseout="this.style.backgroundColor='#6F4E37'">
                                        + Carrito
                                    </button>
                                </form>
                            @else
                                <a href="{{ route('login') }}" class="text-sm font-medium hover:underline" style="color: #6F4E37">
                                    Iniciar sesión para comprar
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @if ($products->hasPages())
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </main>

    <!-- Footer -->
    <footer class="text-white text-center py-6 mt-12" style="background: linear-gradient(135deg, #6F4E37 0%, #5A3E2B 100%)">
        <p>&copy; 2026 Web Caffa - Café en Grano. Todos los derechos reservados.</p>
    </footer>
</body>
</html>

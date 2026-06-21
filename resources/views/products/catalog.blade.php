@extends('layouts.app')

@section('title', 'Catálogo - Caffa')

@section('content')
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-800">Nuestros Cafés</h1>
        <p class="text-gray-500 text-sm">Explora nuestra selección de granos premium colombianos</p>
    </div>

    @if ($products->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-[#F5EDE6] flex items-center justify-center">
                <i class="fas fa-mug-hot text-3xl" style="color: #6F4E37"></i>
            </div>
            <h3 class="text-lg font-semibold text-gray-700 mb-2">No hay productos disponibles</h3>
            <p class="text-gray-500 text-sm">Pronto tendremos nuevos cafés en nuestro catálogo.</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($products as $product)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition group">
                <div class="h-48 bg-gradient-to-br from-[#F5EDE6] to-[#EDE0D4] flex items-center justify-center relative overflow-hidden">
                    @if ($product->imagen)
                        <img src="{{ Storage::url($product->imagen) }}" alt="{{ $product->nombre }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                    @else
                        <i class="fas fa-mug-hot text-7xl opacity-60 group-hover:scale-110 transition duration-300" style="color: #6F4E37"></i>
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
    @endif
@endsection

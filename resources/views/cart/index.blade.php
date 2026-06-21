@extends('layouts.app')

@section('title', 'Carrito de Compras - Caffa')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Carrito de Compras</h1>
        <p class="text-gray-500 text-sm">Revisa los productos antes de comprar</p>
    </div>

    @if ($items->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="text-6xl mb-4">🛒</div>
            <p class="text-gray-500 mb-2">Tu carrito está vacío</p>
            <p class="text-gray-400 text-sm mb-4">Explora nuestro catálogo de cafés premium</p>
            <a href="{{ route('products.catalog') }}" class="inline-flex items-center gap-2 text-white px-5 py-2.5 rounded-lg transition text-sm font-medium" style="background-color: #6F4E37">
                Ver Catálogo
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach ($items as $item)
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 flex gap-4">
                        <div class="w-20 h-20 rounded-xl flex items-center justify-center text-3xl flex-shrink-0" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">
                            @if ($item->producto->imagen)
                                <img src="{{ Storage::url($item->producto->imagen) }}" alt="{{ $item->producto->nombre }}" class="w-full h-full object-cover rounded-xl">
                            @else
                                ☕
                            @endif
                        </div>

                        <div class="flex-1">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h3 class="font-semibold text-gray-800">{{ $item->producto->nombre }}</h3>
                                    <p class="text-sm text-gray-500">${{ number_format($item->precio_unitario, 0, ',', '.') }} c/u</p>
                                </div>
                                <form method="POST" action="{{ route('cart.remove', $item) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-400 hover:text-red-600 text-sm">
                                        ✕
                                    </button>
                                </form>
                            </div>

                            <div class="flex items-center justify-between mt-3">
                                <form method="POST" action="{{ route('cart.update', $item) }}" class="flex items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="cantidad" value="{{ max(1, $item->cantidad - 1) }}">
                                    <button type="submit" class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50">
                                        −
                                    </button>
                                </form>

                                <span class="font-medium text-gray-800">{{ $item->cantidad }}</span>

                                <form method="POST" action="{{ route('cart.update', $item) }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="cantidad" value="{{ $item->cantidad + 1 }}">
                                    <button type="submit" class="w-8 h-8 rounded-lg border border-gray-200 flex items-center justify-center text-gray-500 hover:bg-gray-50">
                                        +
                                    </button>
                                </form>

                                <span class="font-bold text-gray-800">${{ number_format($item->subtotal, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach

                <form method="POST" action="{{ route('cart.clear') }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-gray-500 hover:text-red-500 transition">
                        🗑️ Vaciar carrito
                    </button>
                </form>
            </div>

            <!-- Resumen -->
            <div class="lg:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sticky top-6">
                    <h2 class="font-semibold text-gray-800 mb-4">Resumen del Pedido</h2>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Subtotal ({{ $items->sum('cantidad') }} items)</span>
                            <span class="text-gray-800">${{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">IVA (19%)</span>
                            <span class="text-gray-800">${{ number_format($impuestos, 0, ',', '.') }}</span>
                        </div>
                        <div class="border-t border-gray-100 pt-3 flex justify-between">
                            <span class="font-semibold text-gray-800">Total</span>
                            <span class="font-bold text-lg text-gray-800">${{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('orders.store') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Dirección de envío</label>
                            <input type="text" name="direccion_envio" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent outline-none transition text-sm"
                                placeholder="Calle, número, barrio...">
                            @error('direccion_envio')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Teléfono</label>
                            <input type="text" name="telefono" required
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent outline-none transition text-sm"
                                placeholder="300 123 4567">
                            @error('telefono')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Notas (opcional)</label>
                            <textarea name="notas" rows="2"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent outline-none transition text-sm"
                                placeholder="Instrucciones de entrega..."></textarea>
                        </div>

                        <button type="submit" class="w-full text-white font-medium py-3 px-4 rounded-lg transition" style="background-color: #6F4E37" onmouseover="this.style.backgroundColor='#5A3E2B'" onmouseout="this.style.backgroundColor='#6F4E37'">
                            Confirmar Pedido
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection

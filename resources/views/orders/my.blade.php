@extends('layouts.app')

@section('title', 'Mis Pedidos - Caffa')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mis Pedidos</h1>
        <p class="text-gray-500 text-sm">Historial de tus compras</p>
    </div>

    @if ($pedidos->isEmpty())
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-12 text-center">
            <div class="w-20 h-20 rounded-full flex items-center justify-center text-4xl mx-auto mb-4" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">
                <i class="fas fa-box" style="color: #6F4E37"></i>
            </div>
            <p class="text-gray-500 mb-2">Aún no tienes pedidos</p>
            <p class="text-gray-400 text-sm mb-4">Explora nuestro catálogo y realiza tu primera compra</p>
            <a href="{{ route('products.catalog') }}" class="inline-flex items-center gap-2 text-white px-5 py-2.5 rounded-lg transition text-sm font-medium" style="background-color: #6F4E37">
                Ver Catálogo
            </a>
        </div>
    @else
        <div class="space-y-4">
            @foreach ($pedidos as $pedido)
                <a href="{{ route('orders.show.my', $pedido) }}" class="block bg-white rounded-2xl shadow-sm border border-gray-100 p-5 hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">
                                <i class="fas fa-box" style="color: #6F4E37"></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-800">{{ $pedido->codigo_pedido }}</h3>
                                <p class="text-sm text-gray-500">{{ $pedido->created_at->format('d/m/Y H:i') }} · {{ $pedido->detalles->count() }} productos</p>
                            </div>
                        </div>
                        <div class="text-right">
                            @php
                                $color = match($pedido->estado) {
                                    'pendiente' => 'amber',
                                    'en_proceso' => 'blue',
                                    'enviado' => 'purple',
                                    'entregado' => 'green',
                                    'cancelado' => 'red',
                                    default => 'gray',
                                };
                            @endphp
                            <span class="inline-block bg-{{ $color }}-100 text-{{ $color }}-700 px-2 py-1 rounded-full text-xs font-medium mb-1">
                                {{ $pedido->estado_label }}
                            </span>
                            <p class="font-bold text-gray-800">${{ number_format($pedido->total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $pedidos->links() }}
        </div>
    @endif
@endsection

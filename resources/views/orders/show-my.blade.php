@extends('layouts.app')

@section('title', 'Detalle Pedido - Caffa')

@section('content')
    <div class="mb-6">
        <a href="{{ route('orders.my') }}" class="text-sm font-medium hover:underline" style="color: #6F4E37">
            ← Volver a Mis Pedidos
        </a>
        <div class="flex items-center justify-between mt-2">
            <h1 class="text-2xl font-bold text-gray-800">Pedido {{ $order->codigo_pedido }}</h1>
            @php
                $color = match($order->estado) {
                    'pendiente' => 'amber',
                    'en_proceso' => 'blue',
                    'enviado' => 'purple',
                    'entregado' => 'green',
                    'cancelado' => 'red',
                    default => 'gray',
                };
            @endphp
            <span class="inline-block bg-{{ $color }}-100 text-{{ $color }}-700 px-3 py-1.5 rounded-full text-sm font-medium">
                {{ $order->estado_label }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-gray-800 mb-4">Productos</h2>
                <div class="space-y-4">
                    @foreach ($order->detalles as $detalle)
                        <div class="flex gap-4 items-center">
                            <div class="w-14 h-14 rounded-xl flex items-center justify-center text-2xl flex-shrink-0" style="background: linear-gradient(135deg, #F5EDE6 0%, #EDE0D4 100%)">
                                @if ($detalle->producto->imagen)
                                    <img src="{{ Storage::url($detalle->producto->imagen) }}" alt="{{ $detalle->producto->nombre }}" class="w-full h-full object-cover rounded-xl">
                                @else
                                    ☕
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-medium text-gray-800">{{ $detalle->producto->nombre }}</h3>
                                <p class="text-sm text-gray-500">{{ $detalle->cantidad }} x ${{ number_format($detalle->precio_unitario, 0, ',', '.') }}</p>
                            </div>
                            <span class="font-semibold text-gray-800">${{ number_format($detalle->subtotal, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Shipping -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-gray-800 mb-4">Dirección de Envío</h2>
                <p class="text-gray-600 text-sm">{{ $order->direccion_envio }}</p>
                <p class="text-gray-500 text-xs mt-2">Tel: {{ $order->telefono }}</p>
            </div>

            <!-- Summary -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-gray-800 mb-4">Resumen</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="text-gray-800">${{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">IVA (19%)</span>
                        <span class="text-gray-800">${{ number_format($order->impuestos, 0, ',', '.') }}</span>
                    </div>
                    <div class="border-t border-gray-100 pt-2 flex justify-between">
                        <span class="font-semibold text-gray-800">Total</span>
                        <span class="font-bold text-lg text-gray-800">${{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            @if ($order->notas)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="font-semibold text-gray-800 mb-2">Tus Notas</h2>
                    <p class="text-gray-600 text-sm">{{ $order->notas }}</p>
                </div>
            @endif

            <!-- Status Timeline -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-gray-800 mb-4">Estado del Pedido</h2>
                <div class="space-y-3">
                    @foreach (['pendiente' => 'Pedido recibido', 'en_proceso' => 'En preparación', 'enviado' => 'En camino', 'entregado' => 'Entregado'] as $estado => $label)
                        @php
                            $estados = ['pendiente', 'en_proceso', 'enviado', 'entregado'];
                            $currentIndex = array_search($order->estado, $estados);
                            $labelIndex = array_search($estado, $estados);
                            $isActive = $labelIndex <= $currentIndex && $order->estado !== 'cancelado';
                            $isCurrent = $estado === $order->estado;
                        @endphp
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full {{ $isActive ? 'bg-green-500' : 'bg-gray-200' }} {{ $isCurrent ? 'ring-2 ring-green-200' : '' }}"></div>
                            <span class="text-sm {{ $isActive ? 'text-gray-800 font-medium' : 'text-gray-400' }}">{{ $label }}</span>
                        </div>
                    @endforeach

                    @if ($order->estado === 'cancelado')
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-red-500 ring-2 ring-red-200"></div>
                            <span class="text-sm text-red-600 font-medium">Cancelado</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('title', 'Detalle Pedido - Caffa')

@section('content')
    <div class="mb-6">
        <a href="{{ route('orders.index') }}" class="text-sm font-medium hover:underline" style="color: #6F4E37">
            ← Volver a Pedidos
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
        <div class="lg:col-span-2 space-y-6">
            <!-- Items -->
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

            <!-- Notes -->
            @if ($order->notas)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="font-semibold text-gray-800 mb-2">Notas del cliente</h2>
                    <p class="text-gray-600 text-sm">{{ $order->notas }}</p>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Client Info -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-gray-800 mb-4">Cliente</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Nombre</span>
                        <span class="text-gray-800 font-medium">{{ $order->cliente->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Email</span>
                        <span class="text-gray-800 font-medium">{{ $order->cliente->email }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-500">Teléfono</span>
                        <span class="text-gray-800 font-medium">{{ $order->telefono }}</span>
                    </div>
                </div>
            </div>

            <!-- Shipping -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-gray-800 mb-4">Envío</h2>
                <p class="text-gray-600 text-sm">{{ $order->direccion_envio }}</p>
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

            <!-- Actions -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="font-semibold text-gray-800 mb-4">Acciones</h2>
                <div class="space-y-3">
                    @if ($order->estado === 'pendiente')
                        <form method="POST" action="{{ route('orders.process', $order) }}">
                            @csrf
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2.5 px-4 rounded-lg transition text-sm">
                                Procesar Pedido
                            </button>
                        </form>
                    @endif

                    @if (in_array($order->estado, ['en_proceso', 'pendiente']))
                        <form method="POST" action="{{ route('orders.updateStatus', $order) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="estado" value="enviado">
                            <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-medium py-2.5 px-4 rounded-lg transition text-sm">
                                Marcar como Enviado
                            </button>
                        </form>
                    @endif

                    @if ($order->estado === 'enviado')
                        <form method="POST" action="{{ route('orders.updateStatus', $order) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="estado" value="entregado">
                            <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white font-medium py-2.5 px-4 rounded-lg transition text-sm">
                                Marcar como Entregado
                            </button>
                        </form>
                    @endif

                    @if (!in_array($order->estado, ['entregado', 'cancelado']))
                        <form method="POST" action="{{ route('orders.updateStatus', $order) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="estado" value="cancelado">
                            <button type="submit" class="w-full bg-red-100 hover:bg-red-200 text-red-700 font-medium py-2.5 px-4 rounded-lg transition text-sm"
                                onclick="return confirm('¿Estás seguro de cancelar este pedido?')">
                                Cancelar Pedido
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Seller Info -->
            @if ($order->vendedor)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="font-semibold text-gray-800 mb-2">Procesado por</h2>
                    <p class="text-gray-600 text-sm">{{ $order->vendedor->name }}</p>
                </div>
            @endif
        </div>
    </div>
@endsection

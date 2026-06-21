@extends('layouts.app')

@section('title', 'Pedidos - Caffa')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Pedidos</h1>
            <p class="text-gray-500 text-sm">Gestiona los pedidos de la tienda</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
        <form method="GET" class="flex flex-wrap gap-4 items-center">
            <div class="flex-1 min-w-[200px]">
                <input type="text" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por código, nombre o email..."
                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent outline-none transition text-sm">
            </div>
            <select name="estado" class="px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:border-transparent outline-none transition text-sm">
                <option value="">Todos los estados</option>
                <option value="pendiente" {{ request('estado') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                <option value="en_proceso" {{ request('estado') == 'en_proceso' ? 'selected' : '' }}>En Proceso</option>
                <option value="enviado" {{ request('estado') == 'enviado' ? 'selected' : '' }}>Enviado</option>
                <option value="entregado" {{ request('estado') == 'entregado' ? 'selected' : '' }}>Entregado</option>
                <option value="cancelado" {{ request('estado') == 'cancelado' ? 'selected' : '' }}>Cancelado</option>
            </select>
            <button type="submit" class="text-white px-5 py-2.5 rounded-lg transition text-sm font-medium" style="background-color: #6F4E37">
                Filtrar
            </button>
        </form>
    </div>

    <!-- Orders Table -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px]">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Código</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase hidden sm:table-cell">Cliente</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Estado</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase hidden md:table-cell">Fecha</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($pedidos as $pedido)
                        <tr class="hover:bg-gray-50 transition">
                            <td class="px-6 py-4">
                                <span class="font-mono text-sm font-medium text-gray-800">{{ $pedido->codigo_pedido }}</span>
                                <p class="text-xs text-gray-500 sm:hidden mt-1">{{ $pedido->cliente->name }}</p>
                                <p class="text-xs text-gray-400 md:hidden mt-1">{{ $pedido->created_at->format('d/m/Y') }}</p>
                            </td>
                            <td class="px-6 py-4 hidden sm:table-cell">
                                <p class="text-sm font-medium text-gray-800">{{ $pedido->cliente->name }}</p>
                                <p class="text-xs text-gray-500">{{ $pedido->cliente->email }}</p>
                            </td>
                        <td class="px-6 py-4">
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
                            <span class="inline-block bg-{{ $color }}-100 text-{{ $color }}-700 px-2 py-1 rounded-full text-xs font-medium">
                                {{ $pedido->estado_label }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-gray-800">${{ number_format($pedido->total, 0, ',', '.') }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 hidden md:table-cell">
                            {{ $pedido->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4">
                            <a href="{{ route('orders.show', $pedido) }}" class="text-sm font-medium hover:underline" style="color: #6F4E37">
                                Ver detalle
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-8 text-center text-gray-400 text-sm">
                            No hay pedidos registrados
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-4">
        {{ $pedidos->withQueryString()->links() }}
    </div>
@endsection

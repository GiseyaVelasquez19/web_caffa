<?php

namespace App\Http\Controllers;

use App\Models\CarritoItem;
use App\Models\Pedido;
use App\Models\PedidoDetalle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        auth()->user()->can('orders view') ?: abort(403);

        $query = Pedido::with(['cliente', 'vendedor', 'detalles.producto']);

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function ($q) use ($buscar) {
                $q->where('codigo_pedido', 'like', "%{$buscar}%")
                    ->orWhereHas('cliente', fn ($q) => $q->where('name', 'like', "%{$buscar}%"))
                    ->orWhereHas('cliente', fn ($q) => $q->where('email', 'like', "%{$buscar}%"));
            });
        }

        $pedidos = $query->latest()->paginate(15);

        return view('orders.index', compact('pedidos'));
    }

    public function show(Pedido $order)
    {
        auth()->user()->can('orders view') ?: abort(403);

        $order->load(['cliente', 'vendedor', 'detalles.producto']);

        return view('orders.show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'direccion_envio' => 'required|string|max:255',
            'telefono' => 'required|string|max:20',
            'notas' => 'nullable|string|max:500',
        ]);

        $items = CarritoItem::where('user_id', auth()->id())
            ->with('producto')
            ->get();

        if ($items->isEmpty()) {
            return back()->with('error', 'El carrito está vacío.');
        }

        foreach ($items as $item) {
            if ($item->cantidad > $item->producto->stock) {
                return back()->with('error', "No hay suficiente stock para {$item->producto->nombre}.");
            }
        }

        DB::beginTransaction();

        try {
            $subtotal = $items->sum(fn ($item) => $item->cantidad * $item->precio_unitario);
            $impuestos = $subtotal * 0.19;
            $total = $subtotal + $impuestos;

            $pedido = Pedido::create([
                'user_id' => auth()->id(),
                'codigo_pedido' => Pedido::generateCodigo(),
                'estado' => 'pendiente',
                'subtotal' => $subtotal,
                'impuestos' => $impuestos,
                'total' => $total,
                'direccion_envio' => $request->direccion_envio,
                'telefono' => $request->telefono,
                'notas' => $request->notas,
            ]);

            foreach ($items as $item) {
                PedidoDetalle::create([
                    'pedido_id' => $pedido->id,
                    'producto_id' => $item->producto_id,
                    'cantidad' => $item->cantidad,
                    'precio_unitario' => $item->precio_unitario,
                    'subtotal' => $item->cantidad * $item->precio_unitario,
                ]);

                $item->producto->decrement('stock', $item->cantidad);
            }

            CarritoItem::where('user_id', auth()->id())->delete();

            DB::commit();

            return redirect()->route('orders.show.my', $pedido)
                ->with('success', 'Pedido creado exitosamente. Código: '.$pedido->codigo_pedido);

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Error al crear el pedido. Inténtalo de nuevo.');
        }
    }

    public function myOrders()
    {
        $pedidos = Pedido::where('user_id', auth()->id())
            ->with('detalles.producto')
            ->latest()
            ->paginate(15);

        return view('orders.my', compact('pedidos'));
    }

    public function showMyOrder(Pedido $order)
    {
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }

        $order->load(['detalles.producto']);

        return view('orders.show-my', compact('order'));
    }

    public function process(Pedido $order)
    {
        auth()->user()->can('orders edit') ?: abort(403);

        if ($order->estado !== 'pendiente') {
            return back()->with('error', 'Solo se pueden procesar pedidos pendientes.');
        }

        $order->update([
            'estado' => 'en_proceso',
            'vendedor_id' => auth()->id(),
        ]);

        return back()->with('success', 'Pedido en proceso.');
    }

    public function updateStatus(Request $request, Pedido $order)
    {
        auth()->user()->can('orders edit') ?: abort(403);

        $request->validate([
            'estado' => 'required|in:enviado,entregado,cancelado',
        ]);

        $order->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado del pedido actualizado.');
    }
}

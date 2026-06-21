<?php

namespace App\Http\Controllers;

use App\Models\CarritoItem;
use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $items = CarritoItem::where('user_id', auth()->id())
            ->with('producto')
            ->get();

        $subtotal = $items->sum(fn ($item) => $item->cantidad * $item->precio_unitario);
        $impuestos = $subtotal * 0.19;
        $total = $subtotal + $impuestos;

        return view('cart.index', compact('items', 'subtotal', 'impuestos', 'total'));
    }

    public function add(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->producto_id);

        if ($product->stock < $request->cantidad) {
            return back()->with('error', 'No hay suficiente stock disponible.');
        }

        $existingItem = CarritoItem::where('user_id', auth()->id())
            ->where('producto_id', $request->producto_id)
            ->first();

        if ($existingItem) {
            $newCantidad = $existingItem->cantidad + $request->cantidad;
            if ($newCantidad > $product->stock) {
                return back()->with('error', 'No hay suficiente stock para esta cantidad.');
            }
            $existingItem->update(['cantidad' => $newCantidad]);
        } else {
            CarritoItem::create([
                'user_id' => auth()->id(),
                'producto_id' => $request->producto_id,
                'cantidad' => $request->cantidad,
                'precio_unitario' => $product->precio,
            ]);
        }

        return back()->with('success', 'Producto agregado al carrito.');
    }

    public function update(Request $request, CarritoItem $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }

        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        if ($request->cantidad > $item->producto->stock) {
            return back()->with('error', 'No hay suficiente stock disponible.');
        }

        $item->update(['cantidad' => $request->cantidad]);

        return back()->with('success', 'Carrito actualizado.');
    }

    public function remove(CarritoItem $item)
    {
        if ($item->user_id !== auth()->id()) {
            abort(403);
        }

        $item->delete();

        return back()->with('success', 'Producto eliminado del carrito.');
    }

    public function clear()
    {
        CarritoItem::where('user_id', auth()->id())->delete();

        return back()->with('success', 'Carrito vaciado.');
    }
}

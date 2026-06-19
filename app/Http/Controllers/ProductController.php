<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        auth()->user()->can('products view') ?: abort(403);

        $products = Product::with('category')->orderBy('nombre')->paginate(15);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        auth()->user()->can('products create') ?: abort(403);

        $categories = Category::orderBy('nombre')->get();

        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        auth()->user()->can('products create') ?: abort(403);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:productos',
            'codigo' => 'nullable|string|max:50|unique:productos',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        Product::create($validated);

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    public function show(Product $product)
    {
        return redirect()->route('products.index');
    }

    public function edit(Product $product)
    {
        auth()->user()->can('products edit') ?: abort(403);

        $categories = Category::orderBy('nombre')->get();

        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        auth()->user()->can('products edit') ?: abort(403);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:productos,nombre,'.$product->id,
            'codigo' => 'nullable|string|max:50|unique:productos,codigo,'.$product->id,
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'categoria_id' => 'required|exists:categorias,id',
            'imagen' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $validated['imagen'] = $request->file('imagen')->store('productos', 'public');
        }

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy(Product $product)
    {
        auth()->user()->can('products delete') ?: abort(403);

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }
}

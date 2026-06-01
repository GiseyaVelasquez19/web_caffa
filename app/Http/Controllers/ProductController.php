<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        auth()->user()->can('products view') ?: abort(403);

        return view('products.index');
    }

    public function create()
    {
        auth()->user()->can('products create') ?: abort(403);

        return view('products.create');
    }

    public function store(Request $request)
    {
        auth()->user()->can('products create') ?: abort(403);

        return redirect()->route('products.index')->with('success', 'Producto creado exitosamente.');
    }

    public function edit($id)
    {
        auth()->user()->can('products edit') ?: abort(403);

        return view('products.edit');
    }

    public function update(Request $request, $id)
    {
        auth()->user()->can('products edit') ?: abort(403);

        return redirect()->route('products.index')->with('success', 'Producto actualizado exitosamente.');
    }

    public function destroy($id)
    {
        auth()->user()->can('products delete') ?: abort(403);

        return redirect()->route('products.index')->with('success', 'Producto eliminado exitosamente.');
    }
}

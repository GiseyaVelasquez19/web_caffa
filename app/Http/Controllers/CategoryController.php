<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        auth()->user()->can('categories view') ?: abort(403);
        $categories = Category::orderBy('nombre')->paginate(15);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        auth()->user()->can('categories create') ?: abort(403);

        return view('categories.create');
    }

    public function store(Request $request)
    {
        auth()->user()->can('categories create') ?: abort(403);

        $validated = $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
        ]);

        Category::create([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
        ]);

        return redirect()->route('categories.index')->with('success', 'Categoria creada exitosamente.');
    }

    public function edit(Category $category)
    {
        auth()->user()->can('categories edit') ?: abort(403);

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        auth()->user()->can('categories edit') ?: abort(403);

        $validated = $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'required|string',
        ]);

        $category->update([
            'nombre' => $validated['nombre'],
            'descripcion' => $validated['descripcion'],
        ]);

        return redirect()->route('categories.index')->with('success', 'Categoria actualizada exitosamente.');
    }

    public function destroy(Category $category)
    {
        auth()->user()->can('categories delete') ?: abort(403);

        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Categoria eliminada exitosamente.');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Lista svih kategorija
     */
    public function index()
    {
        $categories = Category::withCount('products')->get();

        return response()->json([
            'data' => $categories,
        ]);
    }

    /**
     * Kreiranje nove kategorije (Admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Kategorija kreirana',
            'data' => $category,
        ], 201);
    }

    /**
     * Prikaz jedne kategorije sa proizvodima
     */
    public function show(Category $category)
    {
        return response()->json([
            'data' => $category->load('products'),
        ]);
    }

    /**
     * Ažuriranje kategorije (Admin)
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50|unique:categories,name,'.$category->id,
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Kategorija ažurirana',
            'data' => $category,
        ]);
    }

    /**
     * Brisanje kategorije (Admin)
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Kategorija obrisana',
        ]);
    }
}

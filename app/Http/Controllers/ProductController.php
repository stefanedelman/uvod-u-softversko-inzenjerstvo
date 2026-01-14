<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * USE CASE 2.2.2: Pregled svih proizvoda
     * Vraća listu svih proizvoda sa opcionalnom pretragom
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Pretraga po nazivu (ako je prosleđen search parametar)
        if ($request->has('search')) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $products = $query->get();

        return response()->json([
            'message' => 'Lista proizvoda',
            'data' => $products,
        ]);
    }

    /**
     * USE CASE 2.2.2: Filtriranje proizvoda po kategoriji
     * Vraća proizvode iz određene kategorije
     */
    public function byCategory(Category $category)
    {
        $products = $category->products;

        return response()->json([
            'message' => 'Proizvodi iz kategorije: '.$category->name,
            'category' => $category->name,
            'data' => $products,
        ]);
    }

    /**
     * Prikaz pojedinačnog proizvoda
     */
    public function show(Product $product)
    {
        return response()->json([
            'data' => $product->load('category'),
        ]);
    }

    /**
     * Kreiranje novog proizvoda (Admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Proizvod kreiran',
            'data' => $product,
        ], 201);
    }

    /**
     * Ažuriranje proizvoda (Admin - Use Case 2.2.4)
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'category_id' => 'sometimes|exists:categories,id',
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price' => 'sometimes|numeric|min:0',
            'stock_quantity' => 'sometimes|integer|min:0',
        ]);

        $product->update($validated);

        return response()->json([
            'message' => 'Proizvod ažuriran',
            'data' => $product,
        ]);
    }

    /**
     * Brisanje proizvoda (Admin)
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Proizvod obrisan',
        ]);
    }
}

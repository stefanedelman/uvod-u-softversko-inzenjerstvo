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
}

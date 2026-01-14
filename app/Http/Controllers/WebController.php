<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class WebController extends Controller
{
    /**
     * Početna stranica
     */
    public function home()
    {
        $categories = Category::withCount('products')->get();
        $featuredProducts = Product::with('category')->inRandomOrder()->take(8)->get();

        return view('home', compact('categories', 'featuredProducts'));
    }

    /**
     * Katalog proizvoda sa filterima
     */
    public function katalog(Request $request)
    {
        $categories = Category::all();

        $query = Product::with('category');

        // Filter po kategoriji
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        // Pretraga po nazivu
        if ($request->has('search') && $request->search) {
            $query->where('name', 'like', '%'.$request->search.'%');
        }

        $products = $query->get();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Detalji proizvoda
     */
    public function proizvod(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Prikaz korpe
     */
    public function korpa()
    {
        $cart = session()->get('cart', []);

        return view('cart.index', compact('cart'));
    }

    /**
     * Dodaj u korpu
     */
    public function dodajUKorpu(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($request->product_id);
        $cart = session()->get('cart', []);

        // Ako proizvod već postoji u korpi, povećaj količinu
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $request->quantity;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $request->quantity,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Proizvod dodat u korpu!');
    }

    /**
     * Ukloni iz korpe
     */
    public function ukloniIzKorpe($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Proizvod uklonjen iz korpe.');
    }

    /**
     * Checkout stranica
     */
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/korpa')->with('error', 'Korpa je prazna.');
        }

        return view('cart.checkout', compact('cart'));
    }

    /**
     * Procesiranje porudžbine
     */
    public function processCheckout(Request $request)
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect('/korpa')->with('error', 'Korpa je prazna.');
        }

        // Kreiraj porudžbinu
        $order = Order::create([
            'user_id' => auth()->id() ?? 1,
            'order_date' => now(),
            'status' => 'na_cekanju',
            'total_price' => 0,
        ]);

        $totalPrice = 0;

        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);

            if ($product && $product->stock_quantity >= $item['quantity']) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                ]);

                $product->decrement('stock_quantity', $item['quantity']);
                $totalPrice += $product->price * $item['quantity'];
            }
        }

        $order->update(['total_price' => $totalPrice]);

        // Isprazni korpu
        session()->forget('cart');

        return view('cart.success', compact('order'));
    }
}

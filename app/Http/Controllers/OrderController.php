<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Prikaz svih porudžbina.
     */
    public function index()
    {
        return Order::with('orderItems.product')->get();
    }

    /**
     * GLAVNI USE CASE: Kreiranje porudžbine (Checkout).
     */
    public function store(Request $request)
    {
        // 1. Validacija podataka
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
        ]);

        try {
            DB::beginTransaction();

            // 2. Kreiranje porudžbine (Default status: na_cekanju)
            // Ako nema ulogovanog korisnika (jer radimo test), koristi ID 1
            $userId = Auth::id() ?? 1;

            $order = Order::create([
                'user_id' => $userId,
                'order_date' => now(),
                'status' => 'na_cekanju',
                'total_price' => 0, // Računamo u petlji
            ]);

            $totalPrice = 0;

            // 3. Petlja kroz stavke korpe
            foreach ($validated['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);

                // Provera zaliha
                if ($product->stock_quantity < $item['quantity']) {
                    throw new \Exception('Nema dovoljno proizvoda: '.$product->name);
                }

                // Kreiranje stavke
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'unit_price' => $product->price,
                ]);

                // Smanjenje zaliha u bazi
                $product->decrement('stock_quantity', $item['quantity']);

                $totalPrice += $product->price * $item['quantity'];
            }

            // Ažuriranje ukupne cene
            $order->update(['total_price' => $totalPrice]);

            DB::commit();

            return response()->json([
                'message' => 'Porudžbina uspešno kreirana!',
                'data' => $order->load('orderItems'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function show(Order $order)
    {
        return $order->load('orderItems.product');
    }

    /**
     * USE CASE 2.2.5: Obrada porudžbine (Admin)
     * Promena statusa porudžbine
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:na_cekanju,u_obradi,poslato,otkazano',
        ]);

        $order->update($validated);

        return response()->json([
            'message' => 'Status porudžbine ažuriran na: '.$validated['status'],
            'data' => $order,
        ]);
    }
}

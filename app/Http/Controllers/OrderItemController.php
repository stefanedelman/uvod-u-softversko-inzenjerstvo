<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    /**
     * Lista stavki za određenu porudžbinu
     */
    public function index(Order $order)
    {
        return response()->json([
            'data' => $order->orderItems->load('product'),
        ]);
    }

    /**
     * Dodavanje stavke u porudžbinu
     */
    public function store(Request $request, Order $order)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($validated['product_id']);

        $orderItem = OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'unit_price' => $product->price,
        ]);

        // Ažuriraj ukupnu cenu porudžbine
        $order->update([
            'total_price' => $order->total_price + ($product->price * $validated['quantity']),
        ]);

        return response()->json([
            'message' => 'Stavka dodata',
            'data' => $orderItem->load('product'),
        ], 201);
    }

    /**
     * Prikaz jedne stavke
     */
    public function show(OrderItem $orderItem)
    {
        return response()->json([
            'data' => $orderItem->load(['product', 'order']),
        ]);
    }

    /**
     * Ažuriranje stavke (količina)
     */
    public function update(Request $request, OrderItem $orderItem)
    {
        $validated = $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $oldTotal = $orderItem->unit_price * $orderItem->quantity;
        $newTotal = $orderItem->unit_price * $validated['quantity'];

        $orderItem->update($validated);

        // Ažuriraj ukupnu cenu porudžbine
        $orderItem->order->update([
            'total_price' => $orderItem->order->total_price - $oldTotal + $newTotal,
        ]);

        return response()->json([
            'message' => 'Stavka ažurirana',
            'data' => $orderItem,
        ]);
    }

    /**
     * Brisanje stavke iz porudžbine
     */
    public function destroy(OrderItem $orderItem)
    {
        $itemTotal = $orderItem->unit_price * $orderItem->quantity;

        // Ažuriraj ukupnu cenu pre brisanja
        $orderItem->order->update([
            'total_price' => $orderItem->order->total_price - $itemTotal,
        ]);

        $orderItem->delete();

        return response()->json([
            'message' => 'Stavka obrisana',
        ]);
    }
}

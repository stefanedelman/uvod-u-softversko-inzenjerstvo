<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase; // Ovo resetuje bazu posle svakog testa

    /**
     * Testira da li ulogovan korisnik može da napravi porudžbinu.
     */
    public function test_user_can_create_order()
    {
        // 1. Arrange (Priprema)
        $user = User::factory()->create();
        $category = Category::factory()->create();
        
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'price' => 100,
            'stock_quantity' => 10
        ]);

        // 2. Act (Akcija) - šaljemo zahtev na rutu koju smo napravili
        $response = $this->actingAs($user)->postJson('/order', [
            'payment_method' => 'card',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2
                ]
            ]
        ]);

        // 3. Assert (Provera)
        $response->assertStatus(201); // Očekujemo "Created" status

        // Proveri da li je upisano u bazu
        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'total_price' => 200, // 2 * 100
        ]);

        // Proveri da li se smanjila zaliha
        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'stock_quantity' => 8, // 10 - 2
        ]);
    }

    /**
     * Testira validaciju (ne može da se naruči ako nema na stanju).
     */
    public function test_cannot_order_more_than_stock()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        
        $product = Product::factory()->create([
            'category_id' => $category->id,
            'stock_quantity' => 5
        ]);

        $response = $this->actingAs($user)->postJson('/order', [
            'payment_method' => 'card',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 10 // Tražimo više nego što ima
                ]
            ]
        ]);

        $response->assertStatus(400); // Očekujemo grešku
    }
}
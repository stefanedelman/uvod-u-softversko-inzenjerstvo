<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Kreiranje admin korisnika
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@webshop.com',
        ]);

        // 2. Kreiranje test kupaca
        $users = User::factory(5)->create();

        // 3. Kreiranje kategorija (snowboard oprema)
        $categories = collect([
            'Snoubordovi',
            'Čizme',
            'Vezovi',
            'Kacige',
            'Naočare',
            'Jakne',
        ])->map(fn ($name) => Category::create(['name' => $name]));

        // 4. Kreiranje proizvoda za svaku kategoriju
        $categories->each(function ($category) {
            Product::factory(4)->create([
                'category_id' => $category->id,
            ]);
        });

        // 5. Kreiranje nekoliko porudžbina
        $users->each(function ($user) {
            $order = Order::factory()->create([
                'user_id' => $user->id,
            ]);

            // Dodaj 1-3 stavke u svaku porudžbinu
            $products = Product::inRandomOrder()->take(rand(1, 3))->get();
            $total = 0;

            foreach ($products as $product) {
                $qty = rand(1, 2);
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qty,
                    'unit_price' => $product->price,
                ]);
                $total += $product->price * $qty;
            }

            $order->update(['total_price' => $total]);
        });
    }
}

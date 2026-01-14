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

        // 3. Definisanje kategorija i proizvoda
        $productsData = [
            'Snoubordovi' => [
                ['name' => 'Burton Custom Flying V', 'price' => 52990, 'description' => 'Svestrani all-mountain snowboard sa Flying V profilom. Idealan za intermediate i napredne vozače.', 'image' => '/storage/images/product_images/snoubord1.jpg'],
                ['name' => 'Ride Warpig', 'price' => 47990, 'description' => 'Kratki i široki freeride board. Odličan za powder i groomed staze.', 'image' => '/storage/images/product_images/snoubord2.jpg'],
                ['name' => 'Jones Mountain Twin', 'price' => 55990, 'description' => 'Twin tip all-mountain board za svestrane vozače koji vole park i powder.', 'image' => '/storage/images/product_images/snoubord3.jpg'],
                ['name' => 'Salomon Assassin', 'price' => 44990, 'description' => 'Freestyle/all-mountain board sa rock out camber profilom.', 'image' => '/storage/images/product_images/snoubord1.jpg'],
            ],
            'Čizme' => [
                ['name' => 'Burton Ion BOA', 'price' => 38990, 'description' => 'Premium čizme sa BOA sistemom zatezanja. Maksimalna udobnost i response.', 'image' => '/storage/images/product_images/cizme1.jpg'],
                ['name' => 'ThirtyTwo Lashed', 'price' => 27990, 'description' => 'Klasične čizme srednje krutosti. Odlične za freestyle i all-mountain.', 'image' => '/storage/images/product_images/cizme2.jpg'],
                ['name' => 'Ride Fuse BOA', 'price' => 31990, 'description' => 'Lagane čizme sa dual BOA sistemom. Idealne za celodevno uživanje.', 'image' => '/storage/images/product_images/cizme1.jpg'],
                ['name' => 'DC Judge BOA', 'price' => 29990, 'description' => 'Čizme sa Impact S podplatom za maksimalnu udobnost.', 'image' => '/storage/images/product_images/cizme2.jpg'],
            ],
            'Vezovi' => [
                ['name' => 'Burton Cartel X', 'price' => 32990, 'description' => 'Profesionalni vezovi sa Re:Flex sistemom. Maksimalni response i kontrola.', 'image' => '/storage/images/product_images/fali_proizvod.jpg'],
                ['name' => 'Union Force', 'price' => 27990, 'description' => 'Best-seller vezovi srednje krutosti. Svestrani i pouzdani.', 'image' => '/storage/images/product_images/fali_proizvod.jpg'],
                ['name' => 'Ride A-6', 'price' => 24990, 'description' => 'All-mountain vezovi sa aluminijumskom hepek bazom.', 'image' => '/storage/images/product_images/fali_proizvod.jpg'],
                ['name' => 'NOW Select Pro', 'price' => 34990, 'description' => 'Inovativni vezovi sa skate-tech dizajnom za prirodniji osećaj.', 'image' => '/storage/images/product_images/fali_proizvod.jpg'],
            ],
            'Kacige' => [
                ['name' => 'Smith Maze MIPS', 'price' => 12990, 'description' => 'Lagana kaciga sa MIPS zaštitom. In-mold konstrukcija.', 'image' => '/storage/images/product_images/kaciga1.jpg'],
                ['name' => 'Giro Ledge', 'price' => 8990, 'description' => 'Entry-level kaciga sa hard shell konstrukcijom. Odličan odnos cene i kvaliteta.', 'image' => '/storage/images/product_images/kaciga2.jpg'],
                ['name' => 'Anon Raider 3', 'price' => 10990, 'description' => 'Kaciga sa Boa 360° Fit sistemom za savršeno prilagođavanje.', 'image' => '/storage/images/product_images/kaciga1.jpg'],
                ['name' => 'POC Obex MIPS', 'price' => 18990, 'description' => 'Premium kaciga sa MIPS i SPIN tehnologijom. Maksimalna zaštita.', 'image' => '/storage/images/product_images/kaciga2.jpg'],
            ],
            'Naočare' => [
                ['name' => 'Oakley Flight Deck', 'price' => 21990, 'description' => 'Frameless dizajn sa Prizm tehnologijom sočiva. Široko vidno polje.', 'image' => '/storage/images/product_images/gogle1.jpg'],
                ['name' => 'Smith I/O Mag', 'price' => 24990, 'description' => 'ChromaPop sočiva sa brzom izmenom. Uključena dva para sočiva.', 'image' => '/storage/images/product_images/gogle1.jpg'],
                ['name' => 'Dragon X2', 'price' => 17990, 'description' => 'Sferična sočiva sa Lumalens tehnologijom. Odlična protiv magle.', 'image' => '/storage/images/product_images/gogle1.jpg'],
                ['name' => 'Anon M4 Toric', 'price' => 28990, 'description' => 'Torična sočiva sa magnetnom izmenom. Premium performanse.', 'image' => '/storage/images/product_images/gogle1.jpg'],
            ],
            'Jakne' => [
                ['name' => 'Burton AK Gore-Tex Cyclic', 'price' => 64990, 'description' => 'Pro-level jakna sa Gore-Tex 2L materijalom. 100% vodootporna i prozračna.', 'image' => '/storage/images/product_images/fali_proizvod.jpg'],
                ['name' => 'Volcom L Gore-Tex', 'price' => 42990, 'description' => 'Gore-Tex jakna sa Zip Tech sistemom za spajanje sa pantalonama.', 'image' => '/storage/images/product_images/fali_proizvod.jpg'],
                ['name' => '686 GLCR Hydra Thermagraph', 'price' => 38990, 'description' => 'Jakna sa termalnom izolacijom i 20K vodootpornošću.', 'image' => '/storage/images/product_images/fali_proizvod.jpg'],
                ['name' => 'Quiksilver Mission', 'price' => 22990, 'description' => 'Entry-level jakna sa 10K vodootpornošću. Warm Flight izolacija.', 'image' => '/storage/images/product_images/fali_proizvod.jpg'],
            ],
        ];

        // 4. Kreiranje kategorija i proizvoda
        foreach ($productsData as $categoryName => $products) {
            $category = Category::create(['name' => $categoryName]);

            foreach ($products as $productData) {
                Product::create([
                    'category_id' => $category->id,
                    'name' => $productData['name'],
                    'description' => $productData['description'],
                    'image' => $productData['image'],
                    'price' => $productData['price'],
                    'stock_quantity' => rand(5, 30),
                ]);
            }
        }

        // 5. Kreiranje nekoliko porudžbina
        $users->each(function ($user) {
            $order = Order::factory()->create([
                'user_id' => $user->id,
            ]);

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

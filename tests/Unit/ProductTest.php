<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test da proizvod pripada kategoriji.
     */
    public function test_product_belongs_to_category(): void
    {
        $category = Category::factory()->create(['name' => 'Snoubordovi']);
        $product = Product::factory()->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Category::class, $product->category);
        $this->assertEquals($category->id, $product->category->id);
    }

    /**
     * Test da se cena proizvoda pravilno formatira.
     */
    public function test_product_price_is_numeric(): void
    {
        $product = Product::factory()->create(['price' => 52990]);

        $this->assertIsNumeric($product->price);
        $this->assertEquals(52990, $product->price);
    }

    /**
     * Test da proizvod ima sve obavezne atribute.
     */
    public function test_product_has_required_attributes(): void
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create([
            'name' => 'Test Snowboard',
            'price' => 45000,
            'stock_quantity' => 10,
            'category_id' => $category->id,
        ]);

        $this->assertNotNull($product->name);
        $this->assertNotNull($product->price);
        $this->assertNotNull($product->stock_quantity);
        $this->assertNotNull($product->category_id);
    }
}

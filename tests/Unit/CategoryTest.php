<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test da kategorija ima više proizvoda.
     */
    public function test_category_has_many_products(): void
    {
        $category = Category::factory()->create();
        Product::factory()->count(3)->create(['category_id' => $category->id]);

        $this->assertCount(3, $category->products);
    }

    /**
     * Test da se kategorija može kreirati sa nazivom.
     */
    public function test_category_can_be_created(): void
    {
        $category = Category::create([
            'name' => 'Nova Kategorija',
        ]);

        $this->assertDatabaseHas('categories', [
            'name' => 'Nova Kategorija',
        ]);
        $this->assertEquals('Nova Kategorija', $category->name);
    }
}

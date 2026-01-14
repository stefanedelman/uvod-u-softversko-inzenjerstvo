<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'category_id' => Category::factory(),
            'name' => fake()->randomElement(['Burton', 'Ride', 'K2', 'Salomon', 'Jones']).' '.fake()->word(),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 50, 800),
            'stock_quantity' => fake()->numberBetween(0, 50),
        ];
    }
}

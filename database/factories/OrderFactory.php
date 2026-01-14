<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_date' => fake()->dateTime(),
            'status' => fake()->regexify('[A-Za-z0-9]{50}'),
            'total_price' => fake()->randomFloat(2, 0, 99999999.99),
        ];
    }
}

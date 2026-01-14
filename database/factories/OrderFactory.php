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
            'order_date' => fake()->dateTimeBetween('-1 month', 'now'),
            'status' => fake()->randomElement(['na_cekanju', 'u_obradi', 'poslato', 'otkazano']),
            'total_price' => fake()->randomFloat(2, 100, 2000),
        ];
    }
}

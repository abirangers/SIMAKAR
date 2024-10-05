<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Menu>
 */
class MenuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'price' => fake()->numberBetween(10000, 50000),
            'stock' => fake()->numberBetween(1, 100),
            'image' => fake()->imageUrl(60, 60),
            'category_id' => fake()->numberBetween(1, 2),
        ];
    }
}

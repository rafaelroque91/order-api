<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class InventoryFactory extends Factory
{
    public function definition()
    {
        return [
            'stock' => fake()->numberBetween(1,500),
            'product_id' => Product::inRandomOrder()->first()->id,
        ];
    }
}

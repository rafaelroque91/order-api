<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class inventoryFactory extends Factory
{
    public function definition()
    {
        return [
            'stock' =>  fake()->numberBetween(1,500),
            'product_id' => Customer::factory()->create()->id
        ];
    }
}

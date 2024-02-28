<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'description' => 'Product Test - '.$this->faker->text(10),
            'customer_id' => Customer::factory()->create()->id
        ];
    }
}

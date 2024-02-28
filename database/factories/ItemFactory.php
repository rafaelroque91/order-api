<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Inventory;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition()
    {
        $customer = Customer::factory()->create();
        $product = Product::factory()->create(['customer_id' => $customer->id]);
        Inventory::factory()->create(['product_id' => $product->id,'stock' => 100]);

        return [
            'order_id' => Order::factory()->create(['customer_id' => $customer->id])->id,
            'product_id' => Product::factory()->create(['customer_id' => $customer->id])->id,
            'quantity' => fake()->numberBetween(1,5)
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition()
    {
        $randomSource = (Order::ALLOWED_SOURCES[fake()->numberBetween(0,1)]);

        return [
            'source' => $randomSource,
            'ready_to_ship' => fake()->numberBetween(0,1),
            'recipient_name' => fake()->name,
            'recipient_phone' => fake()->phoneNumber,
            'address_street' => fake()->streetAddress,
            'address_number' => (string)fake()->numberBetween(1,3000),
            'zipcode' => fake()->postcode,
            'customer_id' => Customer::factory()->create()->id
        ];
    }
}

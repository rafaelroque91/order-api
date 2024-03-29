<?php

namespace Database\Seeders;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Item::factory(50)->create();
    }
}

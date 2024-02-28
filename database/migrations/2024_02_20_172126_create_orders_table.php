<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Customer;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Customer::class)->nullable(false)->constrained();
            $table->string('source')->nullable(false);
            $table->boolean('ready_to_ship')->nullable(false);
            $table->string('recipient_name')->nullable(false);
            $table->string('recipient_phone')->nullable(true);
            $table->string('address_street')->nullable(false);
            $table->string('address_number')->nullable(false);
            $table->string('zipcode')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};


<?php

namespace App\Providers;

use App\Models\Order;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('allowed_source', function ($attribute, $value) {
            return in_array($value, Order::ALLOWED_SOURCES);
        });

        Validator::replacer('allowed_source', function ($message, $attribute, $rule, $parameters) {
            return "The $attribute is invalid. Allowed values: " . implode(', ',Order::ALLOWED_SOURCES);
        });
    }
}

<?php

use LaravelJsonApi\Laravel\Facades\JsonApiRoute;
use App\Http\Controllers\Api\V1\OrderController;
use LaravelJsonApi\Laravel\Http\Controllers\JsonApiController;
use LaravelJsonApi\Laravel\Routing\ResourceRegistrar;
use App\Http\Controllers\Api\V1\CustomerController;
use LaravelJsonApi\Laravel\Routing\Relationships;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

JsonApiRoute::server('v1')
    ->prefix('v1')
    ->resources(function (ResourceRegistrar $server) {
        $server->resource('customers', JsonApiController::class)->readOnly()
            ->relationships(function (Relationships $relationships) {
                $relationships->hasMany('products');
                $relationships->hasMany('orders');
            });
        $server->resource('orders', OrderController::class)->only('show','store')
            ->relationships(function (Relationships $relationships) {
                $relationships->hasOne('customer');
                $relationships->hasMany('products');
            });
       $server->resource('products', JsonApiController::class)->readOnly()
            ->relationships(function (Relationships $relationships) {
                $relationships->hasMany('orders');
                $relationships->hasOne('customer');
            });
    });

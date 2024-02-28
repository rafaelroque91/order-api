<?php

namespace App\JsonApi\V1\Orders;

use App\JsonApi\V1\AbstractSchema;
use App\Models\Order;
use LaravelJsonApi\Eloquent\Fields\Boolean;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsTo;
use LaravelJsonApi\Eloquent\Fields\DateTime;
use LaravelJsonApi\Eloquent\Fields\ID;
use LaravelJsonApi\Eloquent\Fields\Relations\BelongsToMany;
use LaravelJsonApi\Eloquent\Fields\Str;
use LaravelJsonApi\Eloquent\Filters\WhereIdIn;

class OrderSchema extends AbstractSchema
{

    /**
     * The model the schema corresponds to.
     *
     * @var string
     */
    public static string $model = Order::class;

    /**
     * Get the resource fields.
     *
     * @return array
     */
    public function fields(): array
    {
        return [
            ID::make(),
            BelongsTo::make('customer'),
            Str::make('source'),
            Boolean::make('readyToShip'),
            Str::make('recipientName'),
            Str::make('recipientPhone'),
            Str::make('addressStreet'),
            Str::make('addressNumber'),
            Str::make('zipcode'),
            BelongsToMany::make('products'),
            BelongsToMany::make('items'),
            DateTime::make('createdAt')->sortable()->readOnly(),
            DateTime::make('updatedAt')->sortable()->readOnly(),
        ];
    }

    /**
     * Get the resource filters.
     *
     * @return array
     */
    public function filters(): array
    {
        return [
            WhereIdIn::make($this),
        ];
    }
}

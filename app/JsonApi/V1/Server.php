<?php

namespace App\JsonApi\V1;

use App\JsonApi\V1\Customers\CustomerSchema;
use App\JsonApi\V1\Items\ItemSchema;
use App\JsonApi\V1\Orders\OrderSchema;
use App\JsonApi\V1\Products\ProductSchema;
use LaravelJsonApi\Core\Server\Server as BaseServer;

class Server extends BaseServer
{

    /**
     * The base URI namespace for this server.
     *
     * @var string
     */
    protected string $baseUri = '/api/v1';

    /**
     * Bootstrap the server when it is handling an HTTP request.
     *
     * @return void
     */
    public function serving(): void
    {
        // no-op
    }

    /**
     * Get the server's list of schemas.
     *
     * @return array
     */
    protected function allSchemas(): array
    {
        return [
            CustomerSchema::class,
            OrderSchema::class,
            ItemSchema::class,
            ProductSchema::class,
        ];
    }

    public function authorizable(): bool
    {
        return false;
    }
}

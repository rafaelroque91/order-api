<?php

namespace App\JsonApi\V1;

use LaravelJsonApi\Eloquent\Contracts\Paginator;
use LaravelJsonApi\Eloquent\Pagination\PagePagination;
use LaravelJsonApi\Eloquent\Schema;

class AbstractSchema extends Schema
{

    protected ?array $defaultPagination = ['number' => 1];

    public function fields(): array
    {
        return [
        ];
    }
    /**
     * Get the resource paginator.
     *
     * @return Paginator|null
     */
    public function pagination(): ?Paginator
    {
        return PagePagination::make()->withDefaultPerPage(10);
    }
}

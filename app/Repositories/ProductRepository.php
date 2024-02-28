<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Collection;

class ProductRepository
{
    public function getProductStockbyIds(array $ids) : ?Collection
    {
        return Product::whereIn('id',$ids)->get();
    }
}

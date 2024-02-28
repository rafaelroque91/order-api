<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use \Illuminate\Database\Eloquent\Factories\HasFactory;
class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'stock'
    ];

    public function product(): HasOne
    {
        return $this->hasOne(Product::class);
    }
}

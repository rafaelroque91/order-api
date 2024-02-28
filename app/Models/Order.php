<?php

namespace App\Models;

use App\Enums\OrderSources;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    public const ALLOWED_SOURCES = [
        OrderSources::AMAZON->value,
        OrderSources::EBAY->value,
        OrderSources::WALMART->value,
    ];
    protected $fillable = [
        'customer_id',
        'source',
        'address_street',
        'address_number',
        'ready_to_ship',
        'zipcode',
        'recipient_name',
        'recipient_phone',
        'address_street',
        'address_number'
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'items');
    }
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPackage extends Model
{
    protected $fillable = [
        'name',
        'tagline',
        'price',
        'slashed_price',
        'features',
        'is_popular',
        'wa_text',
        'order_index',
    ];

    protected $casts = [
        'features' => 'array',
        'is_popular' => 'boolean',
        'order_index' => 'integer',
    ];
}

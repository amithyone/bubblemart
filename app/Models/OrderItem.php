<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'customization_id',
        'quantity',
        'price',
        'total',
        'receiver_name',
        'receiver_address',
        'receiver_phone',
        'receiver_note',
        'customization_details',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function customization(): BelongsTo
    {
        return $this->belongsTo(Customization::class);
    }

    public function variationOptions(): HasMany
    {
        return $this->hasMany(ProductVariationOption::class);
    }

    public function getVariationSummaryAttribute(): string
    {
        $variations = $this->variationOptions->map(function ($option) {
            return $option->variation_name . ': ' . $option->option_label;
        })->join(', ');
        
        return $variations ?: 'No variations';
    }
}

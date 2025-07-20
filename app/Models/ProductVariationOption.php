<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductVariationOption extends Model
{
    protected $fillable = [
        'order_item_id',
        'variation_option_id',
        'variation_name',
        'option_value',
        'option_label',
        'price_adjustment',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
    ];

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function variationOption(): BelongsTo
    {
        return $this->belongsTo(VariationOption::class);
    }
}

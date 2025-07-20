<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class VariationOption extends Model
{
    protected $fillable = [
        'product_variation_id',
        'value',
        'label',
        'price_adjustment',
        'stock',
        'sku',
        'image',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price_adjustment' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function variation(): BelongsTo
    {
        return $this->belongsTo(ProductVariation::class, 'product_variation_id');
    }

    public function productVariationOptions(): HasMany
    {
        return $this->hasMany(ProductVariationOption::class);
    }

    public function getDisplayLabelAttribute(): string
    {
        return $this->label ?: $this->value;
    }

    public function getFinalPriceAttribute(): float
    {
        return $this->variation->product->price + $this->price_adjustment;
    }
}

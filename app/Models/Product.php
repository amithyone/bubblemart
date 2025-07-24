<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'image',
        'gallery',
        'category_id',
        'store_id',
        'is_featured',
        'is_active',
        'allow_customization',
        'scope',
        'stock',
        'sku',
        'delivery_options',
        'delivery_time_hours',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'gallery' => 'array',
        'delivery_options' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'allow_customization' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function customizations(): HasMany
    {
        return $this->hasMany(Customization::class);
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class)->orderBy('sort_order');
    }

    public function activeVariations(): HasMany
    {
        return $this->hasMany(ProductVariation::class)->whereHas('activeOptions')->orderBy('sort_order');
    }

    public function hasVariations(): bool
    {
        return $this->variations()->exists();
    }

    public function getVariationByName(string $name): ?ProductVariation
    {
        return $this->variations()->where('name', $name)->first();
    }

    public function getFinalPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Get price in Naira (assuming price is stored in USD)
     */
    public function getPriceNairaAttribute()
    {
        $exchangeRate = \App\Models\Setting::getExchangeRate();
        $markupPercentage = \App\Models\Setting::getMarkupPercentage();
        
        $basePrice = $this->price * $exchangeRate;
        $markupAmount = $basePrice * ($markupPercentage / 100);
        
        return $basePrice + $markupAmount;
    }

    /**
     * Get sale price in Naira (assuming sale_price is stored in USD)
     */
    public function getSalePriceNairaAttribute()
    {
        if (!$this->sale_price) return null;
        
        $exchangeRate = \App\Models\Setting::getExchangeRate();
        $markupPercentage = \App\Models\Setting::getMarkupPercentage();
        
        $basePrice = $this->sale_price * $exchangeRate;
        $markupAmount = $basePrice * ($markupPercentage / 100);
        
        return $basePrice + $markupAmount;
    }

    /**
     * Get final price in Naira
     */
    public function getFinalPriceNairaAttribute()
    {
        $finalUsdPrice = $this->final_price;
        $exchangeRate = \App\Models\Setting::getExchangeRate();
        $markupPercentage = \App\Models\Setting::getMarkupPercentage();
        
        $basePrice = $finalUsdPrice * $exchangeRate;
        $markupAmount = $basePrice * ($markupPercentage / 100);
        
        return $basePrice + $markupAmount;
    }

    /**
     * Get formatted price in Naira with USD conversion
     */
    public function getFormattedPriceAttribute()
    {
        $nairaPrice = $this->final_price_naira;
        $usdPrice = $this->final_price;
        
        return "₦" . number_format($nairaPrice) . " ($" . number_format($usdPrice, 2) . ")";
    }

    /**
     * Get formatted price in Naira only
     */
    public function getFormattedPriceNairaAttribute()
    {
        return "₦" . number_format($this->final_price_naira);
    }

    /**
     * Get formatted USD price only
     */
    public function getFormattedPriceUsdAttribute()
    {
        return "$" . number_format($this->final_price, 2);
    }

    /**
     * Check if product is US-only
     */
    public function isUsOnly(): bool
    {
        return $this->scope === 'us_only';
    }

    /**
     * Check if product is international
     */
    public function isInternational(): bool
    {
        return $this->scope === 'international';
    }

    /**
     * Get scope display name
     */
    public function getScopeDisplayNameAttribute(): string
    {
        return $this->scope === 'us_only' ? 'US Only' : 'International';
    }
}

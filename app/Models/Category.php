<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'image_path',
        'is_active',
        'sort_order',
        'parent_id',
        'variation_types',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'variation_types' => 'array',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function subcategories(): HasMany
    {
        return $this->children();
    }

    public function isParent(): bool
    {
        return is_null($this->parent_id);
    }

    public function isChild(): bool
    {
        return !is_null($this->parent_id);
    }

    public function getFullNameAttribute(): string
    {
        if ($this->isChild() && $this->parent) {
            return $this->parent->name . ' > ' . $this->name;
        }
        return $this->name;
    }

    public function getAllProducts()
    {
        $productIds = $this->products->pluck('id');
        
        // Get products from subcategories
        foreach ($this->children as $child) {
            $productIds = $productIds->merge($child->getAllProducts()->pluck('id'));
        }
        
        return Product::whereIn('id', $productIds);
    }

    /**
     * Get all variation types for this category
     */
    public function getVariationTypes(): array
    {
        return $this->variation_types ?? [];
    }

    /**
     * Check if this category supports variations
     */
    public function supportsVariations(): bool
    {
        return !empty($this->variation_types);
    }

    /**
     * Get variation types with their options
     */
    public function getVariationTypesWithOptions(): array
    {
        $types = $this->getVariationTypes();
        $variationOptions = [
            'size' => [
                'XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL',
                '28', '30', '32', '34', '36', '38', '40', '42', '44', '46', '48', '50'
            ],
            'color' => [
                'Red', 'Blue', 'Green', 'Yellow', 'Black', 'White', 'Gray', 'Brown', 
                'Pink', 'Purple', 'Orange', 'Navy', 'Beige', 'Gold', 'Silver'
            ],
            'material' => [
                'Cotton', 'Polyester', 'Wool', 'Silk', 'Leather', 'Denim', 'Linen', 
                'Satin', 'Velvet', 'Mesh', 'Spandex', 'Cashmere'
            ],
            'style' => [
                'Casual', 'Formal', 'Sport', 'Vintage', 'Modern', 'Classic', 
                'Bohemian', 'Minimalist', 'Streetwear', 'Elegant'
            ],
            'fit' => [
                'Slim', 'Regular', 'Loose', 'Oversized', 'Tapered', 'Relaxed', 
                'Skinny', 'Straight', 'Wide', 'Comfortable'
            ],
            'pattern' => [
                'Solid', 'Striped', 'Polka Dot', 'Floral', 'Geometric', 'Abstract', 
                'Animal Print', 'Plaid', 'Checkered', 'Tie-Dye'
            ]
        ];

        $result = [];
        foreach ($types as $type) {
            $result[$type] = $variationOptions[$type] ?? [];
        }

        return $result;
    }

    /**
     * Get all variation types from parent and child categories
     */
    public function getAllVariationTypes(): array
    {
        $types = $this->getVariationTypes();
        
        // Add parent category variation types
        if ($this->parent) {
            $types = array_merge($types, $this->parent->getVariationTypes());
        }
        
        // Add child category variation types
        foreach ($this->children as $child) {
            $types = array_merge($types, $child->getVariationTypes());
        }
        
        return array_unique($types);
    }
}

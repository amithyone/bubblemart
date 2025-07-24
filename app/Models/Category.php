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
        'is_featured',
        'is_customizable',
        'sort_order',
        'parent_id',
        'variation_types',
        'gender',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_customizable' => 'boolean',
        'variation_types' => 'array',
    ];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function activeProducts(): HasMany
    {
        return $this->hasMany(Product::class)->where('is_active', true);
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
        $productIds = $this->activeProducts->pluck('id');
        
        // Get products from subcategories
        foreach ($this->children as $child) {
            $productIds = $productIds->merge($child->getAllProducts()->pluck('id'));
        }
        
        return Product::whereIn('id', $productIds)->where('is_active', true);
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

    /**
     * Check if this category can be featured
     */
    public function canBeFeatured(): bool
    {
        if ($this->is_featured) {
            return true; // Already featured, can remain featured
        }
        
        $featuredCount = self::where('is_featured', true)->count();
        return $featuredCount < 3;
    }

    /**
     * Get the count of featured categories
     */
    public static function getFeaturedCount(): int
    {
        return self::where('is_featured', true)->count();
    }

    /**
     * Get all featured categories
     */
    public static function getFeaturedCategories()
    {
        return self::where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Check if this category supports gender filtering
     */
    public function supportsGenderFiltering(): bool
    {
        return !is_null($this->gender) && $this->gender !== 'all';
    }

    /**
     * Get gender options for this category
     */
    public function getGenderOptions(): array
    {
        if (!$this->supportsGenderFiltering()) {
            return [];
        }

        $options = [];
        
        if ($this->gender === 'male' || $this->gender === 'all') {
            $options['male'] = "Men's";
        }
        
        if ($this->gender === 'female' || $this->gender === 'all') {
            $options['female'] = "Women's";
        }
        
        if ($this->gender === 'unisex' || $this->gender === 'all') {
            $options['unisex'] = "Unisex";
        }

        return $options;
    }

    /**
     * Check if this category has gender subcategories
     */
    public function hasGenderSubcategories(): bool
    {
        return $this->children()->where(function($query) {
            $query->where('name', 'like', "%men's%")
                  ->orWhere('name', 'like', "%mens%")
                  ->orWhere('name', 'like', "%women's%")
                  ->orWhere('name', 'like', "%womens%")
                  ->orWhere('name', 'like', "%unisex%");
        })->exists();
    }
}

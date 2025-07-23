<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id') // Only show parent categories
            ->orderBy('sort_order')
            ->withCount('products')
            ->with(['children' => function($query) {
                $query->withCount('products');
            }])
            ->get();

        // Calculate total products including subcategories for parent categories
        foreach ($categories as $category) {
            $totalProducts = $category->products_count;
            foreach ($category->children as $child) {
                $totalProducts += $child->products_count;
            }
            $category->total_products_count = $totalProducts;
        }

        return view('categories.index', compact('categories'));
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category, Request $request)
    {
        // Load the category with its children and their product counts
        $category->load(['children' => function($query) {
            $query->withCount('products');
        }]);

        // Get products from this category and all its subcategories
        $categoryIds = [$category->id];
        foreach ($category->children as $child) {
            $categoryIds[] = $child->id;
        }

        $query = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->with(['store', 'category']);

        // Apply subcategory filter if specified
        if ($request->filled('subcategory')) {
            $subcategoryId = $request->subcategory;
            if ($subcategoryId === 'parent') {
                // Show only products from parent category
                $query->where('category_id', $category->id);
            } else {
                // Show products from specific subcategory
                $query->where('category_id', $subcategoryId);
            }
        }

        // Apply gender filter if specified
        if ($request->filled('gender')) {
            $gender = $request->gender;
            
            // If category has gender field set, filter by that
            if ($category->supportsGenderFiltering()) {
                if ($category->gender === $gender || $category->gender === 'all') {
                    // Show products from this category
                    $query->where('category_id', $category->id);
                } else {
                    // No products match this gender filter
                    $query->where('id', 0); // Return no results
                }
            } else {
                // Fallback to subcategory-based filtering
                $genderSubcategoryIds = [];
                
                foreach ($category->children as $subcategory) {
                    $subcategoryName = strtolower($subcategory->name);
                    
                    if ($gender === 'male' && (str_contains($subcategoryName, "men's") || str_contains($subcategoryName, "mens"))) {
                        $genderSubcategoryIds[] = $subcategory->id;
                    } elseif ($gender === 'female' && (str_contains($subcategoryName, "women's") || str_contains($subcategoryName, "womens"))) {
                        $genderSubcategoryIds[] = $subcategory->id;
                    } elseif ($gender === 'unisex' && str_contains($subcategoryName, "unisex")) {
                        $genderSubcategoryIds[] = $subcategory->id;
                    }
                }
                
                if (!empty($genderSubcategoryIds)) {
                    $query->whereIn('category_id', $genderSubcategoryIds);
                }
            }
        }

        // Apply price filter if specified
        if ($request->filled('min_price')) {
            $query->where('price_naira', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price_naira', '<=', $request->max_price);
        }

        // Apply sort order
        $sortBy = $request->get('sort', 'newest');
        switch ($sortBy) {
            case 'price_low':
                $query->orderBy('price_naira', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price_naira', 'desc');
                break;
            case 'name':
                $query->orderBy('name', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $products = $query->paginate(12)->withQueryString();

        return view('categories.show', compact('category', 'products'));
    }
}

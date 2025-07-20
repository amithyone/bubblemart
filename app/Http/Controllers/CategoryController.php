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
    public function show(Category $category)
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

        $products = Product::whereIn('category_id', $categoryIds)
            ->where('is_active', true)
            ->with(['store', 'category'])
            ->paginate(12);

        return view('categories.show', compact('category', 'products'));
    }
}

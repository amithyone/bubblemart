<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'store'])
            ->where('is_active', true);

        // Filter by category (including subcategories)
        if ($request->has('category')) {
            $categorySlugs = is_array($request->category) ? $request->category : [$request->category];
            
            $query->whereHas('category', function ($q) use ($categorySlugs) {
                $q->where(function ($subQuery) use ($categorySlugs) {
                    foreach ($categorySlugs as $slug) {
                        $category = Category::where('slug', $slug)->first();
                        if ($category) {
                            if ($category->isParent()) {
                                // If it's a parent category, include all subcategories
                                $subQuery->orWhere('id', $category->id)
                                         ->orWhere('parent_id', $category->id);
                            } else {
                                // If it's a subcategory, include only that category
                                $subQuery->orWhere('id', $category->id);
                            }
                        }
                    }
                });
            });
        }

        // Filter by store
        if ($request->has('store')) {
            $query->where('store_id', $request->store);
        }

        // Filter by price range
        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Search by name
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->paginate(12);
        
        // Get categories with subcategories
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id') // Only parent categories
            ->with(['children' => function ($query) {
                $query->where('is_active', true);
            }])
            ->get();
            
        $stores = Store::where('is_active', true)->get();
        
        // Get search term for display
        $search = $request->get('search');

        return view('products.index', compact('products', 'categories', 'stores', 'search'));
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'store', 'variations.options']);
        
        // Get related products from the same category or subcategory
        $relatedProducts = Product::where(function ($query) use ($product) {
            $query->where('category_id', $product->category_id)
                  ->orWhereHas('category', function ($q) use ($product) {
                      if ($product->category->isParent()) {
                          $q->where('parent_id', $product->category_id);
                      } else {
                          $q->where('parent_id', $product->category->parent_id);
                      }
                  });
        })
        ->where('id', '!=', $product->id)
        ->where('is_active', true)
        ->take(4)
        ->get();

        return view('products.show', compact('product', 'relatedProducts'));
    }
}

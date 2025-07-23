<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;

class HomeController extends Controller
{
    /**
     * Show the application homepage.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');
        $priceRange = $request->get('price_range');

        // Get featured products first, then other products
        $featuredProducts = Product::with(['category', 'store'])
            ->where('is_active', true)
            ->where('is_featured', true)
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // If we don't have enough featured products, add more products
        if ($featuredProducts->count() < 6) {
            $remainingCount = 6 - $featuredProducts->count();
            $otherProducts = Product::with(['category', 'store'])
                ->where('is_active', true)
                ->where('is_featured', false)
                ->whereNotIn('id', $featuredProducts->pluck('id'))
                ->orderBy('created_at', 'desc')
                ->take($remainingCount)
                ->get();
            
            $products = $featuredProducts->merge($otherProducts);
        } else {
            $products = $featuredProducts;
        }

        $categories = Category::where('is_active', true)
            ->orderByRaw('CASE WHEN image_path IS NOT NULL THEN 0 ELSE 1 END')
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        $stores = Store::where('is_active', true)
            ->orderBy('sort_order')
            ->take(8)
            ->get();

        return view('home', compact('products', 'categories', 'stores', 'search'));
    }

    /**
     * Search products.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function search(Request $request)
    {
        $search = $request->get('search');
        $category = $request->get('category');
        $priceRange = $request->get('price_range');
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $query = Product::with(['category', 'store'])
            ->where('is_active', true);

        // Apply search filter
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('category', function($catQuery) use ($search) {
                      $catQuery->where('name', 'like', "%{$search}%");
                  })
                  ->orWhereHas('store', function($storeQuery) use ($search) {
                      $storeQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // Apply category filter
        if ($category) {
            $query->whereHas('category', function($q) use ($category) {
                $q->where('id', $category);
            });
        }

        // Apply price range filter
        if ($priceRange) {
            switch ($priceRange) {
                case '0-1000':
                    $query->where('price_naira', '<=', 1000);
                    break;
                case '1000-5000':
                    $query->whereBetween('price_naira', [1000, 5000]);
                    break;
                case '5000-10000':
                    $query->whereBetween('price_naira', [5000, 10000]);
                    break;
                case '10000-50000':
                    $query->whereBetween('price_naira', [10000, 50000]);
                    break;
                case '50000+':
                    $query->where('price_naira', '>=', 50000);
                    break;
            }
        }

        // Apply sorting
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate(12);

        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        return view('products.index', compact('products', 'categories', 'search', 'category', 'priceRange', 'sortBy', 'sortOrder'));
    }
}

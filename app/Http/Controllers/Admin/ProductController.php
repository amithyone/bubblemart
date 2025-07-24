<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        $query = Product::with(['category', 'store']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        // Filter by category
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter by store
        if ($request->has('store')) {
            $query->where('store_id', $request->store);
        }

        // Filter by status
        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $products = $query->paginate(20);
        $categories = Category::all();
        $stores = Store::all();

        return view('admin.products.index', compact('products', 'categories', 'stores'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->where('is_active', true);
            }])
            ->where('is_active', true)
            ->get();
        $stores = Store::all();

        return view('admin.products.create', compact('categories', 'stores'));
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'store_id' => 'required|exists:stores,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'allow_customization' => 'boolean',
            'stock' => 'nullable|integer|min:0',
        ]);

        $data = $request->except(['image', 'gallery']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['allow_customization'] = $request->boolean('allow_customization');

        // Handle main image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        // Handle gallery images upload
        $galleryImages = [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $imagePath = $image->store('products/gallery', 'public');
                $galleryImages[] = $imagePath;
            }
        }
        $data['gallery'] = $galleryImages;

        Product::create($data);

        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully!');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        $product->load(['category', 'store', 'orderItems']);
        
        $stats = [
            'total_orders' => $product->orderItems()->count(),
            'total_quantity_sold' => $product->orderItems()->sum('quantity'),
            'total_revenue' => $product->orderItems()->sum(DB::raw('quantity * price')),
        ];

        return view('admin.products.show', compact('product', 'stats'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::whereNull('parent_id')
            ->with(['children' => function($query) {
                $query->where('is_active', true);
            }])
            ->where('is_active', true)
            ->get();
        $stores = Store::all();

        return view('admin.products.edit', compact('product', 'categories', 'stores'));
    }

    /**
     * Update the specified product.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'store_id' => 'required|exists:stores,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'gallery.*' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'allow_customization' => 'boolean',
            'stock' => 'nullable|integer|min:0',
        ]);

        $data = $request->except(['image', 'gallery']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->boolean('is_active');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['allow_customization'] = $request->boolean('allow_customization');

        // Handle main image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            
            $imagePath = $request->file('image')->store('products', 'public');
            $data['image'] = $imagePath;
        }

        // Handle gallery images upload
        $galleryImages = $product->gallery ?? [];
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $imagePath = $image->store('products/gallery', 'public');
                $galleryImages[] = $imagePath;
            }
        }
        $data['gallery'] = $galleryImages;

        $product->update($data);

        return redirect()->route('admin.products.show', $product)
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        // Delete main image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        // Delete gallery images if exist
        if ($product->gallery) {
            foreach ($product->gallery as $galleryImage) {
                Storage::disk('public')->delete($galleryImage);
            }
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Toggle product active status.
     */
    public function toggleStatus(Product $product)
    {
        $product->update(['is_active' => !$product->is_active]);

        $status = $product->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Product {$status} successfully!");
    }

    /**
     * Update product stock quantity.
     */
    public function updateStock(Request $request, Product $product)
    {
        $request->validate([
            'stock_quantity' => 'required|integer|min:0',
        ]);

        $product->update(['stock_quantity' => $request->stock_quantity]);

        return back()->with('success', 'Stock quantity updated successfully!');
    }

    /**
     * Bulk operations on products.
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:activate,deactivate,delete',
            'products' => 'required|array',
            'products.*' => 'exists:products,id',
        ]);

        $products = Product::whereIn('id', $request->products);

        switch ($request->action) {
            case 'activate':
                $products->update(['is_active' => true]);
                $message = 'Products activated successfully!';
                break;
            case 'deactivate':
                $products->update(['is_active' => false]);
                $message = 'Products deactivated successfully!';
                break;
            case 'delete':
                $products->delete();
                $message = 'Products deleted successfully!';
                break;
        }

        return back()->with('success', $message);
    }

    /**
     * Remove a specific gallery image from a product.
     */
    public function removeGalleryImage(Product $product, $index)
    {
        $gallery = $product->gallery ?? [];
        
        if (isset($gallery[$index])) {
            // Delete the image file
            Storage::disk('public')->delete($gallery[$index]);
            
            // Remove from gallery array
            unset($gallery[$index]);
            $gallery = array_values($gallery); // Re-index array
            
            // Update product
            $product->update(['gallery' => $gallery]);
            
            return response()->json(['success' => true, 'message' => 'Gallery image removed successfully']);
        }
        
        return response()->json(['success' => false, 'message' => 'Image not found'], 404);
    }
}

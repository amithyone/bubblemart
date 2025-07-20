<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Store::withCount('products');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%")
                  ->orWhere('contact_number', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            if ($request->status === 'active') {
                $query->where('is_active', true);
            } elseif ($request->status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $stores = $query->orderBy('name')->paginate(20);
        $totalProducts = Product::count();

        return view('admin.stores.index', compact('stores', 'totalProducts'));
    }

    public function create()
    {
        return view('admin.stores.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stores',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('stores', 'public');
            $data['image_path'] = $imagePath;
        }

        Store::create($data);

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store created successfully!');
    }

    public function show(Store $store)
    {
        $store->load(['products' => function($query) {
            $query->latest()->limit(10);
        }]);
        
        $stats = [
            'total_products' => $store->products()->count(),
            'active_products' => $store->products()->where('is_active', true)->count(),
            'total_revenue' => $store->products()->join('order_items', 'products.id', '=', 'order_items.product_id')
                ->sum('order_items.total'),
        ];

        return view('admin.stores.show', compact('store', 'stats'));
    }

    public function edit(Store $store)
    {
        return view('admin.stores.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:stores,name,' . $store->id,
            'description' => 'nullable|string',
            'address' => 'required|string',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email',
            'website' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'is_active' => 'boolean',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            if ($store->image_path) {
                \Storage::disk('public')->delete($store->image_path);
            }
            
            $imagePath = $request->file('image')->store('stores', 'public');
            $data['image_path'] = $imagePath;
        }

        $store->update($data);

        return redirect()->route('admin.stores.show', $store)
            ->with('success', 'Store updated successfully!');
    }

    public function destroy(Store $store)
    {
        if ($store->products()->count() > 0) {
            return back()->with('error', 'Cannot delete store with existing products!');
        }

        if ($store->image_path) {
            \Storage::disk('public')->delete($store->image_path);
        }

        $store->delete();

        return redirect()->route('admin.stores.index')
            ->with('success', 'Store deleted successfully!');
    }

    public function toggleStatus(Store $store)
    {
        $store->update(['is_active' => !$store->is_active]);

        $status = $store->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Store {$status} successfully!");
    }

    public function products(Store $store)
    {
        $products = $store->products()->with('category')->paginate(20);
        return view('admin.stores.products', compact('store', 'products'));
    }
} 
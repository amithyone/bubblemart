<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index(Request $request)
    {
        $query = Category::withCount('products')->with('parent');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by parent category
        if ($request->has('parent')) {
            if ($request->parent === '0') {
                $query->whereNull('parent_id');
            } else {
                $query->where('parent_id', $request->parent);
            }
        }

        $categories = $query->orderBy('name')->paginate(20);
        $totalProducts = \App\Models\Product::count();


        return view('admin.categories.index', compact('categories', 'totalProducts'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_customizable' => 'boolean',
            'variation_types' => 'nullable|array',
            'variation_types.*' => 'string|in:size,color,material,style,fit,pattern',
            'gender' => 'nullable|in:male,female,unisex,all',
            'create_gender_subcategories' => 'boolean',
            'include_unisex' => 'boolean',
        ]);

        // Check featured category limit
        if ($request->has('is_featured')) {
            $featuredCount = Category::where('is_featured', true)->count();
            if ($featuredCount >= 3) {
                return back()->withErrors(['is_featured' => 'Maximum 3 categories can be featured. Please unfeature another category first.'])->withInput();
            }
        }

        $data = $request->except(['image', 'variation_types', 'create_gender_subcategories', 'include_unisex']);
        $data['gender'] = $request->input('gender', 'all');
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $data['is_customizable'] = $request->has('is_customizable');
        
        // Handle variation types
        $data['variation_types'] = $request->input('variation_types', []);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image_path'] = $imagePath;
        }

        // Create the main category
        $category = Category::create($data);

        // Create gender-based subcategories if requested
        if ($request->has('create_gender_subcategories')) {
            $this->createGenderSubcategories($category, $request->has('include_unisex'));
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully!');
    }

    /**
     * Create gender-based subcategories for a category
     */
    private function createGenderSubcategories(Category $category, bool $includeUnisex = false)
    {
        $subcategories = [
            [
                'name' => "Men's {$category->name}",
                'slug' => "mens-" . $category->slug,
                'description' => "Men's {$category->name} - {$category->description}",
                'icon' => '👔',
                'variation_types' => $category->variation_types,
            ],
            [
                'name' => "Women's {$category->name}",
                'slug' => "womens-" . $category->slug,
                'description' => "Women's {$category->name} - {$category->description}",
                'icon' => '👗',
                'variation_types' => $category->variation_types,
            ],
        ];

        if ($includeUnisex) {
            $subcategories[] = [
                'name' => "Unisex {$category->name}",
                'slug' => "unisex-" . $category->slug,
                'description' => "Unisex {$category->name} - {$category->description}",
                'icon' => '✨',
                'variation_types' => $category->variation_types,
            ];
        }

        foreach ($subcategories as $subcategoryData) {
            Category::create([
                'name' => $subcategoryData['name'],
                'slug' => $subcategoryData['slug'],
                'description' => $subcategoryData['description'],
                'icon' => $subcategoryData['icon'],
                'is_active' => $category->is_active,
                'is_featured' => false, // Subcategories are not featured by default
                'sort_order' => 1,
                'parent_id' => $category->id,
                'variation_types' => $subcategoryData['variation_types'],
            ]);
        }
    }

    public function show(Category $category)
    {
        $category->load(['products' => function($query) {
            $query->latest()->limit(10);
        }]);
        
        $stats = [
            'total_products' => $category->products()->count(),
            'active_products' => $category->products()->where('is_active', true)->count(),
            'total_revenue' => $category->products()->join('order_items', 'products.id', '=', 'order_items.product_id')
                ->sum('order_items.total'),
        ];

        return view('admin.categories.show', compact('category', 'stats'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'is_active' => 'boolean',
            'is_featured' => 'boolean',
            'is_customizable' => 'boolean',
            'variation_types' => 'nullable|array',
            'variation_types.*' => 'string|in:size,color,material,style,fit,pattern',
        ]);

        // Check featured category limit (only if trying to feature a category that wasn't featured before)
        if ($request->has('is_featured') && !$category->is_featured) {
            $featuredCount = Category::where('is_featured', true)->count();
            if ($featuredCount >= 3) {
                return back()->withErrors(['is_featured' => 'Maximum 3 categories can be featured. Please unfeature another category first.'])->withInput();
            }
        }

        $data = $request->except(['image', 'variation_types']);
        $data['slug'] = Str::slug($request->name);
        $data['is_active'] = $request->has('is_active');
        $data['is_featured'] = $request->has('is_featured');
        $data['is_customizable'] = $request->has('is_customizable');
        
        // Handle variation types
        $data['variation_types'] = $request->input('variation_types', []);

        if ($request->hasFile('image')) {
            if ($category->image_path) {
                \Storage::disk('public')->delete($category->image_path);
            }
            
            $imagePath = $request->file('image')->store('categories', 'public');
            $data['image_path'] = $imagePath;
        }

        $category->update($data);

        return redirect()->route('admin.categories.show', $category)
            ->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with('error', 'Cannot delete category with existing products!');
        }

        if ($category->image_path) {
            \Storage::disk('public')->delete($category->image_path);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully!');
    }

    public function toggleStatus(Category $category)
    {
        $category->update(['is_active' => !$category->is_active]);

        $status = $category->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Category {$status} successfully!");
    }
} 
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\VariationOption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductVariationController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    /**
     * Show the form for managing variations of a product.
     */
    public function index(Product $product)
    {
        $product->load(['variations.options' => function($query) {
            $query->orderBy('sort_order');
        }]);
        
        return view('admin.products.variations.index', compact('product'));
    }

    /**
     * Store a new variation (e.g., Color).
     */
    public function store(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:select,radio,checkbox',
            'is_required' => 'boolean',
        ]);

        $variation = $product->variations()->create([
            'name' => $request->name,
            'type' => $request->type,
            'is_required' => $request->boolean('is_required'),
            'sort_order' => $product->variations()->max('sort_order') + 1,
        ]);

        return redirect()->route('admin.products.variations.index', $product)
            ->with('success', 'Variation created successfully!');
    }

    /**
     * Store a new variation option (e.g., Red, Blue, Green for Color).
     */
    public function storeOption(Request $request, ProductVariation $variation)
    {
        $request->validate([
            'value' => 'required|string|max:255',
            'label' => 'nullable|string|max:255',
            'price_adjustment' => 'required|numeric',
            'stock' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->except('image');
        $data['sort_order'] = $variation->options()->max('sort_order') + 1;

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('variations', 'public');
            $data['image'] = $imagePath;
        }

        $variation->options()->create($data);

        return redirect()->route('admin.products.variations.index', $variation->product)
            ->with('success', 'Variation option created successfully!');
    }

    /**
     * Update a variation option.
     */
    public function updateOption(Request $request, VariationOption $option)
    {
        $request->validate([
            'value' => 'required|string|max:255',
            'label' => 'nullable|string|max:255',
            'price_adjustment' => 'required|numeric',
            'stock' => 'nullable|integer|min:0',
            'sku' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $data = $request->except('image');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($option->image) {
                Storage::disk('public')->delete($option->image);
            }
            
            $imagePath = $request->file('image')->store('variations', 'public');
            $data['image'] = $imagePath;
        }

        $option->update($data);

        return redirect()->route('admin.products.variations.index', $option->variation->product)
            ->with('success', 'Variation option updated successfully!');
    }

    /**
     * Delete a variation option.
     */
    public function destroyOption(VariationOption $option)
    {
        // Delete image if exists
        if ($option->image) {
            Storage::disk('public')->delete($option->image);
        }

        $product = $option->variation->product;
        $option->delete();

        return redirect()->route('admin.products.variations.index', $product)
            ->with('success', 'Variation option deleted successfully!');
    }

    /**
     * Toggle variation option active status.
     */
    public function toggleOptionStatus(VariationOption $option)
    {
        $option->update(['is_active' => !$option->is_active]);

        $status = $option->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Variation option {$status} successfully!");
    }

    /**
     * Update sort order of variation options.
     */
    public function updateSortOrder(Request $request, ProductVariation $variation)
    {
        $request->validate([
            'options' => 'required|array',
            'options.*' => 'exists:variation_options,id',
        ]);

        foreach ($request->options as $index => $optionId) {
            VariationOption::where('id', $optionId)->update(['sort_order' => $index]);
        }

        return response()->json(['success' => true]);
    }
} 
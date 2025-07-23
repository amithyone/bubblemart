<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class CustomizationController extends Controller
{
    /**
     * Show the customization page with category selection.
     */
    public function index()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('is_featured', 'desc') // Featured categories first
            ->orderBy('sort_order')
            ->get();

        return view('customize.index', compact('categories'));
    }

    /**
     * Show products for selected category.
     */
    public function selectCategory(Category $category)
    {
        $products = Product::where('category_id', $category->id)
            ->where('is_active', true)
            ->with(['store'])
            ->get();

        return view('customize.select-product', compact('category', 'products'));
    }

    /**
     * Show customization options for selected product.
     */
    public function selectProduct(Product $product)
    {
        $customizationTypes = $this->getCustomizationTypesForProduct($product);

        return view('customize.select-type', compact('product', 'customizationTypes'));
    }

    /**
     * Show customization form based on selected type.
     */
    public function customize(Request $request, Product $product)
    {
        // If type is provided, validate it
        if ($request->has('type')) {
            $request->validate([
                'type' => 'required|in:card,print,engrave,embroidery'
            ]);
            $type = $request->type;
        } else {
            // Default to 'card' if no type is provided
            $type = 'card';
        }

        $customizationInfo = $this->getCustomizationInfo($type);
        $productOptions = $this->getProductOptions($product);
        $receiverInfo = session('customize.receiver_info', []);

        return view('customize.form', compact('product', 'type', 'customizationInfo', 'productOptions', 'receiverInfo'));
    }

    /**
     * Store customization data.
     */
    public function store(Request $request)
    {
        // Ensure user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please login to complete your customization.');
        }

        $receiverInfo = session('customize.receiver_info', []);
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'customization_type' => 'required|in:card,print,engrave,embroidery',
            'content_type' => 'required|in:message,image,text',
            'message' => 'nullable|string|max:500',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif|max:5120',
            'special_request' => 'nullable|string|max:1000',
            // Product-specific fields
            'ring_size' => 'nullable|string|in:3,3.5,4,4.5,5,5.5,6,6.5,7,7.5,8,8.5,9,9.5,10,10.5,11,11.5,12',
            'bracelet_size' => 'nullable|string|in:xs,s,m,l,xl,xxl',
            'necklace_length' => 'nullable|string|in:16,18,20,22,24',
            'apparel_size' => 'nullable|string|in:xs,s,m,l,xl,xxl',
            'frame_size' => 'nullable|string|in:small,medium,large',
            'cup_type' => 'nullable|string|in:ceramic,glass,plastic,stainless_steel',
            'card_type' => 'nullable|string|in:atm,credit,debit,gift',
            'pillow_size' => 'nullable|string|in:small,medium,large,extra_large',
            'blanket_size' => 'nullable|string|in:throw,full,queen,king',
            'material' => 'nullable|string|in:sterling_silver,gold_plated,rose_gold,stainless_steel',
        ]);

        // Handle file uploads
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('customizations/images', 'public');
        }

        // Calculate additional cost
        $additionalCost = $this->calculateCustomizationCost($request);

        // Create customization
        $customization = auth()->user()->customizations()->create(array_merge([
            'product_id' => $request->product_id,
            'type' => $request->customization_type,
            'message' => $request->input('message'),
            'media_path' => $imagePath,
            'additional_cost' => $additionalCost,
            'special_request' => $request->special_request,
            'status' => 'pending',
            // Product-specific fields
            'ring_size' => $request->ring_size,
            'bracelet_size' => $request->bracelet_size,
            'necklace_length' => $request->necklace_length,
            'apparel_size' => $request->apparel_size,
            'frame_size' => $request->frame_size,
            'cup_type' => $request->cup_type,
            'card_type' => $request->card_type,
            'pillow_size' => $request->pillow_size,
            'blanket_size' => $request->blanket_size,
            'material' => $request->material,
        ], $receiverInfo));

        // Clear receiver info from session after storing
        session()->forget('customize.receiver_info');

        return redirect()->route('customize.checkout', ['customization' => $customization->id])
            ->with('success', 'Customization created successfully!');
    }

    /**
     * Show checkout page for customization.
     */
    public function checkout($customizationId)
    {
        $customization = auth()->user()->customizations()->with('product')->findOrFail($customizationId);
        
        return view('customize.checkout', compact('customization'));
    }

    /**
     * Get customization types based on product category/type
     */
    private function getCustomizationTypesForProduct(Product $product)
    {
        $productName = strtolower($product->name);
        $categoryName = strtolower($product->category->name ?? '');

        // Jewelry customization types
        if (str_contains($categoryName, 'jewelry') || in_array($productName, ['ring', 'necklace', 'bracelet', 'wristwatch'])) {
            return [
                'engrave' => [
                    'name' => 'Engraving',
                    'description' => 'Laser engrave your message or design on the jewelry',
                    'icon' => 'bi bi-pencil-square',
                    'options' => ['text', 'image']
                ],
                'print' => [
                    'name' => 'Print Customization',
                    'description' => 'Print your message or image directly on the jewelry',
                    'icon' => 'bi bi-printer',
                    'options' => ['text', 'image']
                ]
            ];
        }

        // Apparel customization types
        if (in_array($productName, ['hoodie', 'tshirt', 'cap'])) {
            return [
                'print' => [
                    'name' => 'Print Customization',
                    'description' => 'Print your message or image directly on the fabric',
                    'icon' => 'bi bi-printer',
                    'options' => ['text', 'image']
                ],
                'embroidery' => [
                    'name' => 'Embroidery',
                    'description' => 'Embroider your text or design on the fabric',
                    'icon' => 'bi bi-thread',
                    'options' => ['text']
                ]
            ];
        }

        // Frame customization types
        if (str_contains($productName, 'frame')) {
            return [
                'print' => [
                    'name' => 'Print Customization',
                    'description' => 'Print your photo or design on the frame',
                    'icon' => 'bi bi-printer',
                    'options' => ['image', 'text']
                ],
                'card' => [
                    'name' => 'Custom Card',
                    'description' => 'Add a personalized card with your message',
                    'icon' => 'bi bi-envelope',
                    'options' => ['message', 'image']
                ]
            ];
        }

        // Default customization types
        return [
            'card' => [
                'name' => 'Custom Card',
                'description' => 'Add a personalized card with your message or image',
                'icon' => 'bi bi-envelope',
                'options' => ['message', 'image']
            ],
            'print' => [
                'name' => 'Print Customization',
                'description' => 'Print your message or image directly on the gift',
                'icon' => 'bi bi-printer',
                'options' => ['text', 'image']
            ]
        ];
    }

    /**
     * Get customization info with costs
     */
    private function getCustomizationInfo($type)
    {
        $info = [
            'card' => [
                'name' => 'Custom Card',
                'description' => 'Add a personalized card with your message or image',
                'icon' => 'bi bi-envelope',
                'base_cost' => 5.00
            ],
            'print' => [
                'name' => 'Print Customization',
                'description' => 'Print your message or image directly on the gift',
                'icon' => 'bi bi-printer',
                'base_cost' => 8.00
            ],
            'engrave' => [
                'name' => 'Engraving',
                'description' => 'Laser engrave your message or design',
                'icon' => 'bi bi-pencil-square',
                'base_cost' => 12.00
            ],
            'embroidery' => [
                'name' => 'Embroidery',
                'description' => 'Embroider your text or design',
                'icon' => 'bi bi-thread',
                'base_cost' => 15.00
            ]
        ];

        return $info[$type] ?? $info['print'];
    }

    /**
     * Get product-specific options (sizes, types, etc.)
     */
    private function getProductOptions(Product $product)
    {
        $options = [];

        // Get product variations and convert them to customization options
        foreach ($product->activeVariations as $variation) {
            $fieldName = strtolower(str_replace(' ', '_', $variation->name));
            
            $options[$fieldName] = [
                'label' => $variation->name,
                'type' => 'select',
                'required' => $variation->is_required,
                'options' => []
            ];

            foreach ($variation->activeOptions as $option) {
                $options[$fieldName]['options'][$option->value] = $option->display_label;
            }
        }

        // Fallback to hardcoded options if no variations exist
        if (empty($options)) {
            $productName = strtolower($product->name);
            $categoryName = strtolower($product->category->name ?? '');

            // Ring sizes
            if ($productName === 'ring' || str_contains($productName, 'charm')) {
                $options['ring_size'] = [
                    'label' => 'Ring Size',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        '3' => 'US 3 (14.1mm)', '3.5' => 'US 3.5 (14.5mm)', '4' => 'US 4 (14.9mm)', 
                        '4.5' => 'US 4.5 (15.3mm)', '5' => 'US 5 (15.7mm)', '5.5' => 'US 5.5 (16.1mm)',
                        '6' => 'US 6 (16.5mm)', '6.5' => 'US 6.5 (16.9mm)', '7' => 'US 7 (17.3mm)', 
                        '7.5' => 'US 7.5 (17.7mm)', '8' => 'US 8 (18.1mm)', '8.5' => 'US 8.5 (18.5mm)',
                        '9' => 'US 9 (18.9mm)', '9.5' => 'US 9.5 (19.3mm)', '10' => 'US 10 (19.7mm)', 
                        '10.5' => 'US 10.5 (20.1mm)', '11' => 'US 11 (20.5mm)', '11.5' => 'US 11.5 (20.9mm)',
                        '12' => 'US 12 (21.3mm)'
                    ]
                ];
            }

            // Bracelet sizes
            if (str_contains($productName, 'bracelet')) {
                $options['bracelet_size'] = [
                    'label' => 'Bracelet Size',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        'xs' => 'XS (6.5" / 16.5cm)', 's' => 'S (7" / 17.8cm)', 'm' => 'M (7.5" / 19cm)',
                        'l' => 'L (8" / 20.3cm)', 'xl' => 'XL (8.5" / 21.6cm)', 'xxl' => 'XXL (9" / 22.9cm)'
                    ]
                ];
            }

            // Apparel sizes
            if (in_array($productName, ['hoodie', 'tshirt', 'cap'])) {
                $options['apparel_size'] = [
                    'label' => 'Size',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        'xs' => 'XS (Extra Small)', 's' => 'S (Small)', 'm' => 'M (Medium)', 
                        'l' => 'L (Large)', 'xl' => 'XL (Extra Large)', 'xxl' => 'XXL (2XL)'
                    ]
                ];
            }

            // Frame sizes
            if (str_contains($productName, 'frame')) {
                $options['frame_size'] = [
                    'label' => 'Frame Size',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        'small' => 'Small (4x6")',
                        'medium' => 'Medium (8x10")',
                        'large' => 'Large (11x14")'
                    ]
                ];
            }

            // Cup types
            if (in_array($productName, ['cup', 'mug'])) {
                $options['cup_type'] = [
                    'label' => 'Cup Type',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        'ceramic' => 'Ceramic',
                        'glass' => 'Glass',
                        'plastic' => 'Plastic',
                        'stainless_steel' => 'Stainless Steel'
                    ]
                ];
            }

            // Card types
            if (in_array($productName, ['fan card', 'atm card'])) {
                $options['card_type'] = [
                    'label' => 'Card Type',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        'atm' => 'ATM Card',
                        'credit' => 'Credit Card',
                        'debit' => 'Debit Card',
                        'gift' => 'Gift Card'
                    ]
                ];
            }

            // Pillow sizes
            if ($productName === 'pillow') {
                $options['pillow_size'] = [
                    'label' => 'Pillow Size',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        'small' => 'Small (12x12")',
                        'medium' => 'Medium (16x16")',
                        'large' => 'Large (18x18")',
                        'extra_large' => 'Extra Large (20x20")'
                    ]
                ];
            }

            // Blanket sizes
            if ($productName === 'blanket') {
                $options['blanket_size'] = [
                    'label' => 'Blanket Size',
                    'type' => 'select',
                    'required' => true,
                    'options' => [
                        'throw' => 'Throw (50x60")',
                        'full' => 'Full (80x90")',
                        'queen' => 'Queen (90x90")',
                        'king' => 'King (108x90")'
                    ]
                ];
            }
        }

        return $options;
    }

    /**
     * Calculate additional cost for customization.
     */
    private function calculateCustomizationCost(Request $request)
    {
        $cost = 0;

        // Base cost for customization type
        $customizationInfo = $this->getCustomizationInfo($request->customization_type);
        $cost += $customizationInfo['base_cost'];

        // Additional cost for content type
        if ($request->content_type === 'image') {
            $cost += 3.00; // Additional cost for image processing
        }

        // Special request cost
        if ($request->special_request) {
            $cost += 2.00; // Additional cost for special requests
        }

        // Product-specific costs
        if ($request->customization_type === 'engrave') {
            $cost += 5.00; // Additional cost for engraving
        }

        if ($request->customization_type === 'embroidery') {
            $cost += 8.00; // Additional cost for embroidery
        }

        return $cost;
    }

    public function receiverInfo(Product $product)
    {
        return view('customize.receiver-info', compact('product'));
    }

    public function receiverInfoStore(Request $request, Product $product)
    {
        $validated = $request->validate([
            'sender_name' => 'required|string|max:100',
            'receiver_name' => 'nullable|string|max:100',
            'receiver_gender' => 'nullable|in:male,female,other',
            'receiver_phone' => 'nullable|string|max:20',
            'delivery_method' => 'required|in:home_delivery,store_pickup',
            'receiver_note' => 'nullable|string|max:100',
            'receiver_address' => 'nullable|string|max:255',
            'receiver_zip' => 'required|string|regex:/^[0-9]{5}(-[0-9]{4})?$/|max:10',
            'receiver_city' => 'required|string|max:100',
            'receiver_state' => 'required|string|size:2|in:AL,AK,AZ,AR,CA,CO,CT,DE,DC,FL,GA,HI,ID,IL,IN,IA,KS,KY,LA,ME,MD,MA,MI,MN,MS,MO,MT,NE,NV,NH,NJ,NM,NY,NC,ND,OH,OK,OR,PA,RI,SC,SD,TN,TX,UT,VT,VA,WA,WV,WI,WY',
            'receiver_street' => 'required|string|max:100',
            'receiver_house_number' => 'nullable|string|max:20',
        ]);

        // Store in session for next step
        session(['customize.receiver_info' => $validated]);
        
        return redirect()->route('customize.form', $product->slug)->with('success', 'Sender details saved!');
    }
}

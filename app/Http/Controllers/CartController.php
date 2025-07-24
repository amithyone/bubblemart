<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Customization;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\XtrapayService;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Address; // Added this import for Address model

class CartController extends Controller
{
    protected $xtrapayService;

    public function __construct()
    {
        $this->xtrapayService = new XtrapayService();
    }

    /**
     * Get cart items from session data
     */
    private function getCartItems($cart)
    {
        $cartItems = [];
        
        foreach ($cart as $cartKey => $item) {
            $parts = explode('_', $cartKey);
            $productId = $parts[0];
            
            $product = Product::find($productId);
            if ($product) {
                $cartItems[] = [
                    'product' => $product,
                    'cartKey' => $cartKey,
                    'item' => $item
                ];
            }
        }
        
        return $cartItems;
    }

    /**
     * Check if cart items are compatible with the given address
     */
    private function validateCartScopeCompatibility($cartItems, $address)
    {
        $errors = [];
        
        foreach ($cartItems as $item) {
            $product = $item['product'];
            
            // Check if US-only product is being shipped to non-US address
            if ($product->isUsOnly() && !$address->isUsAddress()) {
                $errors[] = "Product '{$product->name}' is US-only and cannot be shipped to {$address->getCountryDisplayNameAttribute()}";
            }
            
            // Check if international product is being shipped to non-enabled country
            if ($product->isInternational()) {
                $enabledCountries = \App\Models\Setting::getEnabledCountries();
                if (!array_key_exists($address->country, $enabledCountries)) {
                    $errors[] = "Product '{$product->name}' cannot be shipped to {$address->getCountryDisplayNameAttribute()}";
                }
            }
        }
        
        return $errors;
    }

    /**
     * Display the shopping cart.
     */
    public function index()
    {
        $cart = Session::get('cart', []);
        
        // Debug logging
        \Log::info('Cart index method called', [
            'user_id' => auth()->id(),
            'cart_data' => $cart,
            'cart_count' => count($cart),
            'session_id' => session()->getId()
        ]);
        
        $cartItems = [];
        $total = 0;

        foreach ($cart as $cartKey => $item) {
            // Handle cart keys that might be "productId_customizationId_variationHash" format
            $parts = explode('_', $cartKey);
            $productId = $parts[0];
            
            $product = Product::find($productId);
            if ($product) {
                $quantity = is_array($item) ? $item['quantity'] : $item;
                $customizationId = is_array($item) ? $item['customization_id'] : null;
                $variations = is_array($item) ? ($item['variations'] ?? []) : [];
                
                // If no customization_id in item array, check if it's in the cart key
                if (!$customizationId && count($parts) > 1 && $parts[1] === 'c') {
                    $customizationId = $parts[2] ?? null;
                }
                
                $customization = $customizationId ? Customization::find($customizationId) : null;
                
                // Calculate price adjustments from variations
                $variationAdjustment = 0;
                $variationDetails = [];
                
                if (!empty($variations)) {
                    foreach ($variations as $variationName => $optionId) {
                        $option = \App\Models\ProductVariationOption::find($optionId);
                        if ($option) {
                            $variationAdjustment += $option->price_adjustment;
                            $variationDetails[] = [
                                'name' => $option->variation->name,
                                'option' => $option->option_label,
                                'adjustment' => $option->price_adjustment
                            ];
                        }
                    }
                }
                
                $unitPrice = $product->final_price_naira + $variationAdjustment + ($customization ? $customization->additional_cost : 0);
                $subtotal = $unitPrice * $quantity;
                
                $cartItems[] = [
                    'product' => $product,
                    'quantity' => $quantity,
                    'customization' => $customization,
                    'variations' => $variationDetails,
                    'variationAdjustment' => $variationAdjustment,
                    'unitPrice' => $unitPrice,
                    'subtotal' => $subtotal,
                    'cartKey' => $cartKey,
                    'receiver_name' => is_array($item) ? ($item['receiver_name'] ?? '') : '',
                    'receiver_phone' => is_array($item) ? ($item['receiver_phone'] ?? '') : '',
                    'receiver_address' => is_array($item) ? ($item['receiver_address'] ?? '') : '',
                    'receiver_city' => is_array($item) ? ($item['receiver_city'] ?? '') : '',
                    'receiver_state' => is_array($item) ? ($item['receiver_state'] ?? '') : '',
                    'receiver_zip' => is_array($item) ? ($item['receiver_zip'] ?? '') : '',
                    'receiver_note' => is_array($item) ? ($item['receiver_note'] ?? '') : '',
                    'address_id' => is_array($item) ? ($item['address_id'] ?? null) : null
                ];
                $total += $subtotal;
            }
        }

        return view('cart.index', compact('cartItems', 'total'));
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request, $productId)
    {
        \Log::info('Cart add method called', [
            'product_id' => $productId,
            'user_id' => auth()->id(),
            'save_address' => $request->boolean('save_address'),
            'save_address_raw' => $request->input('save_address'),
            'receiver_name' => $request->receiver_name,
            'receiver_phone' => $request->receiver_phone,
            'receiver_address' => $request->receiver_address,
            'receiver_city' => $request->receiver_city,
            'receiver_state' => $request->receiver_state,
            'receiver_zip' => $request->receiver_zip,
            'all_request_data' => $request->all(),
            'method' => $request->method(),
            'content_type' => $request->header('Content-Type')
        ]);
        
        $product = Product::findOrFail($productId);
        $cart = Session::get('cart', []);
        $customizationId = $request->input('customization_id');
        $variations = $request->input('variations', []);
        $quantity = $request->input('quantity', 1);
        
        // Validate receiver information
        $request->validate([
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'receiver_address' => 'required|string',
            'receiver_city' => 'required|string|max:255',
            'receiver_state' => 'required|string|max:2',
            'receiver_zip' => 'required|string|max:10',
            'receiver_note' => 'nullable|string',
            'save_address' => 'nullable|boolean'
        ]);
        
        // If customization is provided, validate it belongs to the user
        if ($customizationId) {
            $customization = Customization::where('id', $customizationId)
                ->where('user_id', auth()->id())
                ->where('product_id', $productId)
                ->firstOrFail();
        }
        
        // Save address if requested
        $addressId = null;
        \Log::info('Address saving check', [
            'save_address_boolean' => $request->boolean('save_address'),
            'save_address_raw' => $request->input('save_address'),
            'user_authenticated' => auth()->check(),
            'user_id' => auth()->id()
        ]);
        
        if ($request->boolean('save_address') && auth()->check()) {
            try {
                // Check if address already exists to avoid duplicates
                $existingAddress = Address::where('user_id', auth()->id())
                    ->where('name', $request->receiver_name)
                    ->where('phone', $request->receiver_phone)
                    ->where('address_line_1', $request->receiver_address)
                    ->where('city', $request->receiver_city)
                    ->where('state', $request->receiver_state)
                    ->where('postal_code', $request->receiver_zip)
                    ->first();
                
                \Log::info('Address duplicate check', [
                    'existing_address' => $existingAddress ? $existingAddress->id : null,
                    'search_criteria' => [
                        'user_id' => auth()->id(),
                        'name' => $request->receiver_name,
                        'phone' => $request->receiver_phone,
                        'address_line_1' => $request->receiver_address,
                        'city' => $request->receiver_city,
                        'state' => $request->receiver_state,
                        'postal_code' => $request->receiver_zip
                    ]
                ]);
                
                if ($existingAddress) {
                    $addressId = $existingAddress->id;
                    \Log::info('Using existing address', [
                        'address_id' => $addressId,
                        'receiver_name' => $request->receiver_name
                    ]);
                } else {
                    $address = Address::create([
                        'user_id' => auth()->id(),
                        'name' => $request->receiver_name,
                        'phone' => $request->receiver_phone,
                        'address_line_1' => $request->receiver_address,
                        'city' => $request->receiver_city,
                        'state' => $request->receiver_state,
                        'postal_code' => $request->receiver_zip,
                        'country' => 'USA',
                        'is_default' => false,
                        'label' => 'Saved Address'
                    ]);
                    $addressId = $address->id;
                    
                    \Log::info('Address saved successfully', [
                        'user_id' => auth()->id(),
                        'address_id' => $addressId,
                        'receiver_name' => $request->receiver_name
                    ]);
                    
                    // Add success message to session
                    session()->flash('success', 'Address saved successfully for future orders!');
                }
            } catch (\Exception $e) {
                \Log::error('Failed to save address', [
                    'user_id' => auth()->id(),
                    'error' => $e->getMessage(),
                    'data' => $request->only(['receiver_name', 'receiver_phone', 'receiver_address'])
                ]);
                
                // Continue without saving address, but log the error
                $addressId = null;
            }
        }
        
        // Create a unique cart key that includes variations
        $cartKey = $productId;
        $variationKey = '';
        
        if (!empty($variations)) {
            // Sort variations to ensure consistent keys
            ksort($variations);
            $variationKey = '_v_' . md5(serialize($variations));
        }
        
        if ($customizationId) {
            $cartKey = $productId . '_c_' . $customizationId . $variationKey;
        } else {
            $cartKey = $productId . $variationKey;
        }
        
        // Check if this exact combination already exists in cart
        if (isset($cart[$cartKey])) {
            if (is_array($cart[$cartKey])) {
                $cart[$cartKey]['quantity'] += $quantity;
            } else {
                $cart[$cartKey] = [
                    'quantity' => $cart[$cartKey] + $quantity,
                    'variations' => $variations
                ];
            }
        } else {
            $cart[$cartKey] = [
                'quantity' => $quantity,
                'customization_id' => $customizationId,
                'variations' => $variations,
                'receiver_name' => $request->receiver_name,
                'receiver_phone' => $request->receiver_phone,
                'receiver_address' => $request->receiver_address,
                'receiver_city' => $request->receiver_city,
                'receiver_state' => $request->receiver_state,
                'receiver_zip' => $request->receiver_zip,
                'receiver_note' => $request->receiver_note,
                'address_id' => $addressId
            ];
        }
        
        Session::put('cart', $cart);
        
        // Debug logging after adding to cart
        \Log::info('Product added to cart', [
            'user_id' => auth()->id(),
            'product_id' => $productId,
            'cart_key' => $cartKey,
            'cart_data' => $cart,
            'cart_count' => count($cart),
            'session_id' => session()->getId()
        ]);
        
        $successMessage = 'Product added to cart successfully!';
        if ($request->boolean('save_address') && auth()->check() && $addressId) {
            $successMessage .= ' Address saved for future orders.';
        }
        
        \Log::info('Redirecting to cart', [
            'user_id' => auth()->id(),
            'success_message' => $successMessage,
            'cart_count' => count($cart),
            'session_id' => session()->getId()
        ]);
        
        return redirect()->route('cart.index')->with('success', $successMessage);
    }

    /**
     * Remove a product from the cart.
     */
    public function remove($productId)
    {
        $cart = Session::get('cart', []);
        
        // Remove all items with this product ID (including customized versions)
        foreach ($cart as $key => $item) {
            if (strpos($key, $productId . '_') === 0 || $key == $productId) {
                unset($cart[$key]);
            }
        }
        
        Session::put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    /**
     * Update cart item quantity.
     */
    public function update(Request $request, $productId)
    {
        $quantity = $request->input('quantity', 1);
        $customizationId = $request->input('customization_id');
        $cart = Session::get('cart', []);
        
        $cartKey = $productId;
        if ($customizationId) {
            $cartKey = $productId . '_' . $customizationId;
        }
        
        if ($quantity > 0) {
            if ($customizationId) {
                $cart[$cartKey] = [
                    'quantity' => $quantity,
                    'customization_id' => $customizationId
                ];
            } else {
                $cart[$cartKey] = $quantity;
            }
        } else {
            unset($cart[$cartKey]);
        }
        
        Session::put('cart', $cart);
        
        return redirect()->route('cart.index')->with('success', 'Cart updated successfully!');
    }

    /**
     * Clear the entire cart.
     */
    public function clear()
    {
        Session::forget('cart');
        return redirect()->route('cart.index')->with('success', 'Cart cleared successfully!');
    }

    /**
     * Get cart count for the badge.
     */
    public function getCount()
    {
        $cart = Session::get('cart', []);
        return count($cart);
    }

    /**
     * Pay with wallet balance.
     */
    public function payWithWallet(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'address_id' => 'required|exists:addresses,id'
        ]);

        $user = auth()->user();
        $wallet = $user->wallet;
        $amount = $request->amount;
        $address = Address::findOrFail($request->address_id);

        // Validate that the user owns this address
        if ($address->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid shipping address selected.'
            ]);
        }

        // Get cart items for scope validation
        $cart = Session::get('cart', []);
        $cartItems = $this->getCartItems($cart);
        
        // Validate product scope compatibility
        $scopeErrors = $this->validateCartScopeCompatibility($cartItems, $address);
        if (!empty($scopeErrors)) {
            return response()->json([
                'success' => false,
                'message' => 'Shipping restriction: ' . implode(', ', $scopeErrors)
            ]);
        }

        // Log the payment attempt
        \Log::info('Wallet payment attempt', [
            'user_id' => $user->id,
            'amount' => $amount,
            'wallet_balance' => $wallet ? $wallet->balance : 'no_wallet',
            'cart_items' => Session::get('cart', [])
        ]);

        // Check if wallet exists and has sufficient balance
        if (!$wallet || $wallet->balance < $amount) {
            \Log::warning('Insufficient wallet balance', [
                'user_id' => $user->id,
                'amount' => $amount,
                'wallet_balance' => $wallet ? $wallet->balance : 'no_wallet'
            ]);
            return redirect()->route('cart.index')->with('error', 'Insufficient wallet balance. Please add funds to your wallet.');
        }

        try {
            DB::beginTransaction();

            // Deduct from wallet
            $wallet->debit(
                $amount,
                "Payment for cart items",
                'cart_payment',
                null,
                ['cart_total' => $amount]
            );

            // Create order
            $order = $this->createOrderFromCart($user, $amount, 'wallet');

            // Clear cart
            Session::forget('cart');

            DB::commit();

            \Log::info('Wallet payment successful', [
                'user_id' => $user->id,
                'order_id' => $order->id,
                'amount' => $amount
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Payment successful! Your order has been placed.',
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'redirect_url' => route('orders.show', $order)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Wallet payment failed', [
                'user_id' => $user->id,
                'amount' => $amount,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Payment failed. Please try again.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate XtraPay virtual account for cart payment.
     */
    public function generateXtrapay(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100|max:1000000'
        ]);

        try {
            $result = $this->xtrapayService->initiateFunding($request->amount);
            
            // Check if there's an error (should not happen now with fallback to demo mode)
            if (isset($result['error'])) {
                return response()->json([
                    'success' => false,
                    'message' => $result['message'] ?? 'Failed to generate virtual account'
                ], 400);
            }

            // Store the reference for later verification
            $user = auth()->user();
            
            // Create a pending order
            $order = $this->createOrderFromCart($user, $request->amount, 'xtrapay', $result['reference']);

            $response = [
                'success' => true,
                'reference' => $result['reference'],
                'accountNumber' => $result['accountNumber'],
                'bank' => $result['bank'],
                'accountName' => $result['accountName'],
                'amount' => $result['amount'],
                'expiry' => $result['expiry']
            ];

            // Add demo mode indicator if applicable
            if (isset($result['demo_mode'])) {
                $response['demo_mode'] = true;
                $response['message'] = 'Demo mode: This is a test payment. In production, you would transfer to the actual bank account.';
            }

            return response()->json($response);

        } catch (\Exception $e) {
            \Log::error('Cart Xtrapay Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to generate virtual account. Please try again.'
            ], 500);
        }
    }

    /**
     * Check payment status for XtraPay.
     */
    public function checkPayment(Request $request)
    {
        $request->validate([
            'reference' => 'required|string'
        ]);

        try {
            // Find the order by reference
            $order = Order::where('payment_reference', $request->reference)
                         ->where('status', 'pending')
                         ->first();

            if (!$order) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found or already processed'
                ]);
            }

            // Verify payment with XtraPay API
            $verificationResult = $this->xtrapayService->verifyPayment($request->reference);
            
            \Log::info('CartController: Payment verification result', [
                'reference' => $request->reference,
                'result' => $verificationResult
            ]);

            if ($verificationResult['success']) {
                // Payment confirmed - update order status
                $order->update([
                    'status' => 'processing',
                    'payment_status' => 'paid',
                    'paid_at' => now()
                ]);

                // Clear cart
                Session::forget('cart');

                \Log::info('CartController: Payment confirmed successfully', [
                    'order_id' => $order->id,
                    'reference' => $request->reference
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Payment confirmed successfully! Your order has been placed.',
                    'order_id' => $order->id,
                    'order_number' => $order->order_number
                ]);
            } else {
                // Payment not yet confirmed
                $status = $verificationResult['status'] ?? 'pending';
                $message = $verificationResult['message'] ?? 'Payment not yet confirmed';
                
                \Log::info('CartController: Payment not yet confirmed', [
                    'order_id' => $order->id,
                    'reference' => $request->reference,
                    'status' => $status,
                    'message' => $message
                ]);

                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'status' => $status
                ]);
            }

        } catch (\Exception $e) {
            \Log::error('CartController: Payment verification error', [
                'reference' => $request->reference,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error checking payment status. Please try again.'
            ], 500);
        }
    }

    /**
     * Create order from cart items.
     */
    private function createOrderFromCart($user, $totalAmount, $paymentMethod, $paymentReference = null)
    {
        $cart = Session::get('cart', []);
        $deliveryFee = 500; // Fixed delivery fee

        $order = Order::create([
            'user_id' => $user->id,
            'order_number' => 'ORD-' . strtoupper(uniqid()),
            'subtotal' => $totalAmount - $deliveryFee,
            'total' => $totalAmount,
            'total_amount' => $totalAmount,
            'delivery_fee' => $deliveryFee,
            'payment_method' => $paymentMethod,
            'payment_reference' => $paymentReference,
            'status' => $paymentMethod === 'wallet' ? 'processing' : 'pending',
            'payment_status' => $paymentMethod === 'wallet' ? 'paid' : 'pending',
            'paid_at' => $paymentMethod === 'wallet' ? now() : null,
        ]);

        foreach ($cart as $cartKey => $item) {
            // Handle cart keys that might be "productId_customizationId_variationHash" format
            $parts = explode('_', $cartKey);
            $productId = $parts[0];
            
            $product = Product::find($productId);
            if ($product) {
                $quantity = is_array($item) ? $item['quantity'] : $item;
                $customizationId = is_array($item) ? $item['customization_id'] : null;
                $variations = is_array($item) ? ($item['variations'] ?? []) : [];
                
                // If no customization_id in item array, check if it's in the cart key
                if (!$customizationId && count($parts) > 1 && $parts[1] === 'c') {
                    $customizationId = $parts[2] ?? null;
                }
                
                $customization = $customizationId ? Customization::find($customizationId) : null;
                
                // Calculate price adjustments from variations
                $variationAdjustment = 0;
                if (!empty($variations)) {
                    foreach ($variations as $variationName => $optionId) {
                        $option = \App\Models\ProductVariationOption::find($optionId);
                        if ($option) {
                            $variationAdjustment += $option->price_adjustment;
                        }
                    }
                }
                
                $unitPrice = $product->final_price_naira + $variationAdjustment + ($customization ? $customization->additional_cost : 0);
                
                // Determine receiver information
                $receiverName = 'Customer';
                $receiverAddress = 'Address not provided';
                $receiverPhone = 'Phone not provided';
                $receiverNote = null;
                
                if ($customization) {
                    // Use customization receiver info
                    $receiverName = $customization->receiver_name;
                    $receiverPhone = $customization->receiver_phone;
                    $receiverNote = $customization->receiver_note;
                    
                    // Build address from customization fields
                    $addressParts = [];
                    if ($customization->receiver_house_number) $addressParts[] = $customization->receiver_house_number;
                    if ($customization->receiver_street) $addressParts[] = $customization->receiver_street;
                    if ($customization->receiver_city) $addressParts[] = $customization->receiver_city;
                    if ($customization->receiver_state) $addressParts[] = $customization->receiver_state;
                    if ($customization->receiver_zip) $addressParts[] = $customization->receiver_zip;
                    
                    if (!empty($addressParts)) {
                        $receiverAddress = implode(', ', $addressParts);
                    } elseif ($customization->receiver_address) {
                        $receiverAddress = $customization->receiver_address;
                    }
                } else {
                    // Use regular product receiver info
                    $receiverName = is_array($item) ? ($item['receiver_name'] ?? 'Customer') : 'Customer';
                    $receiverPhone = is_array($item) ? ($item['receiver_phone'] ?? 'Phone not provided') : 'Phone not provided';
                    $receiverAddress = is_array($item) ? ($item['receiver_address'] ?? 'Address not provided') : 'Address not provided';
                    $receiverNote = is_array($item) ? ($item['receiver_note'] ?? null) : null;
                }

                $orderItem = OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'customization_id' => $customizationId,
                    'quantity' => $quantity,
                    'price' => $unitPrice,
                    'total' => $unitPrice * $quantity,
                    'receiver_name' => $receiverName,
                    'receiver_address' => $receiverAddress,
                    'receiver_phone' => $receiverPhone,
                    'receiver_note' => $receiverNote,
                ]);

                // Save product variations to order item
                if (!empty($variations)) {
                    foreach ($variations as $variationName => $optionId) {
                        \App\Models\ProductVariationOption::create([
                            'order_item_id' => $orderItem->id,
                            'variation_option_id' => $optionId
                        ]);
                    }
                }

                // Update product stock
                $product->decrement('stock', $quantity);
            }
        }

        return $order;
    }
} 
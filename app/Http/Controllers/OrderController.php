<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Notifications\OrderPlacedNotification;

class OrderController extends Controller
{
    /**
     * Display a listing of user's orders.
     */
    public function index()
    {
        $orders = Auth::user()->orders()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Load more orders for infinite scroll.
     */
    public function loadMore(Request $request)
    {
        $page = $request->get('page', 1);
        $perPage = 10;
        
        $orders = Auth::user()->orders()
            ->with('orderItems.product')
            ->orderBy('created_at', 'desc')
            ->skip(($page - 1) * $perPage)
            ->take($perPage)
            ->get();

        $hasMore = Auth::user()->orders()->count() > ($page * $perPage);

        if ($request->ajax()) {
            $ordersData = $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'total' => $order->total,
                    'order_status' => $order->order_status,
                    'created_at' => $order->created_at->toISOString(),
                    'order_items_count' => $order->orderItems->count(),
                ];
            });

            return response()->json([
                'orders' => $ordersData,
                'hasMore' => $hasMore,
                'nextPage' => $page + 1
            ]);
        }

        return view('orders.partials.order-list', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Check if user is authenticated
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please log in to view your orders.');
        }

        $currentUser = Auth::user();
        
        // Debug logging
        \Log::info('Order access attempt', [
            'order_id' => $order->id,
            'order_user_id' => $order->user_id,
            'current_user_id' => $currentUser->id,
            'order_number' => $order->order_number,
            'order_created_at' => $order->created_at,
            'user_authenticated' => Auth::check()
        ]);

        // Ensure user can only view their own orders (with type conversion)
        if ((int)$order->user_id !== (int)$currentUser->id) {
            \Log::warning('Order access denied', [
                'order_id' => $order->id,
                'order_user_id' => $order->user_id,
                'current_user_id' => $currentUser->id,
                'order_number' => $order->order_number,
                'user_id_type' => gettype($currentUser->id),
                'order_user_id_type' => gettype($order->user_id)
            ]);
            abort(403, 'You are not authorized to view this order.');
        }

        $order->load(['orderItems.product', 'orderItems.customization', 'orderItems.variationOptions']);

        \Log::info('Order access granted', [
            'order_id' => $order->id,
            'user_id' => $currentUser->id,
            'order_items_count' => $order->orderItems->count()
        ]);

        return view('orders.show', compact('order'));
    }

    /**
     * Store a newly created order.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'receiver_name' => 'required|string|max:255',
            'receiver_address' => 'required|string',
            'receiver_phone' => 'required|string|max:20',
            'receiver_note' => 'nullable|string',
            'payment_method' => 'required|in:instant,manual,wallet,xtrapay',
            'variations' => 'nullable|array',
        ]);

        $product = Product::findOrFail($request->product_id);
        
        // Calculate price with variations
        $basePrice = $product->final_price_naira;
        $variationAdjustments = 0;
        $selectedVariations = [];
        
        if ($request->has('variations') && is_array($request->variations)) {
            foreach ($request->variations as $variationName => $optionId) {
                if ($optionId) {
                    $option = \App\Models\VariationOption::find($optionId);
                    if ($option) {
                        $variationAdjustments += $option->price_adjustment;
                        $selectedVariations[] = [
                            'variation_option_id' => $option->id,
                            'variation_name' => $variationName,
                            'option_value' => $option->value,
                            'option_label' => $option->display_label,
                            'price_adjustment' => $option->price_adjustment,
                        ];
                    }
                }
            }
        }
        
        $finalPrice = $basePrice + $variationAdjustments;
        
        // Get dynamic settings
        $exchangeRate = \App\Models\Setting::getExchangeRate();
        $taxPercentage = \App\Models\Setting::getTaxPercentage();
        $shippingCostUsd = \App\Models\Setting::getShippingCostUsd();
        
        // Calculate totals in Naira
        $subtotalNaira = $finalPrice * $request->quantity;
        $taxNaira = $subtotalNaira * ($taxPercentage / 100);
        $shippingNaira = $shippingCostUsd * $exchangeRate;
        $totalNaira = $subtotalNaira + $taxNaira + $shippingNaira;

        // Handle wallet payment
        if ($request->payment_method === 'wallet') {
            $user = Auth::user();
            $wallet = $user->wallet;
            
            \Log::info('Wallet payment attempt', [
                'user_id' => $user->id,
                'amount' => $totalNaira,
                'wallet_balance' => $wallet ? $wallet->balance : 'no_wallet',
                'product' => $product->name
            ]);
            
            // Check if wallet exists and has sufficient balance
            if (!$wallet) {
                \Log::warning('No wallet found for user', [
                    'user_id' => $user->id
                ]);
                return back()->with('error', 'No wallet found. Please contact support to create a wallet for your account.');
            }
            
            if ($wallet->balance < $totalNaira) {
                \Log::warning('Insufficient wallet balance', [
                    'user_id' => $user->id,
                    'amount' => $totalNaira,
                    'wallet_balance' => $wallet->balance
                ]);
                return back()->with('error', 'Insufficient wallet balance. Please add funds to your wallet or choose a different payment method.');
            }
            
            try {
                \DB::beginTransaction();
                
                // Deduct from wallet
                $transaction = $wallet->debit(
                    $totalNaira,
                    "Payment for order - {$product->name}",
                    'order_payment',
                    null,
                    ['order_total' => $totalNaira, 'product_name' => $product->name]
                );
                
                if (!$transaction) {
                    throw new \Exception('Failed to debit wallet - insufficient funds');
                }
                
                \DB::commit();
                
                \Log::info('Wallet payment successful', [
                    'user_id' => $user->id,
                    'amount' => $totalNaira,
                    'transaction_id' => $transaction->id
                ]);
            } catch (\Exception $e) {
                \DB::rollBack();
                \Log::error('Wallet payment failed for order', [
                    'user_id' => $user->id,
                    'amount' => $totalNaira,
                    'error' => $e->getMessage()
                ]);
                return back()->with('error', 'Wallet payment failed. Please try again.');
            }
        }

        // Handle XtraPay payment
        if ($request->payment_method === 'xtrapay') {
            // For XtraPay, we'll create the order as pending and redirect to payment
            // This would typically integrate with XtraPay API
            \Log::info('XtraPay payment selected', [
                'user_id' => Auth::id(),
                'amount' => $totalNaira,
                'product' => $product->name
            ]);
        }

        // Create order (store amounts in Naira)
        $order = Auth::user()->orders()->create([
            'subtotal' => $subtotalNaira,
            'tax' => $taxNaira,
            'shipping' => $shippingNaira,
            'total' => $totalNaira,
            'payment_method' => $request->payment_method,
            'payment_status' => in_array($request->payment_method, ['instant', 'wallet']) ? 'paid' : 'pending',
            'paid_at' => in_array($request->payment_method, ['instant', 'wallet']) ? now() : null,
        ]);

        // Update wallet transaction with order reference if it's a wallet payment
        if ($request->payment_method === 'wallet' && isset($transaction)) {
            $transaction->update([
                'reference_id' => $order->id
            ]);
        }

        // Create order item (store price in Naira)
        $orderItem = $order->orderItems()->create([
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $finalPrice,
            'total' => $subtotalNaira,
            'receiver_name' => $request->receiver_name,
            'receiver_address' => $request->receiver_address,
            'receiver_phone' => $request->receiver_phone,
            'receiver_note' => $request->receiver_note,
        ]);

        // Create variation options for the order item
        foreach ($selectedVariations as $variation) {
            $orderItem->variationOptions()->create($variation);
        }

        // Send order confirmation email
        try {
            Auth::user()->notify(new OrderPlacedNotification($order));
        } catch (\Exception $e) {
            // Log the error but don't fail the order creation
            \Log::error('Failed to send order notification: ' . $e->getMessage());
        }

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order placed successfully! Check your email for confirmation.');
    }

    /**
     * Show the track gift page.
     */
    public function track()
    {
        return view('track.index');
    }

    /**
     * Update customization details for an order item.
     */
    public function updateCustomization(Request $request, Order $order)
    {
        // Ensure user can only update their own orders
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        // Check if order status allows editing (only pending orders can be edited)
        if ($order->order_status !== 'pending') {
            return back()->with('error', 'Order cannot be modified as it has already been processed.');
        }

        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'receiver_name' => 'required|string|max:255',
            'receiver_address' => 'required|string',
            'receiver_phone' => 'required|string|max:20',
            'receiver_note' => 'nullable|string',
            'message' => 'nullable|string',
            'special_request' => 'nullable|string',
            // Product-specific fields
            'ring_size' => 'nullable|string',
            'bracelet_size' => 'nullable|string',
            'necklace_length' => 'nullable|string',
            'apparel_size' => 'nullable|string',
            'frame_size' => 'nullable|string',
            'cup_type' => 'nullable|string',
            'card_type' => 'nullable|string',
            'pillow_size' => 'nullable|string',
            'blanket_size' => 'nullable|string',
            'material' => 'nullable|string',
        ]);

        $orderItem = $order->orderItems()->findOrFail($request->order_item_id);
        
        // Update order item receiver details
        $orderItem->update([
            'receiver_name' => $request->receiver_name,
            'receiver_address' => $request->receiver_address,
            'receiver_phone' => $request->receiver_phone,
            'receiver_note' => $request->receiver_note,
        ]);

        // Update customization if it exists
        if ($orderItem->customization) {
            $orderItem->customization->update([
                'message' => $request->message,
                'special_request' => $request->special_request,
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
                'receiver_name' => $request->receiver_name,
                'receiver_phone' => $request->receiver_phone,
                'receiver_note' => $request->receiver_note,
                'receiver_address' => $request->receiver_address,
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Customization details updated successfully!'
        ]);
    }

    /**
     * Track an order by order number or phone.
     */
    public function trackOrder(Request $request)
    {
        $request->validate([
            'tracking_input' => 'required|string',
        ]);

        $input = $request->tracking_input;

        // Try to find order by order number or phone
        $order = Order::where('order_number', $input)
            ->orWhereHas('orderItems', function ($query) use ($input) {
                $query->where('receiver_phone', $input);
            })
            ->with('orderItems.product')
            ->first();

        if (!$order) {
            return back()->with('error', 'Order not found. Please check your order number or phone number.');
        }

        return view('track.result', compact('order'));
    }
}

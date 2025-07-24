<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CustomizationController;
use App\Http\Controllers\WalletController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\StoreController as AdminStoreController;
use App\Http\Controllers\Admin\SettingsController as AdminSettingsController;
use App\Http\Controllers\Admin\ShippingController as AdminShippingController;
use App\Http\Controllers\Admin\TransactionController as AdminTransactionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProfileController;

// Homepage
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');

// Authentication routes
Auth::routes();

// CAPTCHA refresh route
Route::get('/captcha/refresh', function() {
    return response()->json(['captcha' => captcha_img('easy')]);
})->name('captcha.refresh');

// Product routes
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product:slug}', [ProductController::class, 'show'])->name('products.show');

// Category routes
Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category:slug}', [CategoryController::class, 'show'])->name('categories.show');
Route::get('/categories/{category:slug}/load-more', [CategoryController::class, 'loadMore'])->name('categories.load-more');

// Customization routes (guest access for viewing)
Route::get('/customize', [CustomizationController::class, 'index'])->name('customize.index');
Route::get('/customize/category/{category:slug}', [CustomizationController::class, 'selectCategory'])->name('customize.category');
Route::get('/customize/product/{product:slug}', [CustomizationController::class, 'selectProduct'])->name('customize.product');
Route::get('/customize/product/{product:slug}/customize', [CustomizationController::class, 'customize'])->name('customize.form');
Route::get('/customize/product/{product:slug}/receiver-info', [CustomizationController::class, 'receiverInfo'])->name('customize.receiverInfo');
Route::post('/customize/product/{product:slug}/receiver-info', [CustomizationController::class, 'receiverInfoStore'])->name('customize.receiverInfoStore');

// Order routes (protected)
Route::middleware(['auth'])->group(function () {
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/load-more', [OrderController::class, 'loadMore'])->name('orders.load-more');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::put('/orders/{order}/customization', [OrderController::class, 'updateCustomization'])->name('orders.update-customization');
    
    // Customization routes (require authentication)
    Route::post('/customize', [CustomizationController::class, 'store'])->name('customize.store');
    Route::get('/customize/checkout/{customization}', [CustomizationController::class, 'checkout'])->name('customize.checkout');
    
    // Wallet routes
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/add-funds', [WalletController::class, 'addFunds'])->name('wallet.add-funds');
    Route::post('/wallet/add-funds', [WalletController::class, 'storeFunds'])->name('wallet.store-funds');
    Route::post('/wallet/generate-xtrapay', [WalletController::class, 'generateXtrapay'])->name('wallet.generate-xtrapay');
    Route::get('/wallet/transactions', [WalletController::class, 'transactions'])->name('wallet.transactions');
    Route::get('/wallet/transactions/{id}', [WalletController::class, 'showTransaction'])->name('wallet.transaction-details');
    Route::post('/wallet/process-payment', [WalletController::class, 'processPayment'])->name('wallet.process-payment');
    Route::get('/wallet/balance', [WalletController::class, 'getBalance'])->name('wallet.balance');
    Route::post('/wallet/charge-info', [WalletController::class, 'getChargeInfo'])->name('wallet.charge-info');
    Route::post('/wallet/check-payment-status', [WalletController::class, 'checkPaymentStatus'])->name('wallet.check-payment-status');

    // Profile route (protected)
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::match(['GET', 'DELETE'], '/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

    // Cart payment routes (protected)
    Route::post('/cart/pay-with-wallet', [CartController::class, 'payWithWallet'])->name('cart.pay-with-wallet');
    Route::post('/cart/generate-xtrapay', [CartController::class, 'generateXtrapay'])->name('cart.generate-xtrapay');
    Route::post('/cart/check-payment', [CartController::class, 'checkPayment'])->name('cart.check-payment');

// Debug route for cart testing
Route::get('/cart/debug', function() {
    $cart = session('cart', []);
    return response()->json([
        'cart_count' => count($cart),
        'cart_data' => $cart,
        'user_id' => auth()->id(),
        'session_id' => session()->getId(),
        'is_authenticated' => auth()->check(),
        'session_driver' => config('session.driver'),
        'session_lifetime' => config('session.lifetime')
    ]);
})->name('cart.debug');

// Test route to add sample item to cart
Route::get('/cart/test-add', function() {
    if (!auth()->check()) {
        return response()->json(['error' => 'Not authenticated']);
    }
    
    $cart = session('cart', []);
    $testItem = [
        'quantity' => 1,
        'receiver_name' => 'Test User',
        'receiver_phone' => '1234567890',
        'receiver_address' => 'Test Address',
        'receiver_note' => 'Test Note'
    ];
    
    $cart['test_product_1'] = $testItem;
    session(['cart' => $cart]);
    
    return response()->json([
        'success' => true,
        'message' => 'Test item added to cart',
        'cart_count' => count($cart),
        'cart_data' => $cart
    ]);
})->name('cart.test-add');

// Test route to check address saving
Route::get('/test/save-address', function() {
    if (!auth()->check()) {
        return response()->json(['error' => 'Not authenticated']);
    }
    
    $user = auth()->user();
    $addresses = $user->addresses;
    
    return response()->json([
        'user_id' => $user->id,
        'addresses_count' => $addresses->count(),
        'addresses' => $addresses->map(function($address) {
            return [
                'id' => $address->id,
                'name' => $address->name,
                'phone' => $address->phone,
                'address_line_1' => $address->address_line_1,
                'city' => $address->city,
                'state' => $address->state,
                'created_at' => $address->created_at
            ];
        })
    ]);
})->name('test.save-address');
});

// Track gift route
Route::get('/track', [OrderController::class, 'track'])->name('track');
Route::post('/track', [OrderController::class, 'trackOrder'])->name('track.order');

// Admin routes (protected)
Route::prefix('admin')->middleware(['auth', 'admin'])->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Mobile test page
    Route::get('/mobile-test', function() {
        return view('admin.mobile-test');
    })->name('mobile-test');
    
    // Users management
    Route::resource('users', AdminUserController::class);
    Route::get('users/{user}/wallet-transactions', [AdminUserController::class, 'walletTransactions'])->name('users.wallet-transactions');
    Route::get('users/{user}/orders', [AdminUserController::class, 'orders'])->name('users.orders');
    Route::post('users/{user}/add-wallet-funds', [AdminUserController::class, 'addWalletFunds'])->name('users.add-wallet-funds');
    Route::post('users/{user}/deduct-wallet-funds', [AdminUserController::class, 'deductWalletFunds'])->name('users.deduct-wallet-funds');
    
    // Products management
    Route::resource('products', AdminProductController::class);
    Route::patch('products/{product}/toggle-status', [AdminProductController::class, 'toggleStatus'])->name('products.toggle-status');
    Route::patch('products/{product}/update-stock', [AdminProductController::class, 'updateStock'])->name('products.update-stock');
    Route::post('products/bulk-action', [AdminProductController::class, 'bulkAction'])->name('products.bulk-action');
    Route::delete('products/{product}/gallery', [AdminProductController::class, 'removeGalleryImage'])->name('products.remove-gallery-image');
    
    // Orders management
    Route::resource('orders', AdminOrderController::class)->except(['create', 'store', 'destroy']);
    Route::patch('orders/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::patch('orders/{order}/update-tracking', [AdminOrderController::class, 'updateTracking'])->name('orders.update-tracking');
    Route::patch('orders/{order}/cancel', [AdminOrderController::class, 'cancel'])->name('orders.cancel');
    Route::patch('orders/{order}/mark-delivered', [AdminOrderController::class, 'markDelivered'])->name('orders.mark-delivered');
    Route::get('orders/analytics', [AdminOrderController::class, 'analytics'])->name('orders.analytics');
    Route::get('orders/export', [AdminOrderController::class, 'export'])->name('orders.export');
    Route::post('orders/bulk-update-status', [AdminOrderController::class, 'bulkUpdateStatus'])->name('orders.bulk-update-status');
    
    // Transactions management
    Route::resource('transactions', AdminTransactionController::class)->only(['index', 'show']);
    Route::post('transactions/process-refund/{order}', [AdminTransactionController::class, 'processRefund'])->name('transactions.process-refund');
    Route::post('transactions/bulk-refund', [AdminTransactionController::class, 'bulkRefund'])->name('transactions.bulk-refund');
    Route::get('transactions/analytics', [AdminTransactionController::class, 'analytics'])->name('transactions.analytics');
    Route::get('transactions/export', [AdminTransactionController::class, 'export'])->name('transactions.export');
    
    // Categories management
    Route::resource('categories', AdminCategoryController::class);
    Route::patch('categories/{category}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
    
    // Stores management
    Route::resource('stores', AdminStoreController::class);
    Route::get('stores/{store}/products', [AdminStoreController::class, 'products'])->name('stores.products');
    Route::patch('stores/{store}/toggle-status', [AdminStoreController::class, 'toggleStatus'])->name('stores.toggle-status');
    
    // Settings management
    Route::get('settings', [AdminSettingsController::class, 'index'])->name('settings.index');
    Route::post('settings', [AdminSettingsController::class, 'update'])->name('settings.update');
    Route::get('settings/update-exchange-rate', [AdminSettingsController::class, 'updateExchangeRate'])->name('settings.update-exchange-rate');
    Route::get('settings/test-exchange-rate', [AdminSettingsController::class, 'testExchangeRate'])->name('settings.test-exchange-rate');
    Route::post('settings/test-telegram', [AdminSettingsController::class, 'testTelegram'])->name('settings.test-telegram');
    
    // Shipping management
    Route::get('shipping', [AdminShippingController::class, 'index'])->name('shipping.index');
    Route::get('shipping/pending', [AdminShippingController::class, 'pending'])->name('shipping.pending');
    Route::get('shipping/shipped', [AdminShippingController::class, 'shipped'])->name('shipping.shipped');
    Route::get('shipping/delivered', [AdminShippingController::class, 'delivered'])->name('shipping.delivered');
    Route::patch('shipping/{order}/mark-shipped', [AdminShippingController::class, 'markShipped'])->name('shipping.mark-shipped');
    Route::patch('shipping/{order}/mark-delivered', [AdminShippingController::class, 'markDelivered'])->name('shipping.mark-delivered');
    Route::post('shipping/bulk-update', [AdminShippingController::class, 'bulkUpdate'])->name('shipping.bulk-update');
    Route::get('shipping/analytics', [AdminShippingController::class, 'analytics'])->name('shipping.analytics');
});

// Temporary debug route for transaction authorization
Route::get('/debug/transaction/{id}', function($id) {
    $user = auth()->user();
    $transaction = App\Models\WalletTransaction::find($id);
    
    if (!$user) {
        return response()->json(['error' => 'Not authenticated']);
    }
    
    if (!$transaction) {
        return response()->json(['error' => 'Transaction not found']);
    }
    
    return response()->json([
        'user_id' => $user->id,
        'user_has_wallet' => $user->wallet ? 'yes' : 'no',
        'user_wallet_id' => $user->wallet ? $user->wallet->id : null,
        'transaction_id' => $transaction->id,
        'transaction_wallet_id' => $transaction->wallet_id,
        'authorized' => $user->wallet && $transaction->wallet_id === $user->wallet->id ? 'yes' : 'no'
    ]);
})->middleware('auth');

// Temporary test route to bypass authorization
Route::get('/test/transaction/{id}', function($id) {
    $transaction = App\Models\WalletTransaction::findOrFail($id);
    return view('wallet.transaction-details', compact('transaction'));
})->middleware('auth');

// Temporary test route for order creation
Route::get('/test/order', function() {
    $user = auth()->user();
    if (!$user) {
        return 'Not authenticated';
    }
    
    $product = App\Models\Product::first();
    if (!$product) {
        return 'No product found';
    }
    
    $wallet = $user->wallet;
    if (!$wallet) {
        return 'No wallet found';
    }
    
    $basePrice = $product->final_price_naira;
    $quantity = 1;
    $subtotalNaira = $basePrice * $quantity;
    $taxNaira = $subtotalNaira * (8 / 100);
    $shippingNaira = 5.99 * 1600;
    $totalNaira = $subtotalNaira + $taxNaira + $shippingNaira;
    
    return [
        'user' => $user->name,
        'product' => $product->name,
        'base_price' => $basePrice,
        'total' => $totalNaira,
        'wallet_balance' => $wallet->balance,
        'can_pay' => $wallet->balance >= $totalNaira
    ];
})->middleware('auth');

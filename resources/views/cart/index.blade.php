@extends('layouts.template')

@section('content')

<style>
/* Modal button fixes for light theme */
[data-theme="light"] .modal .btn-primary {
    color: #ffffff !important;
    background: linear-gradient(135deg, #036674 0%, #005a66 100%) !important;
    border: none !important;
}

[data-theme="light"] .modal .btn-success {
    color: #ffffff !important;
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
    border: none !important;
}

[data-theme="light"] .modal .btn-secondary {
    color: #ffffff !important;
    background: #6c757d !important;
    border: none !important;
}

/* Ensure modal text is readable in light theme */
[data-theme="light"] .modal-content {
    background: #ffffff !important;
    color: #333333 !important;
}

[data-theme="light"] .modal-header {
    background: linear-gradient(135deg, #036674 0%, #005a66 100%) !important;
    color: #ffffff !important;
}

[data-theme="light"] .modal-title {
    color: #ffffff !important;
}

/* Remove card borders and add shadows - same as home page */
.adminuiux-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
}

.adminuiux-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Ensure all cards have no borders */
.card {
    border: none !important;
}

/* Cart cards specific styling */
.cart-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.22) 0%,rgb(0, 0, 0) 100%) !important;
}

.cart-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Summary cards specific styling */
.summary-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.22) 0%,rgb(0, 0, 0) 100%) !important;
}

.summary-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Header card styling */
.header-card {
    background: linear-gradient(135deg,rgba(16, 17, 19, 0.44) 0%,rgb(0, 0, 0) 100%) !important;
}

/* Info card styling */
.info-card {
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.22) 0%,rgb(0, 0, 0) 100%) !important;
}

/* Override card-style class */
.card-style {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.22) 0%,rgb(0, 0, 0) 100%) !important;
}

.card-style:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Cart page specific padding and spacing */
.cart-container {
    padding: 1.5rem;
}

.cart-header {
    padding: 1.5rem 1.5rem 1rem 1.5rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.cart-items {
    padding: 1rem 0;
}

.cart-item {
    padding: 1.5rem;
    margin-bottom: 1rem;
    border-radius: 15px;
}

.cart-item-content {
    padding: 0.5rem 0;
}

.cart-summary {
    padding: 1.5rem;
    margin-top: 1.5rem;
    border-radius: 15px;
}

.payment-section {
    padding: 1.5rem 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    margin-top: 1.5rem;
}

.payment-method {
    padding: 1rem 0;
}

.payment-summary {
    padding: 1.5rem;
    margin: 1rem 0;
    border-radius: 15px;
}

.action-buttons {
    padding: 1.5rem 0;
    border-top: 1px solid rgba(255, 255, 255, 0.1);
    margin-top: 1.5rem;
}

/* Responsive padding adjustments */
@media (max-width: 768px) {
    .cart-container {
        padding: 1rem;
    }
    
    .cart-header {
        padding: 1rem;
    }
    
    .cart-item {
        padding: 1rem;
    }
    
    .cart-summary {
        padding: 1rem;
    }
    
    .payment-summary {
        padding: 1rem;
    }
    
    .action-buttons {
        padding: 1rem 0;
    }
}

/* Light theme overrides for cart page */
[data-theme="light"] .cart-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .summary-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .header-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .info-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .card-style {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
}

/* Light theme button overrides */
[data-theme="light"] .btn-theme {
    background-color: #036674 !important;
    border-color: #036674 !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-theme:hover {
    background-color: #025a66 !important;
    border-color: #025a66 !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-outline-theme {
    color: #036674 !important;
    border-color: #036674 !important;
    background-color: transparent !important;
}

[data-theme="light"] .btn-outline-theme:hover {
    color: #ffffff !important;
    background-color: #036674 !important;
    border-color: #036674 !important;
}

[data-theme="light"] .btn-outline-danger {
    color: #dc3545 !important;
    border-color: #dc3545 !important;
    background-color: transparent !important;
}

[data-theme="light"] .btn-outline-danger:hover {
    color: #ffffff !important;
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
}

[data-theme="light"] .btn-outline-secondary {
    color: #6c757d !important;
    border-color: #6c757d !important;
    background-color: transparent !important;
}

[data-theme="light"] .btn-outline-secondary:hover {
    color: #ffffff !important;
    background-color: #6c757d !important;
    border-color: #6c757d !important;
}

[data-theme="light"] .btn-warning {
    background-color: #ffc107 !important;
    border-color: #ffc107 !important;
    color: #000000 !important;
}

[data-theme="light"] .btn-warning:hover {
    background-color: #e0a800 !important;
    border-color: #e0a800 !important;
    color: #000000 !important;
}

[data-theme="light"] .btn-danger {
    background-color: #dc3545 !important;
    border-color: #dc3545 !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-danger:hover {
    background-color: #c82333 !important;
    border-color: #c82333 !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-success {
    background-color: #28a745 !important;
    border-color: #28a745 !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-success:hover {
    background-color: #218838 !important;
    border-color: #218838 !important;
    color: #ffffff !important;
}

/* Light theme text colors */
[data-theme="light"] .font-700,
[data-theme="light"] .font-600,
[data-theme="light"] .font-500,
[data-theme="light"] h1,
[data-theme="light"] h2,
[data-theme="light"] h3,
[data-theme="light"] h4,
[data-theme="light"] h5,
[data-theme="light"] h6 {
    color: #000000 !important;
}

[data-theme="light"] .color-theme {
    color: #036674 !important;
}

[data-theme="light"] .text-secondary {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .text-muted {
    color: rgba(0, 0, 0, 0.5) !important;
}

/* Light theme form elements */
[data-theme="light"] .form-control {
    background-color: #ffffff !important;
    border-color: rgba(0, 0, 0, 0.2) !important;
    color: #000000 !important;
}

[data-theme="light"] .form-control:focus {
    border-color: #036674 !important;
    box-shadow: 0 0 0 0.2rem rgba(3, 102, 116, 0.25) !important;
}

[data-theme="light"] .form-select {
    background-color: #ffffff !important;
    border-color: rgba(0, 0, 0, 0.2) !important;
    color: #000000 !important;
}

[data-theme="light"] .form-select:focus {
    border-color: #036674 !important;
    box-shadow: 0 0 0 0.2rem rgba(3, 102, 116, 0.25) !important;
}

/* Light theme alert styling */
[data-theme="light"] .alert-success {
    background-color: #d4edda !important;
    border-color: #c3e6cb !important;
    color: #155724 !important;
}

[data-theme="light"] .alert-danger {
    background-color: #f8d7da !important;
    border-color: #f5c6cb !important;
    color: #721c24 !important;
}

/* Light theme modal styling */
[data-theme="light"] .modal-content {
    background-color: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .modal-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .modal-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .btn-close {
    filter: invert(1) !important;
}
</style>
<div class="row">
    <div class="col-12">
        <div class="card card-style cart-container">
            <div class="cart-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="font-700 font-22 mb-0">Shopping Cart</h1>
                    @if(count($cartItems) > 0)
                        <form action="{{ route('cart.clear') }}" method="POST" style="display: inline;" 
                              onsubmit="return confirm('Are you sure you want to clear your cart?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash me-1"></i>Clear Cart
                            </button>
                        </form>
                    @endif
                </div>

                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>

            @if(count($cartItems) > 0)
                <div class="cart-items">
                    @foreach($cartItems as $item)
                        <div class="card card-style cart-card cart-item">
                            <div class="cart-item-content">
                                <div class="row align-items-center">
                                    <div class="col-auto">
                                        @if($item['product']->image)
                                            <img src="{{ asset('storage/' . $item['product']->image) }}" 
                                                 alt="{{ $item['product']->name }}" 
                                                 class="rounded" 
                                                 style="width: 80px; height: 80px; object-fit: cover;">
                                        @else
                                            <div class="rounded bg-theme-accent-1 d-flex align-items-center justify-content-center" 
                                                 style="width: 80px; height: 80px;">
                                                <i class="bi bi-gift text-white h4"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="col">
                                        <h5 class="font-600 mb-1">{{ $item['product']->name }}</h5>
                                        <p class="color-theme mb-2">{{ $item['product']->store->name ?? 'Bubblemart' }}</p>
                                        
                                        <!-- Product Scope Badge -->
                                        <div class="mb-2">
                                            @if($item['product']->isUsOnly())
                                                <span class="badge bg-warning text-dark me-2">
                                                    <i class="bi bi-geo-alt-fill me-1"></i>US Only
                                                </span>
                                            @else
                                                <span class="badge bg-success me-2">
                                                    <i class="bi bi-globe me-1"></i>International
                                                </span>
                                            @endif
                                        </div>
                                        
                                        @if($item['customization'])
                                            <div class="mb-2">
                                                <span class="badge bg-theme-accent-1 me-2">{{ ucfirst($item['customization']->type) }} Customization</span>
                                                @if($item['customization']->message)
                                                    <small class="text-secondary">"{{ Str::limit($item['customization']->message, 50) }}"</small>
                                                @endif
                                            </div>
                                            
                                            <!-- Product-specific details -->
                                            @if($item['customization']->ring_size)
                                                <small class="text-secondary">Ring Size: {{ $item['customization']->ring_size }}</small><br>
                                            @endif
                                            @if($item['customization']->apparel_size)
                                                <small class="text-secondary">Size: {{ $item['customization']->apparel_size }}</small><br>
                                            @endif
                                            @if($item['customization']->frame_size)
                                                <small class="text-secondary">Frame Size: {{ ucfirst($item['customization']->frame_size) }}</small><br>
                                            @endif
                                            @if($item['customization']->cup_type)
                                                <small class="text-secondary">Cup Type: {{ ucfirst(str_replace('_', ' ', $item['customization']->cup_type)) }}</small><br>
                                            @endif
                                            @if($item['customization']->card_type)
                                                <small class="text-secondary">Card Type: {{ ucfirst(str_replace('_', ' ', $item['customization']->card_type)) }}</small><br>
                                            @endif
                                            @if($item['customization']->pillow_size)
                                                <small class="text-secondary">Pillow Size: {{ ucfirst(str_replace('_', ' ', $item['customization']->pillow_size)) }}</small><br>
                                            @endif
                                            @if($item['customization']->blanket_size)
                                                <small class="text-secondary">Blanket Size: {{ ucfirst($item['customization']->blanket_size) }}</small><br>
                                            @endif

                                            <!-- Delivery Info -->
                                            <div class="mt-2">
                                                <small class="text-secondary">
                                                    <strong>To:</strong> {{ $item['customization']->receiver_name }} ({{ ucfirst($item['customization']->receiver_gender) }})<br>
                                                    <strong>Phone:</strong> {{ $item['customization']->receiver_phone }}<br>
                                                    <strong>Method:</strong> {{ ucfirst(str_replace('_', ' ', $item['customization']->delivery_method)) }}
                                                </small>
                                            </div>
                                        @else
                                            <!-- Regular Product Variations -->
                                            @if(!empty($item['variations']))
                                                <div class="mb-2">
                                                    <span class="badge bg-info me-2">Product Options</span>
                                                    @foreach($item['variations'] as $variation)
                                                        <small class="text-secondary">{{ $variation['name'] }}: {{ $variation['option'] }}</small><br>
                                                    @endforeach
                                                </div>
                                            @endif

                                            <!-- Receiver Information for Regular Products -->
                                            @if($item['receiver_name'])
                                                <div class="mt-2">
                                                    <small class="text-secondary">
                                                        <strong>To:</strong> {{ $item['receiver_name'] }}<br>
                                                        <strong>Phone:</strong> {{ $item['receiver_phone'] }}<br>
                                                        <strong>Address:</strong> {{ Str::limit($item['receiver_address'], 50) }}
                                                        @if($item['receiver_note'])
                                                            <br><strong>Note:</strong> {{ Str::limit($item['receiver_note'], 30) }}
                                                        @endif
                                                    </small>
                                                </div>
                                            @endif
                                        @endif
                                        
                                        <div class="d-flex align-items-center mt-2">
                                            <span class="font-700 color-theme me-3">
                                                ₦{{ number_format($item['product']->final_price_naira + ($item['customization'] ? $item['customization']->additional_cost : 0)) }}
                                            </span>
                                            <div class="input-group input-group-sm" style="width: 120px;">
                                                <button class="btn btn-outline-secondary" type="button" 
                                                        onclick="updateQuantity({{ $item['product']->id }}, -1, {{ $item['customization'] ? $item['customization']->id : 'null' }})">-</button>
                                                <input type="number" class="form-control text-center" 
                                                       value="{{ $item['quantity'] }}" min="1" 
                                                       onchange="updateQuantity({{ $item['product']->id }}, this.value, {{ $item['customization'] ? $item['customization']->id : 'null' }}, true)">
                                                <button class="btn btn-outline-secondary" type="button" 
                                                        onclick="updateQuantity({{ $item['product']->id }}, 1, {{ $item['customization'] ? $item['customization']->id : 'null' }})">+</button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto text-end">
                                        <h6 class="font-700 color-theme mb-2">₦{{ number_format($item['subtotal']) }}</h6>
                                        <form action="{{ route('cart.remove', $item['product']->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger"
                                                    onclick="return confirm('Remove this item from cart?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="card card-style summary-card cart-summary">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="font-600">Total Items:</h5>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="font-600">{{ array_sum(array_column($cartItems, 'quantity')) }}</h5>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <h4 class="font-700 color-theme">Total Amount:</h4>
                        </div>
                        <div class="col-6 text-end">
                            <h4 class="font-700 color-theme">₦{{ number_format($total) }}</h4>
                        </div>
                    </div>
                    
                    <!-- Shipping Address Selection -->
                    @auth
                        <div class="shipping-section mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h5 class="font-600 mb-0">Shipping Address</h5>
                                <a href="{{ route('profile.index') }}" class="btn btn-outline-theme btn-sm">
                                    <i class="bi bi-gear me-1"></i>Manage Addresses
                                </a>
                            </div>
                            
                            @php
                                $userAddresses = auth()->user()->addresses()->orderBy('is_default', 'desc')->orderBy('created_at', 'desc')->get();
                                $enabledCountries = \App\Models\Setting::getEnabledCountries();
                                $usStates = \App\Models\Setting::getUsStates();
                            @endphp
                            
                            @if($userAddresses->count() > 0)
                                <div class="address-selection">
                                    @foreach($userAddresses as $address)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="radio" name="shipping_address" 
                                                   id="address_{{ $address->id }}" value="{{ $address->id }}" 
                                                   {{ $address->is_default ? 'checked' : '' }}>
                                            <label class="form-check-label" for="address_{{ $address->id }}">
                                                <div class="address-info">
                                                    <div class="d-flex justify-content-between align-items-start">
                                                        <div>
                                                            <strong>{{ $address->name }}</strong>
                                                            @if($address->is_default)
                                                                <span class="badge bg-success ms-2">Default</span>
                                                            @endif
                                                            @if($address->label)
                                                                <span class="badge bg-secondary ms-1">{{ $address->label }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <small class="text-secondary">
                                                        {{ $address->address_line_1 }}<br>
                                                        @if($address->address_line_2){{ $address->address_line_2 }}<br>@endif
                                                        {{ $address->city }}, {{ $address->getStateDisplayNameAttribute() }} {{ $address->postal_code }}<br>
                                                        {{ $address->getCountryDisplayNameAttribute() }}
                                                    </small>
                                                </div>
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>No addresses found:</strong> Please add a shipping address to continue.
                                    <a href="{{ route('profile.index') }}" class="alert-link">Add Address</a>
                                </div>
                            @endif
                        </div>
                    @endauth

                    <!-- Payment Options -->
                    <div class="payment-section">
                        <h5 class="font-600 mb-3">Payment Method</h5>
                        
                        @guest
                            <div class="alert alert-warning">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Login Required:</strong> Please <a href="{{ route('login') }}" class="alert-link">login</a> or <a href="{{ route('register') }}" class="alert-link">register</a> to complete your purchase.
                            </div>
                        @else
                            <!-- Payment Method Selection -->
                            <div class="payment-method">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="payment_method" id="wallet_payment" value="wallet" checked>
                                    <label class="form-check-label" for="wallet_payment">
                                        <i class="bi bi-wallet2 me-2 text-success"></i>
                                        Wallet Payment
                                        @if(auth()->user()->wallet)
                                            <span class="badge bg-success ms-2">₦{{ number_format(auth()->user()->wallet->balance) }} available</span>
                                        @else
                                            <span class="badge bg-warning ms-2">No wallet</span>
                                        @endif
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="payment_method" id="xtrapay_payment" value="xtrapay">
                                    <label class="form-check-label" for="xtrapay_payment">
                                        <i class="bi bi-bank me-2 text-primary"></i>
                                        Xtrapay
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Payment Summary -->
                            <div class="card card-style summary-card payment-summary">
                                <h6 class="font-600 mb-3">Payment Summary</h6>
                                <div class="row">
                                    <div class="col-6">
                                        <span class="text-secondary">Subtotal:</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span>₦{{ number_format($total) }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <span class="text-secondary">Delivery Fee:</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span>₦{{ number_format(500) }}</span>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-6">
                                        <span class="font-600">Total to Pay:</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <span class="font-700 color-theme">₦{{ number_format($total + 500) }}</span>
                                    </div>
                                </div>
                            </div>
                        @endguest
                    </div>
                    
                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <div class="d-grid gap-2">
                            <a href="{{ route('customize.index') }}" class="btn btn-outline-theme">
                                <i class="bi bi-plus-circle me-2"></i>Continue Shopping
                            </a>
                            @auth
                                <button type="button" class="btn btn-theme" onclick="processPayment()">
                                    <i class="bi bi-credit-card me-2"></i>Pay Now
                                </button>
                            @else
                                <a href="{{ route('login') }}" class="btn btn-theme">
                                    <i class="bi bi-person me-2"></i>Login to Pay
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-cart-x" style="font-size: 4rem; color: #6c757d;"></i>
                    <h4 class="font-600 mt-3 mb-2">Your cart is empty</h4>
                    <p class="color-theme mb-4">Looks like you haven't added any items to your cart yet.</p>
                    <a href="{{ route('customize.index') }}" class="btn btn-theme">
                        <i class="bi bi-plus-circle me-2"></i>Start Shopping
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<script>
function updateQuantity(productId, change, customizationId = null, isDirectInput = false) {
    let quantity;
    
    if (isDirectInput) {
        quantity = parseInt(change);
    } else {
        const input = event.target.parentNode.querySelector('input');
        quantity = parseInt(input.value) + parseInt(change);
    }
    
    if (quantity < 1) quantity = 1;
    
    // Create form and submit
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = '{{ route("cart.update", ":product") }}'.replace(':product', productId);
    
    const methodInput = document.createElement('input');
    methodInput.type = 'hidden';
    methodInput.name = '_method';
    methodInput.value = 'PUT';
    
    const quantityInput = document.createElement('input');
    quantityInput.type = 'hidden';
    quantityInput.name = 'quantity';
    quantityInput.value = quantity;
    
    if (customizationId) {
        const customizationInput = document.createElement('input');
        customizationInput.type = 'hidden';
        customizationInput.name = 'customization_id';
        customizationInput.value = customizationId;
        form.appendChild(customizationInput);
    }
    
    const tokenInput = document.createElement('input');
    tokenInput.type = 'hidden';
    tokenInput.name = '_token';
    tokenInput.value = '{{ csrf_token() }}';
    
    form.appendChild(methodInput);
    form.appendChild(quantityInput);
    form.appendChild(tokenInput);
    
    document.body.appendChild(form);
    form.submit();
}

// Payment method selection
document.addEventListener('DOMContentLoaded', function() {
    // No additional logic needed for simplified payment methods
});

// Process payment
function processPayment() {
    console.log('Payment process started');
    const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;
    const shippingAddress = document.querySelector('input[name="shipping_address"]:checked');
    const total = {{ $total + 500 }}; // Total including delivery fee
    
    // Validate shipping address selection
    if (!shippingAddress) {
        showPaymentErrorModal('Shipping Address Required', 'Please select a shipping address to continue.');
        return;
    }
    
    console.log('Payment method:', paymentMethod);
    console.log('Total amount:', total);
    
    if (paymentMethod === 'wallet') {
        // Check wallet balance
        @if(auth()->check() && auth()->user()->wallet)
            const walletBalance = {{ auth()->user()->wallet->balance }};
            console.log('Wallet balance:', walletBalance);
            if (walletBalance < total) {
                showPaymentErrorModal('Insufficient Balance', 'Insufficient wallet balance. Please add funds to your wallet or choose a different payment method.');
                return;
            }
        @else
            showPaymentErrorModal('No Wallet', 'No wallet found. Please add funds to your wallet first.');
            return;
        @endif
        
        // Process wallet payment
        const addressId = shippingAddress.value;
        showWalletConfirmationModal(total, addressId);
    } else if (paymentMethod === 'xtrapay') {
        // Process Xtrapay payment
        const addressId = shippingAddress.value;
        processXtrapayPayment(total, addressId);
    } else {
        showPaymentErrorModal('Payment Method Required', 'Please select a payment method.');
        return;
    }
}

// Filter addresses based on product scope
function filterAddressesByProductScope() {
    @php
        $hasUsOnlyProducts = false;
        $hasInternationalProducts = false;
        foreach($cartItems as $item) {
            if ($item['product']->isUsOnly()) {
                $hasUsOnlyProducts = true;
            }
            if ($item['product']->isInternational()) {
                $hasInternationalProducts = true;
            }
        }
    @endphp
    
    @if($hasUsOnlyProducts)
        // Hide non-US addresses for US-only products
        const addressRadios = document.querySelectorAll('input[name="shipping_address"]');
        let visibleAddresses = 0;
        
        addressRadios.forEach(radio => {
            const addressCard = radio.closest('.form-check');
            const addressInfo = addressCard.querySelector('.address-info');
            const countryText = addressInfo.textContent.toLowerCase();
            
            // Check if this is a US address
            const isUsAddress = countryText.includes('united states') || 
                               countryText.includes('usa') || 
                               countryText.includes('us') ||
                               countryText.includes('united states of america');
            
            if (!isUsAddress) {
                addressCard.style.display = 'none';
                radio.disabled = true;
                radio.checked = false;
            } else {
                visibleAddresses++;
            }
        });
        
        // Show warning message if we have US-only products
        const addressSection = document.querySelector('.shipping-section');
        let warningDiv = addressSection.querySelector('.us-only-warning');
        
        if (!warningDiv) {
            warningDiv = document.createElement('div');
            warningDiv.className = 'alert alert-warning mt-2 us-only-warning';
            warningDiv.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i><strong>US-Only Products:</strong> Some products in your cart are US-only. Only US addresses are available for selection.';
            addressSection.appendChild(warningDiv);
        }
        
        // If no US addresses are available, show error
        if (visibleAddresses === 0) {
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger mt-2';
            errorDiv.innerHTML = '<i class="bi bi-x-circle me-2"></i><strong>No US Address Available:</strong> You need to add a US address to your profile to purchase US-only products. <a href="{{ route("profile.index") }}" class="alert-link">Add US Address</a>';
            addressSection.appendChild(errorDiv);
        }
    @endif
}

// Call address filtering on page load
document.addEventListener('DOMContentLoaded', function() {
    filterAddressesByProductScope();
});

// Process wallet payment
function processWalletPayment(amount, addressId = null) {
    console.log('Processing wallet payment for amount:', amount, 'address:', addressId);
    
    // Show loading
    const payButton = document.querySelector('button[onclick="processPayment()"]');
    const originalText = payButton.innerHTML;
    payButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Processing...';
    payButton.disabled = true;
    
    fetch('{{ route("cart.pay-with-wallet") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            amount: amount,
            address_id: addressId
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Show success modal
            showPaymentSuccessModal(data);
        } else {
            showPaymentErrorModal('Payment Error', data.message || 'Payment failed. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showPaymentErrorModal('Payment Failed', 'Payment failed. Please try again or contact support for assistance.');
    })
    .finally(() => {
        payButton.innerHTML = originalText;
        payButton.disabled = false;
    });
}

// Process XtraPay payment
function processXtrapayPayment(amount, addressId) {
    console.log('Processing Xtrapay payment for amount:', amount, 'address:', addressId);
    
    // Show loading
    const payButton = document.querySelector('button[onclick="processPayment()"]');
    const originalText = payButton.innerHTML;
    payButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Processing...';
    payButton.disabled = true;
    
    fetch('{{ route("cart.generate-xtrapay") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            amount: amount,
            address_id: addressId
        })
    })
    .then(response => {
        console.log('Response status:', response.status);
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        console.log('Response data:', data);
        if (data.success) {
            // Show payment details modal
            showXtrapayModal(data);
        } else {
            showPaymentErrorModal('Payment Error', data.message || 'Failed to generate payment details');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showPaymentErrorModal('Service Error', 'Payment service is currently in demo mode. Please try again or contact support for assistance.');
    })
    .finally(() => {
        payButton.innerHTML = originalText;
        payButton.disabled = false;
    });
}



// Show XtraPay payment modal
function showXtrapayModal(data) {
    const demoAlert = data.demo_mode ? `
        <div class="alert alert-warning" style="background: rgba(252, 164, 136, 0.1) !important; border: 1px solid rgba(252, 164, 136, 0.3) !important; color: var(--text-primary) !important;">
            <h6 class="text-theme-1"><i class="bi bi-exclamation-triangle me-2"></i>Demo Mode</h6>
            <p class="mb-0 text-theme-1">${data.message || 'This is a test payment. In production, you would transfer to the actual bank account.'}</p>
            <small class="text-muted">Note: This is a demonstration. No actual payment will be processed.</small>
        </div>
    ` : '';
    
    const modal = `
        <div class="modal fade" id="xtrapayModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" style="background: rgba(0, 0, 0, 0.9) !important; border: none; border-radius: 15px;">
                    <div class="modal-header" style="background: rgba(0, 0, 0, 0.95) !important; border-bottom: 1px solid rgba(255,255,255,0.1) !important; border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title text-theme-1">
                            <i class="bi bi-credit-card me-2"></i>Complete Your Payment
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body text-theme-1">
                        ${demoAlert}
                        <div class="alert alert-info" style="background: rgba(0, 73, 83, 0.1) !important; border: 1px solid rgba(0, 73, 83, 0.3) !important; color: var(--text-primary) !important;">
                            <h6 class="text-theme-1"><i class="bi bi-info-circle me-2"></i>Payment Instructions</h6>
                            <p class="mb-2 text-theme-1">Please transfer the exact amount to the account details below:</p>
                        </div>
                        
                        <div class="card card-style mb-3" style="background: rgba(0, 73, 83, 0.1) !important; border: 1px solid rgba(0, 73, 83, 0.3) !important; border-radius: 10px;">
                            <div class="content p-3">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <strong class="text-theme-1">Bank:</strong><br>
                                        <span class="text-theme-1 fw-bold">${data.bank}</span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong class="text-theme-1">Account Number:</strong><br>
                                        <span class="text-theme-1 fw-bold">${data.accountNumber}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <strong class="text-theme-1">Account Name:</strong><br>
                                        <span class="text-theme-1 fw-bold">${data.accountName}</span>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <strong class="text-theme-1">Amount:</strong><br>
                                        <span class="text-success font-600 fw-bold">₦${parseInt(data.amount).toLocaleString()}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <strong class="text-theme-1">Reference:</strong><br>
                                        <span class="text-muted fw-bold">${data.reference}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="alert alert-warning" style="background: rgba(252, 164, 136, 0.1) !important; border: 1px solid rgba(252, 164, 136, 0.3) !important; color: var(--text-primary) !important;">
                            <small>
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <strong>Important:</strong> Transfer the exact amount and use the reference number provided. 
                                Your order will be processed automatically once payment is confirmed.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1) !important; border-radius: 0 0 15px 15px;">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal" style="border-radius: 10px;">
                            <i class="bi bi-x me-2"></i>Close
                        </button>
                        <button type="button" class="btn btn-theme" onclick="checkPaymentStatus('${data.reference}')" style="border-radius: 10px; background: linear-gradient(135deg, var(--main-color) 0%, #005a66 100%) !important; border: none !important;">
                            <i class="bi bi-check-circle me-2"></i>I've Made the Transfer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('xtrapayModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to page
    document.body.insertAdjacentHTML('beforeend', modal);
    
    // Show modal
    const modalElement = document.getElementById('xtrapayModal');
    const bootstrapModal = new bootstrap.Modal(modalElement);
    bootstrapModal.show();
}

// Check payment status
function checkPaymentStatus(reference) {
    const checkButton = document.querySelector('button[onclick="checkPaymentStatus(\'' + reference + '\')"]');
    const originalText = checkButton.innerHTML;
    checkButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Checking...';
    checkButton.disabled = true;
    
    console.log('Checking payment status for reference:', reference);
    
    fetch('{{ route("cart.check-payment") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            reference: reference
        })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        console.log('Payment check response:', data);
        
        if (data.success) {
            // Payment confirmed successfully
            showPaymentSuccessModal({
                message: data.message || 'Payment confirmed! Your order has been placed successfully.',
                order_id: data.order_id,
                order_number: data.order_number,
                redirect: '{{ route("orders.index") }}'
            });
            
            // Close the payment modal if it's open
            const paymentModal = document.getElementById('xtrapayModal');
            if (paymentModal) {
                const bootstrapModal = bootstrap.Modal.getInstance(paymentModal);
                if (bootstrapModal) {
                    bootstrapModal.hide();
                }
            }
        } else {
            // Payment not yet confirmed
            const status = data.status || 'pending';
            const message = data.message || 'Payment not yet confirmed. Please wait a few minutes and try again.';
            
            if (status === 'pending') {
                showPaymentPendingModal(reference, message);
            } else {
                showPaymentErrorModal('Payment Not Confirmed', message);
            }
        }
    })
    .catch(error => {
        console.error('Payment check error:', error);
        showPaymentErrorModal('Status Check Error', 'Error checking payment status. Please try again or contact support if you have already made the transfer.');
    })
    .finally(() => {
        checkButton.innerHTML = originalText;
        checkButton.disabled = false;
    });
}

// Show payment pending modal (for payments that are still being processed)
function showPaymentPendingModal(reference, message) {
    const modal = `
        <div class="modal fade" id="paymentPendingModal" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
                    <div class="modal-header" style="background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%) !important; border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title text-dark">
                            <i class="bi bi-clock me-2"></i>Payment Processing
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="background: #ffffff; padding: 2rem;">
                        <div class="text-center mb-4">
                            <div class="pending-icon-container mb-3">
                                <i class="bi bi-clock" style="font-size: 4rem; color: #ffc107;"></i>
                            </div>
                            <h6 class="mb-3" style="color: #333333;">Payment is Being Processed</h6>
                            <p class="mb-0" style="color: #333333;">${message}</p>
                        </div>
                        
                        <div class="alert alert-info" style="background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460;">
                            <small>
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>What happens next?</strong> We'll automatically check your payment status. You can also manually check again in a few minutes.
                            </small>
                        </div>
                        
                        <div class="text-center mt-3">
                            <small class="text-muted">
                                <i class="bi bi-arrow-clockwise me-1"></i>
                                Reference: <strong style="color: #036674;">${reference}</strong>
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer" style="background: #f8f9fa; border-radius: 0 0 15px 15px; border-top: 1px solid #dee2e6;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: #6c757d; border: none; border-radius: 8px;">
                            <i class="bi bi-x me-2"></i>Close
                        </button>
                        <button type="button" class="btn btn-warning" onclick="checkPaymentStatus('${reference}')" style="background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%); border: none; border-radius: 8px; color: #000000;">
                            <i class="bi bi-arrow-clockwise me-2"></i>Check Again
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('paymentPendingModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to page
    document.body.insertAdjacentHTML('beforeend', modal);
    
    // Show modal
    const modalElement = document.getElementById('paymentPendingModal');
    const bootstrapModal = new bootstrap.Modal(modalElement);
    bootstrapModal.show();
}

// Show payment error modal
function showPaymentErrorModal(title, message) {
    const modal = `
        <div class="modal fade" id="paymentErrorModal" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
                    <div class="modal-header bg-danger text-white" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important; border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title">
                            <i class="bi bi-exclamation-triangle me-2"></i>${title}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="background: #ffffff; padding: 2rem;">
                        <div class="text-center mb-3">
                            <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem; color: #dc3545;"></i>
                        </div>
                        <p class="text-center mb-0" style="color: #333333;">${message}</p>
                    </div>
                    <div class="modal-footer" style="background: #f8f9fa; border-radius: 0 0 15px 15px; border-top: 1px solid #dee2e6;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: #6c757d; border: none; border-radius: 8px;">
                            <i class="bi bi-x me-2"></i>Close
                        </button>
                        <button type="button" class="btn btn-warning" onclick="contactSupport()" style="background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%); border: none; border-radius: 8px; color: #000000;">
                            <i class="bi bi-headset me-2"></i>Contact Support
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('paymentErrorModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to page
    document.body.insertAdjacentHTML('beforeend', modal);
    
    // Show modal
    const modalElement = document.getElementById('paymentErrorModal');
    const bootstrapModal = new bootstrap.Modal(modalElement);
    bootstrapModal.show();
}

// Show wallet confirmation modal
function showWalletConfirmationModal(amount, addressId = null) {
    const currentBalance = {{ auth()->user()->wallet->balance ?? 0 }};
    const balanceAfterPayment = currentBalance - amount;
    
    const modal = `
        <div class="modal fade" id="walletConfirmationModal" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
                    <div class="modal-header" style="background: linear-gradient(135deg, #036674 0%, #005a66 100%) !important; border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title text-white">
                            <i class="bi bi-wallet2 me-2"></i>Confirm Wallet Payment
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="background: #ffffff; padding: 2rem;">
                        <div class="text-center mb-4">
                            <div class="wallet-icon-container mb-3">
                                <i class="bi bi-wallet2" style="font-size: 4rem; color: #036674;"></i>
                            </div>
                            <h6 class="mb-3" style="color: #333333;">Wallet Payment Confirmation</h6>
                            <p class="mb-0" style="color: #333333;">Are you sure you want to pay <strong style="color: #036674;">₦${amount.toLocaleString()}</strong> from your wallet?</p>
                        </div>
                        
                        <div class="payment-summary-card" style="background: #f8f9fa; border: 1px solid #dee2e6; border-radius: 10px; padding: 15px; margin: 15px 0;">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="summary-item">
                                        <small class="text-muted d-block">Payment Amount</small>
                                        <strong style="color: #036674;">₦${amount.toLocaleString()}</strong>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="summary-item">
                                        <small class="text-muted d-block">Current Balance</small>
                                        <strong style="color: #036674;">₦${currentBalance.toLocaleString()}</strong>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center mt-3">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Balance after payment: <strong style="color: #036674;">₦${balanceAfterPayment.toLocaleString()}</strong>
                                </small>
                            </div>
                        </div>
                        
                        <div class="alert alert-info" style="background: #d1ecf1; border: 1px solid #bee5eb; color: #0c5460;">
                            <small>
                                <i class="bi bi-shield-check me-2"></i>
                                <strong>Secure Payment:</strong> Your payment will be processed securely through your Bubblemart wallet.
                            </small>
                        </div>
                    </div>
                    <div class="modal-footer" style="background: #f8f9fa; border-radius: 0 0 15px 15px; border-top: 1px solid #dee2e6;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: #6c757d; border: none; border-radius: 8px;">
                            <i class="bi bi-x me-2"></i>Cancel
                        </button>
                        <button type="button" class="btn btn-primary" onclick="confirmWalletPayment(${amount})" style="background: linear-gradient(135deg, #036674 0%, #005a66 100%); border: none; border-radius: 8px; color: #ffffff !important; font-weight: 600;">
                            <i class="bi bi-check-circle me-2"></i>Confirm Payment
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('walletConfirmationModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to page
    document.body.insertAdjacentHTML('beforeend', modal);
    
    // Show modal
    const modalElement = document.getElementById('walletConfirmationModal');
    const bootstrapModal = new bootstrap.Modal(modalElement);
    bootstrapModal.show();
}

// Confirm wallet payment
function confirmWalletPayment(amount) {
    // Close the confirmation modal
    const modalElement = document.getElementById('walletConfirmationModal');
    const bootstrapModal = bootstrap.Modal.getInstance(modalElement);
    bootstrapModal.hide();
    
    // Get selected address
    const shippingAddress = document.querySelector('input[name="shipping_address"]:checked');
    const addressId = shippingAddress ? shippingAddress.value : null;
    
    console.log('Processing wallet payment for amount:', amount, 'address:', addressId);
    processWalletPayment(amount, addressId);
}

// Show payment success modal
function showPaymentSuccessModal(data) {
    const modal = `
        <div class="modal fade" id="paymentSuccessModal" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
                    <div class="modal-header" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important; border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title text-white">
                            <i class="bi bi-check-circle me-2"></i>Payment Successful!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="background: #ffffff; padding: 2rem;">
                        <div class="text-center mb-4">
                            <div class="success-icon-container mb-3">
                                <i class="bi bi-check-circle" style="font-size: 4rem; color: #28a745;"></i>
                            </div>
                            <h6 class="mb-3" style="color: #333333;">Payment Completed Successfully!</h6>
                            <p class="mb-0" style="color: #333333;">${data.message || 'Your payment has been processed successfully!'}</p>
                            ${data.order_id ? `<p class="text-center text-muted mt-2">Order ID: <strong style="color: #036674;">${data.order_id}</strong></p>` : ''}
                        </div>
                        
                        <div class="success-summary-card" style="background: #d4edda; border: 1px solid #c3e6cb; border-radius: 10px; padding: 15px; margin: 15px 0;">
                            <div class="text-center">
                                <small style="color: #155724;">
                                    <i class="bi bi-box me-2"></i>
                                    <strong>Your order has been placed and is being processed.</strong>
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="background: #f8f9fa; border-radius: 0 0 15px 15px; border-top: 1px solid #dee2e6;">
                        <button type="button" class="btn btn-success" onclick="redirectToOrders()" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 8px; color: white;">
                            <i class="bi bi-box me-2"></i>View Orders
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('paymentSuccessModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to page
    document.body.insertAdjacentHTML('beforeend', modal);
    
    // Show modal
    const modalElement = document.getElementById('paymentSuccessModal');
    const bootstrapModal = new bootstrap.Modal(modalElement);
    bootstrapModal.show();
}

// Contact support function
function contactSupport() {
    // You can customize this to open a support chat, email, or phone
    window.open('mailto:support@bubblemart.com?subject=Payment Issue&body=I am experiencing a payment issue and need assistance.', '_blank');
}

// Redirect to orders page
function redirectToOrders() {
    window.location.href = '{{ route("orders.index") }}';
}
</script>
@endsection 
@extends('layouts.template')

@section('content')

<style>
/* Light theme form label styling */
[data-theme="light"] .form-label {
    color: #000000 !important;
}

[data-theme="light"] .form-label.fw-medium {
    color: #000000 !important;
}

[data-theme="light"] .form-check-label {
    color: #000000 !important;
}

[data-theme="light"] .form-control {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #000000 !important;
}

[data-theme="light"] .form-control:focus {
    border-color: #036674 !important;
    box-shadow: 0 0 0 0.2rem rgba(3, 102, 116, 0.25) !important;
}

[data-theme="light"] .form-select {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #000000 !important;
}

[data-theme="light"] .form-select:focus {
    border-color: #036674 !important;
    box-shadow: 0 0 0 0.2rem rgba(3, 102, 116, 0.25) !important;
}

[data-theme="light"] .form-textarea {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #000000 !important;
}

[data-theme="light"] .form-textarea:focus {
    border-color: #036674 !important;
    box-shadow: 0 0 0 0.2rem rgba(3, 102, 116, 0.25) !important;
}

[data-theme="light"] .text-secondary {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .text-theme-1 {
    color: #036674 !important;
}

[data-theme="light"] .welcome-label {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .welcome-username {
    color: #000000 !important;
}



/* Light theme overrides for buttons */
[data-theme="light"] .btn-theme {
    background-color: #036674 !important;
    border-color: #036674 !important;
    color:rgb(221, 227, 225) !important;
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

[data-theme="light"] .btn-theme-accent-1 {
    background-color: #ff9800 !important;
    border-color: #ff9800 !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-theme-accent-1:hover {
    background-color: #f57c00 !important;
    border-color: #f57c00 !important;
    color: #ffffff !important;
}

/* Additional button styles for light theme */
[data-theme="light"] .btn-outline-warning {
    color: #856404 !important;
    border-color: #ffc107 !important;
    background-color: transparent !important;
}

[data-theme="light"] .btn-outline-warning:hover {
    color: #000000 !important;
    background-color: #ffc107 !important;
    border-color: #ffc107 !important;
}

[data-theme="light"] .btn-outline-primary {
    color: #036674 !important;
    border-color: #036674 !important;
    background-color: transparent !important;
}

[data-theme="light"] .btn-outline-primary:hover {
    color: #ffffff !important;
    background-color: #036674 !important;
    border-color: #036674 !important;
}

[data-theme="light"] .btn-sm {
    font-size: 0.875rem !important;
    padding: 0.25rem 0.5rem !important;
}

/* Admin section styling */
.admin-actions-section {
    background: rgba(255, 255, 255, 0.05);
    border-radius: 15px;
    padding: 1rem;
    margin-top: 1rem;
}

[data-theme="light"] .admin-actions-section {
    background: rgba(0, 0, 0, 0.02);
    border: 1px solid rgba(0, 0, 0, 0.05);
}
</style>

<!-- Welcome/User -->
<div class="d-flex align-items-center mb-3">
    <figure class="avatar avatar-30 rounded coverimg align-middle me-2">
        @auth
            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('template-assets/img/avatars/1.jpg') }}" alt="Profile" style="width: 30px; height: 30px; object-fit: cover;">
        @else
            <i class="bi bi-person-circle h2"></i>
        @endauth
    </figure>
    <div>
        <p class="small welcome-label text-truncated mb-0">Welcome,</p>
        <h6 class="fw-bold welcome-username mb-0">
            @auth
                {{ Auth::user()->name }}
            @else
                Guest
            @endauth
        </h6>
    </div>
</div>

<!-- Product Details -->
<div class="row gx-3 mb-3">
    <!-- Product Image Slider -->
    <div class="col-md-6 mb-3">
        <div class="card adminuiux-card" style="border-radius: 20px;">
            <div class="card-body p-4">
                @if($product->image || ($product->gallery && count($product->gallery) > 0))
                    <div id="productImageCarousel" class="carousel slide" data-bs-ride="carousel">
                        <!-- Indicators -->
                        @if(($product->gallery && count($product->gallery) > 0) || $product->image)
                            <div class="carousel-indicators">
                                @if($product->image)
                                    <button type="button" data-bs-target="#productImageCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Main Image"></button>
                                @endif
                                @if($product->gallery)
                                    @foreach($product->gallery as $index => $galleryImage)
                                        <button type="button" data-bs-target="#productImageCarousel" data-bs-slide-to="{{ $product->image ? $index + 1 : $index }}" aria-label="Gallery Image {{ $index + 1 }}"></button>
                                    @endforeach
                                @endif
                            </div>
                        @endif
                        
                        <!-- Slides -->
                        <div class="carousel-inner">
                            @if($product->image)
                                <div class="carousel-item active">
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-100 rounded" style="border-radius: 15px; max-height: 400px; object-fit: cover;">
                                </div>
                            @endif
                            
                            @if($product->gallery)
                                @foreach($product->gallery as $index => $galleryImage)
                                    <div class="carousel-item {{ !$product->image && $index === 0 ? 'active' : '' }}">
                                        <img src="{{ asset('storage/' . $galleryImage) }}" alt="{{ $product->name }} - Image {{ $index + 1 }}" class="w-100 rounded" style="border-radius: 15px; max-height: 400px; object-fit: cover;">
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        
                        <!-- Controls -->
                        @if(($product->gallery && count($product->gallery) > 0) || ($product->image && $product->gallery && count($product->gallery) > 0))
                            <button class="carousel-control-prev" type="button" data-bs-target="#productImageCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#productImageCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        @endif
                    </div>
                    
                    <!-- Thumbnail Navigation -->
                    @if($product->gallery && count($product->gallery) > 0)
                        <div class="mt-3">
                            <div class="d-flex gap-2 overflow-auto">
                                @if($product->image)
                                    <div class="thumbnail-item" onclick="goToSlide(0)" style="cursor: pointer; min-width: 60px; height: 60px; border: 2px solid #036674; border-radius: 8px; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="Main" class="w-100 h-100" style="object-fit: cover;">
                                    </div>
                                @endif
                                @foreach($product->gallery as $index => $galleryImage)
                                    <div class="thumbnail-item" onclick="goToSlide({{ $product->image ? $index + 1 : $index }})" style="cursor: pointer; min-width: 60px; height: 60px; border: 2px solid transparent; border-radius: 8px; overflow: hidden;">
                                        <img src="{{ asset('storage/' . $galleryImage) }}" alt="Gallery {{ $index + 1 }}" class="w-100 h-100" style="object-fit: cover;">
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                @else
                    <div class="text-center">
                        <div class="avatar avatar-200 rounded bg-theme-1 mx-auto d-flex align-items-center justify-content-center">
                            <i class="bi bi-gift h1 text-white"></i>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Product Information -->
    <div class="col-md-6 mb-3">
        <div class="card adminuiux-card" style="border-radius: 20px;">
            <div class="card-body p-4">
                <div class="d-flex align-items-start justify-content-between mb-2">
                    <div class="flex-grow-1">
                        <h4 class="fw-bold mb-0 text-theme-1">{{ $product->name }}</h4>
                        @auth
                            @if(Auth::user()->is_admin)
                                <div class="mt-1">
                                    <span class="badge {{ $product->is_active ? 'bg-success' : 'bg-danger' }} me-2">
                                        <i class="bi {{ $product->is_active ? 'bi-check-circle' : 'bi-x-circle' }} me-1"></i>
                                        {{ $product->is_active ? 'Active' : 'Inactive' }}
                                    </span>
                                    <span class="badge {{ $product->is_featured ? 'bg-warning' : 'bg-secondary' }}">
                                        <i class="bi {{ $product->is_featured ? 'bi-star-fill' : 'bi-star' }} me-1"></i>
                                        {{ $product->is_featured ? 'Featured' : 'Regular' }}
                                    </span>
                                </div>
                            @endif
                        @endauth
                    </div>
                    @auth
                        @if(Auth::user()->is_admin)
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-sm btn-outline-primary ms-2" style="border-radius: 10px;">
                                <i class="bi bi-pencil me-1"></i>Edit
                            </a>
                        @endif
                    @endauth
                </div>
                <p class="text-secondary mb-3">{{ $product->description }}</p>
                
                <!-- Price -->
                <div class="mb-3">
                    <span class="h3 fw-bold text-theme-1">₦{{ number_format($product->price_naira) }}</span>
                    @if($product->sale_price)
                        <span class="text-secondary text-decoration-line-through ms-2">{{ $product->formatted_price_naira }} ({{ $product->formatted_price_usd }})</span>
                    @endif
                </div>
                
                <!-- Product Meta -->
                <div class="row gx-3 mb-4">
                    <div class="col-6">
                        <div class="card adminuiux-card border-0" style="border-radius: 15px;">
                            <div class="card-body text-center p-3">
                                <i class="bi bi-tags text-theme-1 mb-2"></i>
                                <div class="small text-secondary">{{ $product->category->name }} {{ $product->category->icon }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="card adminuiux-card border-0" style="border-radius: 15px;">
                            <div class="card-body text-center p-3">
                                <i class="bi bi-shop text-theme-1 mb-2"></i>
                                <div class="small text-secondary">{{ $product->store->name }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Product Variations -->
                @if($product->hasVariations())
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-gear me-2 text-theme-1"></i>
                            Product Options
                        </h6>
                        
                        @foreach($product->activeVariations as $variation)
                            <div class="mb-3">
                                <label class="form-label fw-medium">{{ $variation->name }}</label>
                                <div class="card adminuiux-card border-0" style="border-radius: 15px;">
                                    <div class="card-body">
                                        @if($variation->type === 'select')
                                            <select class="form-select" name="variations[{{ $variation->name }}]" required style="border-radius: 10px;">
                                                <option value="">Select {{ $variation->name }}</option>
                                                @foreach($variation->activeOptions as $option)
                                                    <option value="{{ $option->id }}" data-price-adjustment="{{ $option->price_adjustment }}">
                                                        {{ $option->display_label }}
                                                        @if($option->price_adjustment > 0)
                                                            (+₦{{ number_format($option->price_adjustment) }})
                                                        @endif
                                                    </option>
                                                @endforeach
                                            </select>
                                        @elseif($variation->type === 'radio')
                                            @foreach($variation->activeOptions as $option)
                                                <div class="form-check mb-2">
                                                    <input class="form-check-input" type="radio" name="variations[{{ $variation->name }}]" 
                                                           id="{{ $variation->name }}_{{ $option->id }}" value="{{ $option->id }}" 
                                                           data-price-adjustment="{{ $option->price_adjustment }}" required>
                                                    <label class="form-check-label" for="{{ $variation->name }}_{{ $option->id }}">
                                                        {{ $option->display_label }}
                                                        @if($option->price_adjustment > 0)
                                                            <span class="text-theme-1">(+₦{{ number_format($option->price_adjustment) }})</span>
                                                        @endif
                                                    </label>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
                
                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" id="addToCartForm">
                    @csrf
                    <input type="hidden" id="final_price" name="final_price" value="{{ $product->price_naira }}">
                    
                    <div class="row gx-3 mb-3">
                        <div class="col-6">
                            <label for="quantity" class="form-label fw-medium">Quantity</label>
                            <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1" max="10" style="border-radius: 10px;">
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-medium">Total Price</label>
                            <div class="h4 fw-bold text-theme-1 mb-0" id="totalPriceDisplay">₦{{ number_format($product->price_naira) }}</div>
                        </div>
                    </div>
                    

                    
                    <!-- Receiver Information -->
                    <div class="mb-4">
                        <h6 class="fw-bold mb-3">
                            <i class="bi bi-person me-2 text-theme-1"></i>
                            Receiver Information
                        </h6>
                        
                        <!-- Saved Addresses -->
                        @auth
                            @if(auth()->user()->addresses->count() > 0)
                                <div class="mb-3">
                                    <label class="form-label fw-medium">Use Saved Address</label>
                                    <select class="form-select" id="savedAddressSelect" style="border-radius: 10px;">
                                        <option value="">Select a saved address</option>
                                        @foreach(auth()->user()->addresses as $address)
                                            <option value="{{ $address->id }}" 
                                                    data-name="{{ $address->name }}"
                                                    data-phone="{{ $address->phone }}"
                                                    data-address="{{ $address->address_line_1 }}"
                                                    data-city="{{ $address->city }}"
                                                    data-state="{{ $address->state }}"
                                                    data-zip="{{ $address->postal_code }}">
                                                {{ $address->name }} - {{ $address->address_line_1 }}, {{ $address->city }}, {{ $address->state }} {{ $address->postal_code }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        @endauth
                        
                        <!-- New Address Form -->
                        <div class="card adminuiux-card border-0" style="border-radius: 15px;">
                            <div class="card-body">
                                <div class="row gx-3 mb-3">
                                    <div class="col-6">
                                        <label for="receiver_name" class="form-label fw-medium">Receiver Name *</label>
                                        <input type="text" class="form-control" id="receiver_name" name="receiver_name" required style="border-radius: 10px;">
                                    </div>
                                    <div class="col-6">
                                        <label for="receiver_phone" class="form-label fw-medium">Receiver Phone *</label>
                                        <input type="text" class="form-control" id="receiver_phone" name="receiver_phone" required style="border-radius: 10px;">
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="receiver_address" class="form-label fw-medium">Street Address *</label>
                                    <textarea class="form-control" id="receiver_address" name="receiver_address" rows="2" required style="border-radius: 10px;" placeholder="Street address, apartment, suite, etc."></textarea>
                                </div>
                                
                                <div class="row gx-3 mb-3">
                                    <div class="col-6">
                                        <label for="receiver_city" class="form-label fw-medium">City *</label>
                                        <input type="text" class="form-control" id="receiver_city" name="receiver_city" required style="border-radius: 10px;" placeholder="City">
                                    </div>
                                    <div class="col-6">
                                        <label for="receiver_state" class="form-label fw-medium">State *</label>
                                        <select class="form-select" id="receiver_state" name="receiver_state" required style="border-radius: 10px;">
                                            <option value="">Select State</option>
                                            <option value="AL">Alabama</option>
                                            <option value="AK">Alaska</option>
                                            <option value="AZ">Arizona</option>
                                            <option value="AR">Arkansas</option>
                                            <option value="CA">California</option>
                                            <option value="CO">Colorado</option>
                                            <option value="CT">Connecticut</option>
                                            <option value="DE">Delaware</option>
                                            <option value="FL">Florida</option>
                                            <option value="GA">Georgia</option>
                                            <option value="HI">Hawaii</option>
                                            <option value="ID">Idaho</option>
                                            <option value="IL">Illinois</option>
                                            <option value="IN">Indiana</option>
                                            <option value="IA">Iowa</option>
                                            <option value="KS">Kansas</option>
                                            <option value="KY">Kentucky</option>
                                            <option value="LA">Louisiana</option>
                                            <option value="ME">Maine</option>
                                            <option value="MD">Maryland</option>
                                            <option value="MA">Massachusetts</option>
                                            <option value="MI">Michigan</option>
                                            <option value="MN">Minnesota</option>
                                            <option value="MS">Mississippi</option>
                                            <option value="MO">Missouri</option>
                                            <option value="MT">Montana</option>
                                            <option value="NE">Nebraska</option>
                                            <option value="NV">Nevada</option>
                                            <option value="NH">New Hampshire</option>
                                            <option value="NJ">New Jersey</option>
                                            <option value="NM">New Mexico</option>
                                            <option value="NY">New York</option>
                                            <option value="NC">North Carolina</option>
                                            <option value="ND">North Dakota</option>
                                            <option value="OH">Ohio</option>
                                            <option value="OK">Oklahoma</option>
                                            <option value="OR">Oregon</option>
                                            <option value="PA">Pennsylvania</option>
                                            <option value="RI">Rhode Island</option>
                                            <option value="SC">South Carolina</option>
                                            <option value="SD">South Dakota</option>
                                            <option value="TN">Tennessee</option>
                                            <option value="TX">Texas</option>
                                            <option value="UT">Utah</option>
                                            <option value="VT">Vermont</option>
                                            <option value="VA">Virginia</option>
                                            <option value="WA">Washington</option>
                                            <option value="WV">West Virginia</option>
                                            <option value="WI">Wisconsin</option>
                                            <option value="WY">Wyoming</option>
                                            <option value="DC">District of Columbia</option>
                                        </select>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="receiver_zip" class="form-label fw-medium">ZIP Code *</label>
                                    <input type="text" class="form-control" id="receiver_zip" name="receiver_zip" required style="border-radius: 10px;" placeholder="ZIP Code" pattern="[0-9]{5}(-[0-9]{4})?" title="Enter a valid ZIP code (e.g., 12345 or 12345-6789)">
                                </div>
                                
                                <div class="mb-3">
                                    <label for="receiver_note" class="form-label fw-medium">Delivery Note (Optional)</label>
                                    <textarea class="form-control" id="receiver_note" name="receiver_note" rows="2" style="border-radius: 10px;" placeholder="Any special instructions for delivery"></textarea>
                                </div>
                                
                                @auth
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="save_address" name="save_address" value="1">
                                        <label class="form-check-label" for="save_address">
                                            <i class="bi bi-bookmark me-1"></i>
                                            Save this address for future orders
                                        </label>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-theme btn-lg" style="border-radius: 15px;">
                            <i class="bi bi-cart-plus me-2"></i>
                            Add to Cart
                        </button>
                        
                        <!-- Test button to bypass validation -->
                        <button type="button" class="btn btn-outline-warning btn-sm" onclick="testFormSubmission()" style="border-radius: 15px;">
                            <i class="bi bi-bug me-2"></i>
                            Test Form (Debug)
                        </button>
                        
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-theme" style="border-radius: 15px;">
                            <i class="bi bi-cart me-2"></i>
                            View Cart
                        </a>
                    </div>
                </form>
                
                <!-- Admin Quick Actions -->
                @auth
                    @if(Auth::user()->is_admin)
                        <div class="admin-actions-section">
                            <h6 class="fw-bold mb-3">
                                <i class="bi bi-gear me-2 text-theme-1"></i>
                                Admin Actions
                            </h6>
                            <div class="row gx-2">
                                <div class="col-6">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-outline-primary btn-sm w-100" style="border-radius: 10px;">
                                        <i class="bi bi-pencil me-1"></i>Edit Product
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="{{ route('admin.products.index') }}" class="btn btn-outline-secondary btn-sm w-100" style="border-radius: 10px;">
                                        <i class="bi bi-list me-1"></i>All Products
                                    </a>
                                </div>
                            </div>
                            <div class="row gx-2 mt-2">
                                <div class="col-6">
                                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-info btn-sm w-100" style="border-radius: 10px;">
                                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                                    </a>
                                </div>
                                <div class="col-6">
                                    <span class="btn btn-outline-success btn-sm w-100" style="border-radius: 10px; cursor: default;">
                                        <i class="bi bi-eye me-1"></i>ID: {{ $product->id }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>

<!-- Related Products -->
@if($relatedProducts->count() > 0)
<div class="mb-3">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="fw-bold mb-0">
            <i class="bi bi-arrow-repeat me-2 text-theme-1"></i>
            Related Products
        </h6>
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    
    <div class="row gx-2 gy-3">
        @foreach($relatedProducts as $related)
        <div class="col-6 col-md-3">
            <div class="card adminuiux-card mb-2 position-relative" style="border-radius: 20px;">
                <a href="{{ route('products.show', $related->slug) }}" class="rounded coverimg height-100 mb-2 m-1 d-block position-relative" style="border-radius: 20px;">
                    @if($related->image)
                        <img src="{{ asset('storage/' . $related->image) }}" alt="{{ $related->name }}" class="w-100 rounded" style="border-radius: 20px;">
                    @else
                        <img src="{{ asset('template-assets/img/ecommerce/image-6.jpg') }}" alt="Product" class="w-100 rounded" style="border-radius: 20px;">
                    @endif
                    <span class="position-absolute top-0 end-0 m-2">
                        <i class="bi bi-heart text-white"></i>
                    </span>
                    <form action="{{ route('cart.add', $related->id) }}" method="POST" class="position-absolute top-0 start-0 m-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-theme-accent-1 rounded-circle" style="width: 32px; height: 32px; padding: 0;">
                            <i class="bi bi-cart-plus text-white" style="font-size: 0.8rem;"></i>
                        </button>
                    </form>
                </a>
                <div class="card-body pt-1 pb-2" style="border-radius: 0 0 20px 20px;">
                    <a href="{{ route('products.show', $related->slug) }}" class="style-none">
                        <h6 class="text-theme-1 text-truncated mb-1" style="color: #ff9800 !important;">{{ $related->name }}</h6>
                    </a>
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="fw-bold">₦{{ number_format($related->price_naira) }}</span>
                        <span class="small text-secondary">{{ $related->store->name ?? 'Bubblemart Store' }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    console.log('=== PRODUCT PAGE LOADED ===');
    console.log('Product: {{ $product->name }}');
    console.log('Product price: ₦{{ number_format($product->price_naira) }}');
    
    const basePrice = {{ $product->price_naira }};
    const priceDisplay = document.querySelector('.h3.fw-bold.text-theme-1');
    const totalPriceDisplay = document.getElementById('totalPriceDisplay');
    const finalPriceInput = document.getElementById('final_price');
    const addToCartForm = document.getElementById('addToCartForm');
    const quantityInput = document.getElementById('quantity');
    const savedAddressSelect = document.getElementById('savedAddressSelect');
    
    function updatePrice() {
        let totalAdjustment = 0;
        
        // Calculate total price adjustment from all selected variations
        document.querySelectorAll('select[name^="variations"], input[type="radio"]:checked').forEach(function(element) {
            const selectedOption = element.options ? element.options[element.selectedIndex] : element;
            if (selectedOption && selectedOption.dataset.priceAdjustment) {
                totalAdjustment += parseFloat(selectedOption.dataset.priceAdjustment);
            }
        });
        
        // Get quantity
        const quantity = parseInt(quantityInput.value) || 1;
        
        // Calculate final price
        const unitPrice = basePrice + totalAdjustment;
        const finalPrice = unitPrice * quantity;
        
        // Update price displays
        if (priceDisplay) {
            priceDisplay.textContent = '₦' + unitPrice.toLocaleString();
        }
        
        if (totalPriceDisplay) {
            totalPriceDisplay.textContent = '₦' + finalPrice.toLocaleString();
        }
        
        // Update hidden input
        if (finalPriceInput) {
            finalPriceInput.value = finalPrice;
        }
        
        console.log('Price updated:', {
            basePrice: basePrice,
            adjustment: totalAdjustment,
            unitPrice: unitPrice,
            quantity: quantity,
            finalPrice: finalPrice
        });
    }
    
    // Handle saved address selection
    if (savedAddressSelect) {
        savedAddressSelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption && selectedOption.value) {
                // Populate form fields with saved address data
                document.getElementById('receiver_name').value = selectedOption.dataset.name || '';
                document.getElementById('receiver_phone').value = selectedOption.dataset.phone || '';
                document.getElementById('receiver_address').value = selectedOption.dataset.address || '';
                document.getElementById('receiver_city').value = selectedOption.dataset.city || '';
                document.getElementById('receiver_state').value = selectedOption.dataset.state || '';
                document.getElementById('receiver_zip').value = selectedOption.dataset.zip || '';
                
                console.log('Saved address selected:', {
                    name: selectedOption.dataset.name,
                    phone: selectedOption.dataset.phone,
                    address: selectedOption.dataset.address,
                    city: selectedOption.dataset.city,
                    state: selectedOption.dataset.state,
                    zip: selectedOption.dataset.zip
                });
            } else {
                // Clear form fields if "Select a saved address" is chosen
                document.getElementById('receiver_name').value = '';
                document.getElementById('receiver_phone').value = '';
                document.getElementById('receiver_address').value = '';
                document.getElementById('receiver_city').value = '';
                document.getElementById('receiver_state').value = '';
                document.getElementById('receiver_zip').value = '';
                document.getElementById('receiver_note').value = '';
            }
        });
    }
    
    // Add event listeners to all variation inputs
    document.querySelectorAll('select[name^="variations"], input[type="radio"][name^="variations"]').forEach(function(element) {
        element.addEventListener('change', updatePrice);
    });
    
    // Update quantity calculation
    if (quantityInput) {
        quantityInput.addEventListener('change', updatePrice);
        quantityInput.addEventListener('input', updatePrice);
    }
    
    // Add to cart form submission
    if (addToCartForm) {
        console.log('Add to cart form found');
        
        addToCartForm.addEventListener('submit', function(e) {
            console.log('=== ADD TO CART FORM SUBMISSION ===');
            
            // Check if user is authenticated
            const isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
            console.log('User authenticated:', isAuthenticated);
            
            if (!isAuthenticated) {
                e.preventDefault();
                alert('Please log in to add items to cart');
                console.log('Form submission blocked: User not authenticated');
                return false;
            }
            
            // Validate required variations
            const requiredVariations = document.querySelectorAll('select[name^="variations"][required], input[type="radio"][name^="variations"][required]');
            let isValid = true;
            
            requiredVariations.forEach(function(element) {
                if (element.type === 'radio') {
                    const name = element.name;
                    const checked = document.querySelector(`input[name="${name}"]:checked`);
                    if (!checked) {
                        isValid = false;
                        console.log('Required variation not selected:', name);
                    }
                } else if (element.type === 'select-one') {
                    if (!element.value) {
                        isValid = false;
                        console.log('Required variation not selected:', element.name);
                    }
                }
            });
            
            if (!isValid) {
                e.preventDefault();
                alert('Please select all required product options before adding to cart');
                console.log('Form submission blocked: Required variations not selected');
                return false;
            }
            
            // Validate receiver information
            const receiverName = document.getElementById('receiver_name').value.trim();
            const receiverPhone = document.getElementById('receiver_phone').value.trim();
            const receiverAddress = document.getElementById('receiver_address').value.trim();
            
            console.log('Receiver information validation:', {
                receiverName: receiverName,
                receiverPhone: receiverPhone,
                receiverAddress: receiverAddress,
                isValid: receiverName && receiverPhone && receiverAddress
            });
            
            if (!receiverName || !receiverPhone || !receiverAddress) {
                e.preventDefault();
                alert('Please fill in all required receiver information');
                console.log('Form submission blocked: Missing receiver information');
                return false;
            }
            
            console.log('Form submission proceeding...');
            console.log('Form data:', {
                quantity: quantityInput.value,
                finalPrice: finalPriceInput.value,
                receiverName: receiverName,
                receiverPhone: receiverPhone,
                receiverAddress: receiverAddress,
                saveAddress: document.getElementById('save_address').checked,
                variations: Array.from(document.querySelectorAll('select[name^="variations"], input[type="radio"]:checked')).map(el => ({
                    name: el.name,
                    value: el.value
                }))
            });
        });
    } else {
        console.log('ERROR: Add to cart form not found!');
    }
    
    // Initialize price calculation
    updatePrice();
    
    // Test function to debug form submission
    window.testFormSubmission = function() {
        console.log('=== TEST FORM SUBMISSION ===');
        
        // Get form data
        const form = document.getElementById('addToCartForm');
        const formData = new FormData(form);
        
        // Log save address checkbox state
        const saveAddressCheckbox = document.getElementById('save_address');
        console.log('Save address checkbox:', {
            exists: !!saveAddressCheckbox,
            checked: saveAddressCheckbox ? saveAddressCheckbox.checked : 'N/A',
            value: saveAddressCheckbox ? saveAddressCheckbox.value : 'N/A'
        });
        
        // Log all form data
        for (let [key, value] of formData.entries()) {
            console.log(`Form field: ${key} = ${value}`);
        }
        
        console.log('Form data:');
        for (let [key, value] of formData.entries()) {
            console.log(key + ': ' + value);
        }
        
        // Check if receiver fields exist
        const receiverName = document.getElementById('receiver_name');
        const receiverPhone = document.getElementById('receiver_phone');
        const receiverAddress = document.getElementById('receiver_address');
        
        console.log('Receiver fields:', {
            receiverName: receiverName ? receiverName.value : 'NOT FOUND',
            receiverPhone: receiverPhone ? receiverPhone.value : 'NOT FOUND',
            receiverAddress: receiverAddress ? receiverAddress.value : 'NOT FOUND'
        });
        
        // Submit form without validation
        console.log('Submitting form...');
        form.submit();
    };
    
    // Product image carousel functionality
    function goToSlide(slideIndex) {
        const carousel = document.getElementById('productImageCarousel');
        if (carousel) {
            const bsCarousel = new bootstrap.Carousel(carousel);
            bsCarousel.to(slideIndex);
            
            // Update thumbnail borders
            const thumbnails = document.querySelectorAll('.thumbnail-item');
            thumbnails.forEach((thumb, index) => {
                if (index === slideIndex) {
                    thumb.style.border = '2px solid #036674';
                } else {
                    thumb.style.border = '2px solid transparent';
                }
            });
        }
    }
    
    // Update thumbnail borders when carousel slides
    const carousel = document.getElementById('productImageCarousel');
    if (carousel) {
        carousel.addEventListener('slid.bs.carousel', function (event) {
            const thumbnails = document.querySelectorAll('.thumbnail-item');
            thumbnails.forEach((thumb, index) => {
                if (index === event.to) {
                    thumb.style.border = '2px solid #036674';
                } else {
                    thumb.style.border = '2px solid transparent';
                }
            });
        });
    }
});
</script>

<style>
/* Product image carousel styling */
.carousel-indicators {
    bottom: 10px;
}

.carousel-indicators button {
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.5);
    border: none;
    margin: 0 3px;
}

.carousel-indicators button.active {
    background-color: #036674;
}

.carousel-control-prev,
.carousel-control-next {
    width: 40px;
    height: 40px;
    background-color: rgba(3, 102, 116, 0.8);
    border-radius: 50%;
    top: 50%;
    transform: translateY(-50%);
    margin: 0 10px;
}

.carousel-control-prev-icon,
.carousel-control-next-icon {
    width: 20px;
    height: 20px;
}

.thumbnail-item {
    transition: all 0.3s ease;
}

.thumbnail-item:hover {
    transform: scale(1.05);
    border-color: #036674 !important;
}

/* Light theme carousel controls */
[data-theme="light"] .carousel-control-prev,
[data-theme="light"] .carousel-control-next {
    background-color: rgba(3, 102, 116, 0.9);
}

[data-theme="light"] .carousel-indicators button {
    background-color: rgba(0, 0, 0, 0.3);
}

[data-theme="light"] .carousel-indicators button.active {
    background-color: #036674;
}
</style>
@endpush 
@extends('layouts.template')

@section('content')

<style>
/* Consistent gradient backgrounds */
.header-card { background: linear-gradient(135deg,rgba(16,17,19,0.44) 0%,rgb(0,0,0) 100%) !important; }
.info-card { background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important; }

/* Custom button styling to match card gradients */
.btn-gradient {
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
    border: none !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
}

.btn-gradient:hover {
    background: linear-gradient(135deg,rgba(16,17,19,0.44) 0%,rgb(0,0,0) 100%) !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
}

/* Product card styling */
.product-card {
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
    border: none !important;
    border-radius: 20px !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    transition: all 0.3s ease;
    color: #ffffff !important;
    overflow: hidden;
    position: relative;
    height: 320px !important;
    display: flex !important;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2) !important;
}

/* Product card with background image */
.product-card-bg {
    background-size: cover !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
    background-color: #1a1a1a !important;
    position: relative;
}

.product-card-bg::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(16,16,19,0.8) 0%, rgba(0,0,0,0.9) 100%);
    z-index: 1;
}

.product-card-bg:hover::before {
    background: linear-gradient(135deg, rgba(16,17,19,0.7) 0%, rgba(0,0,0,0.8) 100%);
}

.product-card-content {
    position: relative;
    z-index: 2;
    height: 100% !important;
    width: 100% !important;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 1rem;
}

/* Filter card styling */
.filter-card {
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
    border: none !important;
    border-radius: 15px !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    color: #ffffff !important;
}

/* Empty state card */
.empty-card {
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
    border: none !important;
    border-radius: 20px !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    color: #ffffff !important;
}

/* Text color fixes */
.text-theme-1 { color: #ffffff !important; }
.text-secondary { color: #b0b0b0 !important; }
.welcome-label { color: #b0b0b0 !important; }
.welcome-username { color: #ffffff !important; }

/* Product image styling - removed since using background images */

/* Product title styling */
.product-title {
    color: #ff6b35 !important;
    font-weight: 600;
    transition: all 0.3s ease;
}

.product-card:hover .product-title {
    color: #ff8c42 !important;
}

/* Price styling */
.product-price {
    color: #ffffff !important;
    font-weight: bold;
    font-size: 1.1rem;
}

/* Store name styling */
.store-name {
    color: #b0b0b0 !important;
    font-size: 0.85rem;
}

/* Category styling */
.category-name {
    color: #b0b0b0 !important;
    font-size: 0.8rem;
}

/* Rating styling */
.rating-text {
    color: #ffffff !important;
}

.rating-count {
    color: #b0b0b0 !important;
}

/* Cart button styling */
.cart-btn {
    background: #ff6b35 !important;
    border: none !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
    width: 32px !important;
    height: 32px !important;
    padding: 0 !important;
    border-radius: 50% !important;
}

.cart-btn:hover {
    background: #ff8c42 !important;
    transform: scale(1.1);
    box-shadow: 0 4px 15px rgba(255,107,53,0.3) !important;
}

/* Heart button styling */
.heart-btn {
    color: #ffffff !important;
    text-shadow: 0 2px 4px rgba(0,0,0,0.5);
    transition: all 0.3s ease;
}

.heart-btn:hover {
    color: #ff6b35 !important;
    transform: scale(1.2);
}

/* Form check styling */
.form-check-input:checked {
    background-color: #ff6b35 !important;
    border-color: #ff6b35 !important;
}

.form-check-label {
    color: #ffffff !important;
}

.form-label {
    color: #ffffff !important;
}

/* Mobile padding */
@media (max-width: 768px) {
    .container { padding: 0 15px; }
}

/* Search bar styling */
.search-container {
    background: linear-gradient(135deg, rgba(0, 73, 83, 0.1) 0%, rgba(0, 0, 0, 0.2) 100%);
    border-radius: 20px;
    padding: 1rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.search-input {
    background: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: #ffffff !important;
    border-radius: 15px !important;
    padding: 0.75rem 1rem !important;
    font-size: 0.9rem !important;
}

.search-input::placeholder {
    color: rgba(255, 255, 255, 0.7) !important;
}

.search-input:focus {
    background: rgba(255, 255, 255, 0.15) !important;
    border-color: rgba(0, 73, 83, 0.5) !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 73, 83, 0.25) !important;
    color: #ffffff !important;
}

.search-btn {
    background: linear-gradient(135deg, #004953 0%, #005a66 100%) !important;
    border: none !important;
    border-radius: 15px !important;
    padding: 0.75rem 1.5rem !important;
    color: #ffffff !important;
    font-weight: 500 !important;
    transition: all 0.3s ease !important;
}

.search-btn:hover {
    background: linear-gradient(135deg, #005a66 0%, #004953 100%) !important;
    transform: translateY(-1px) !important;
    box-shadow: 0 4px 15px rgba(0, 73, 83, 0.4) !important;
}
</style>

<!-- Welcome/User & Location -->
<div class="d-flex align-items-center justify-content-between mb-3">
    <div class="d-flex align-items-center">
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
    <div class="input-group input-group-sm w-auto location-select">
        <span class="input-group-text bg-none location-icon"><i class="bi bi-geo-alt"></i></span>
        <select class="form-select form-select-sm bg-none">
            <option>Lagos</option>
            <option>Abuja</option>
            <option>Port Harcourt</option>
            <option>Kano</option>
            <option>Ibadan</option>
        </select>
    </div>
</div>

<!-- Search Bar -->
<div class="search-container mb-3">
    <form action="{{ route('search') }}" method="GET" class="d-flex gap-2">
        <div class="flex-grow-1 position-relative">
            <input type="text" 
                   name="search" 
                   class="form-control search-input" 
                   placeholder="Search for products, categories, or stores..." 
                   value="{{ $search ?? '' }}"
                   autocomplete="off">
            <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                <i class="bi bi-search text-white opacity-50"></i>
            </div>
        </div>
        <button type="submit" class="btn search-btn">
            <i class="bi bi-search me-1"></i>Search
        </button>
    </form>
</div>

<!-- Page Header -->
<div class="row gx-3 mb-3">
    <div class="col mb-3 mb-lg-4">
        @if(isset($search) && $search)
            <p class="small text-theme-1 text-truncated mb-0">Search Results for "{{ $search }}",</p>
            <h6 class="fw-bold text-theme-accent-1 mb-0">{{ $products->count() }} Product{{ $products->count() !== 1 ? 's' : '' }} Found</h6>
        @else
            <p class="small text-theme-1 text-truncated mb-0">All Products,</p>
            <h6 class="fw-bold text-theme-accent-1 mb-0">{{ $products->count() }} Product{{ $products->count() !== 1 ? 's' : '' }}</h6>
        @endif
    </div>
    <div class="col-auto mb-3 mb-lg-4">
        <button class="btn btn-square btn-link" data-bs-toggle="collapse" data-bs-target="#filters">
            <i class="bi bi-filter"></i>
        </button>
    </div>
</div>

<!-- Filters -->
<div class="collapse mb-3" id="filters">
    <div class="card filter-card">
        <div class="card-body">
            <h6 class="fw-bold mb-3">
                <i class="bi bi-funnel me-2 text-theme-1"></i>
                Filters
            </h6>
            <form method="GET" action="{{ route('products.index') }}">
                <div class="row gx-3">
                    <div class="col-12">
                        <label class="form-label fw-medium">Categories</label>
                        <div class="row gx-2">
                            @foreach($categories as $category)
                            <div class="col-12 mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="category[]" value="{{ $category->slug }}" id="cat{{ $category->id }}">
                                    <label class="form-check-label fw-medium" for="cat{{ $category->id }}">
                                        {{ $category->icon }} {{ $category->name }}
                                    </label>
                                </div>
                                @if($category->children->count() > 0)
                                    <div class="ms-4 mt-2">
                                        <div class="row gx-2">
                                            @foreach($category->children as $subcategory)
                                            <div class="col-6 col-md-4">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="category[]" value="{{ $subcategory->slug }}" id="subcat{{ $subcategory->id }}">
                                                    <label class="form-check-label small" for="subcat{{ $subcategory->id }}">
                                                        {{ $subcategory->icon }} {{ $subcategory->name }}
                                                    </label>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-gradient btn-sm">
                        <i class="bi bi-check2 me-1"></i>
                        Apply Filters
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Products Grid -->
@if($products->count() > 0)
    <div class="row gx-2 gy-3">
        @foreach($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card product-card product-card-bg mb-2 position-relative" 
                 style="background-image: url('{{ $product->image ? asset('storage/' . $product->image) : asset('template-assets/img/ecommerce/image-6.jpg') }}')">
                <div class="product-card-content">
                    <!-- Action buttons at top -->
                    <div class="d-flex justify-content-between align-items-start">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm cart-btn">
                                <i class="bi bi-cart-plus text-white" style="font-size: 0.8rem;"></i>
                            </button>
                        </form>
                        <div>
                            <i class="bi bi-heart heart-btn"></i>
                        </div>
                    </div>
                    
                    <!-- Product info at bottom -->
                    <div style="margin-top: auto;">
                        <a href="{{ route('products.show', $product->slug) }}" class="style-none">
                            <h6 class="product-title text-truncated mb-1">{{ $product->name }}</h6>
                        </a>
                        <div class="d-flex align-items-center mb-1">
                            <span class="me-1 small rating-text"><i class="bi bi-star-fill text-warning"></i> {{ number_format($product->rating ?? 4.5, 1) }}</span>
                            <span class="small rating-count">({{ $product->reviews_count ?? rand(10, 50) }})</span>
                        </div>
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="product-price">₦{{ number_format($product->price_naira) }}</span>
                            <span class="small store-name">{{ $product->store->name ?? 'Bubblemart Store' }}</span>
                        </div>
                        <div class="small category-name">
                            {{ $product->category->full_name }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    @if($products->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links('vendor.pagination.simple') }}
    </div>
    @endif

@else
    <!-- Empty State -->
    <div class="row justify-content-center mb-3">
        <div class="col-12">
            <div class="card empty-card text-center p-5">
                <div class="mb-4">
                    <div class="avatar avatar-80 rounded-circle bg-theme-1 mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-box-seam h1 text-white"></i>
                    </div>
                    <h4 class="fw-bold mb-2 text-theme-1">No Products Found</h4>
                    <p class="text-secondary mb-0">Try adjusting your filters or browse all categories</p>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-gradient btn-lg px-5" style="border-radius: 15px;">
                    <i class="bi bi-arrow-clockwise me-2"></i>
                    Clear Filters
                </a>
            </div>
        </div>
    </div>
@endif

@endsection 
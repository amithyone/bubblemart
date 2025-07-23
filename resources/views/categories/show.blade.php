@extends('layouts.template')

@section('content')

<style>
/* Remove card borders and add shadows - same as other pages */
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

/* Category cards specific styling */
.category-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.22) 0%,rgb(0, 0, 0) 100%) !important;
}

.category-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Font sizes and weights matching other pages */
.page-title {
    font-size: 0.95rem !important;
    font-weight: 600 !important;
    color: var(--text-primary) !important;
}

.page-subtitle {
    font-size: 0.75rem !important;
    color: var(--text-secondary) !important;
    font-weight: normal !important;
}

.category-title {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: var(--text-primary) !important;
}

.category-description {
    font-size: 0.75rem !important;
    color: var(--text-secondary) !important;
    font-weight: normal !important;
}

.product-title {
    font-size: 0.8rem !important;
    font-weight: 500 !important;
    color: var(--text-primary) !important;
}

/* Light theme overrides */
[data-theme="light"] .adminuiux-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 20px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .adminuiux-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-2px);
}

[data-theme="light"] .category-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 20px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .category-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-2px);
}

/* Light theme specific overrides */
[data-theme="light"] .page-title {
    color: #000000 !important;
}

[data-theme="light"] .page-subtitle {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .category-title {
    color: #000000 !important;
}

[data-theme="light"] .category-description {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .product-title {
    color: #000000 !important;
}

/* Light theme button styling */
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

[data-theme="light"] .badge.bg-theme-1 {
    background-color: #036674 !important;
    color: #ffffff !important;
}

/* Light theme text colors */
[data-theme="light"] .text-theme-1 {
    color: #036674 !important;
}

[data-theme="light"] .text-secondary {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .text-warning {
    color: #ffc107 !important;
}

[data-theme="light"] .bi-person-circle {
    color: rgba(0, 0, 0, 0.7) !important;
}

/* Override any template font styles */
* {
    font-family: inherit !important;
}

/* Ensure no bold text from template */
strong, b, .fw-bold {
    font-weight: inherit !important;
}

/* Line height for consistency */
p, h6, span, div {
    line-height: 1.2 !important;
}

/* Override any Bootstrap classes */
.small {
    font-size: 0.75rem !important;
    font-weight: normal !important;
}

.fw-bold {
    font-weight: 600 !important;
}

/* Override any template font weights */
strong, b {
    font-weight: 600 !important;
}
</style>

<!-- Welcome/User -->
<div class="d-flex align-items-center mb-3">
    <figure class="avatar avatar-30 rounded coverimg align-middle me-2">
        @auth
            <img src="{{ \App\Helpers\StorageHelper::getAvatarUrl(Auth::user()) }}" alt="Profile" style="width: 30px; height: 30px; object-fit: cover;" onerror="handleImageError(this);">
        @else
            <i class="bi bi-person-circle h2 person-icon"></i>
        @endauth
    </figure>
    <div>
        <p class="welcome-label text-truncated mb-0">Welcome,</p>
        <h6 class="welcome-username mb-0">
            @auth
                {{ Auth::user()->name }}
            @else
                Guest
            @endauth
        </h6>
    </div>
</div>

<!-- Category Header -->
<div class="text-center mb-4">
    <div class="avatar avatar-80 rounded-circle bg-theme-1 mx-auto mb-3 d-flex align-items-center justify-content-center">
        <span style="font-size: 2.5rem;">{{ $category->icon }}</span>
    </div>
    <h2 class="category-title mb-2">{{ $category->name }}</h2>
    <p class="category-description mb-0">{{ $category->description }}</p>
    @if($category->parent)
        <div class="mt-2">
            <a href="{{ route('categories.show', $category->parent->slug) }}" class="btn btn-sm btn-outline-theme" style="border-radius: 10px;">
                <i class="bi bi-arrow-left me-1"></i>
                Back to {{ $category->parent->name }}
            </a>
        </div>
    @endif
</div>

<!-- Subcategories (if any) -->
@if($category->children->count() > 0)
<div class="mb-4">
    <h6 class="page-title mb-3">
        <i class="bi bi-folder me-2"></i>
        Subcategories
    </h6>
    <div class="row gx-2 gy-3">
        @foreach($category->children as $subcategory)
        <div class="col-6 col-md-3">
            <a href="{{ route('categories.show', $subcategory->slug) }}" class="text-decoration-none">
                <div class="card adminuiux-card category-card">
                    @if($subcategory->is_featured)
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-warning text-dark" style="font-size: 0.6rem;">
                                <i class="fas fa-star me-1"></i>Featured
                            </span>
                        </div>
                    @endif
                    <div class="card-body text-center p-3">
                        <div class="mb-2">
                            <span class="display-4">{{ $subcategory->icon ?? '📁' }}</span>
                        </div>
                        <h6 class="category-title mb-1">{{ $subcategory->name }}</h6>
                        <span class="badge bg-theme-1 text-white" style="border-radius: 8px; font-size: 0.7rem;">
                            {{ $subcategory->products_count ?? 0 }} Products
                        </span>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Products Grid -->
@if($products->count() > 0)
<div class="mb-4">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="page-title mb-0">
            <i class="bi bi-box-seam me-2"></i>
            Products ({{ $products->count() }})
        </h6>
        <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-theme" style="border-radius: 10px;">
            <i class="bi bi-grid me-1"></i>
            View All Products
        </a>
    </div>
    
    <div class="row gx-2 gy-3">
        @foreach($products as $product)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card adminuiux-card mb-2 position-relative" style="border-radius: 20px;">
                <a href="{{ route('products.show', $product->slug) }}" class="rounded coverimg height-100 mb-2 m-1 d-block position-relative" style="border-radius: 20px;">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-100 rounded" style="border-radius: 20px;">
                    @else
                        <img src="{{ asset('template-assets/img/ecommerce/image-6.jpg') }}" alt="Product" class="w-100 rounded" style="border-radius: 20px;">
                    @endif
                    <span class="position-absolute top-0 end-0 m-2">
                        <i class="bi bi-heart text-white"></i>
                    </span>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="position-absolute top-0 start-0 m-2">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-theme-accent-1 rounded-circle" style="width: 32px; height: 32px; padding: 0;">
                            <i class="bi bi-cart-plus text-white" style="font-size: 0.8rem;"></i>
                        </button>
                    </form>
                </a>
                <div class="card-body pt-1 pb-2" style="border-radius: 0 0 20px 20px;">
                    <a href="{{ route('products.show', $product->slug) }}" class="style-none">
                        <h6 class="product-title text-truncated mb-1">{{ $product->name }}</h6>
                    </a>
                    <div class="d-flex align-items-center mb-1">
                        <span class="me-1 small"><i class="bi bi-star-fill text-warning"></i> {{ number_format($product->rating ?? 4.5, 1) }}</span>
                        <span class="small text-secondary">({{ $product->reviews_count ?? rand(10, 50) }})</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between mb-1">
                        <span class="fw-bold">₦{{ number_format($product->price_naira) }}</span>
                        <span class="small text-secondary">{{ $product->store->name ?? 'Bubblemart Store' }}</span>
                    </div>
                    <div class="small text-secondary">
                        {{ $product->category->full_name }}
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    
    <!-- Pagination -->
    @if($products->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
    @endif

@else
    <!-- Empty State -->
    <div class="row justify-content-center mb-3">
        <div class="col-12">
            <div class="card adminuiux-card text-center p-5" style="border-radius: 20px;">
                <div class="mb-4">
                    <div class="avatar avatar-80 rounded-circle bg-theme-1 mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-box-seam h1 text-white"></i>
                    </div>
                    <h4 class="page-title mb-2">No Products Found</h4>
                    <p class="page-subtitle mb-0">No products available in this category yet</p>
                </div>
                <a href="{{ route('categories.index') }}" class="btn btn-theme btn-lg px-5" style="border-radius: 15px;">
                    <i class="bi bi-arrow-left me-2"></i>
                    Browse Other Categories
                </a>
            </div>
        </div>
    </div>
@endif

@endsection 
@extends('layouts.template')

@section('content')

<style>
/* Ensure button text is white */
.btn-theme {
    color: #ffffff !important;
}

.btn-theme:hover {
    color: #ffffff !important;
}

/* More specific selectors to override template CSS */
a.btn-theme,
button.btn-theme,
.btn.btn-theme {
    color: #ffffff !important;
    background-color: #004953 !important;
}

a.btn-theme:hover,
button.btn-theme:hover,
.btn.btn-theme:hover {
    color: #ffffff !important;
    background-color: #005a66 !important;
}

/* Force white text for all theme buttons */
.btn-theme,
.btn-theme *,
.btn-theme i,
.btn-theme span {
    color: #ffffff !important;
}

/* Override any template CSS variables */
.btn-theme {
    --bs-btn-color: #ffffff !important;
    --bs-btn-hover-color: #ffffff !important;
    color: #ffffff !important;
}

/* Light theme styling */
[data-theme="light"] .welcome-label {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .welcome-username {
    color: #000000 !important;
}

[data-theme="light"] .text-theme-1 {
    color: #036674 !important;
}

[data-theme="light"] .text-secondary {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .bg-theme-1 {
    background-color: #036674 !important;
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

[data-theme="light"] .adminuiux-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .adminuiux-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
}

[data-theme="light"] .badge.bg-theme-1 {
    background-color: #036674 !important;
    color: #ffffff !important;
}

[data-theme="light"] .text-warning {
    color: #ffc107 !important;
}

[data-theme="light"] .bi-person-circle {
    color: rgba(0, 0, 0, 0.7) !important;
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

<!-- Category Header -->
<div class="text-center mb-4">
    <div class="avatar avatar-80 rounded-circle bg-theme-1 mx-auto mb-3 d-flex align-items-center justify-content-center">
        <span style="font-size: 2.5rem;">{{ $category->icon }}</span>
    </div>
    <h2 class="fw-bold text-theme-1 mb-2">{{ $category->name }}</h2>
    <p class="text-secondary mb-0">{{ $category->description }}</p>
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
    <h6 class="fw-bold mb-3">
        <i class="bi bi-folder me-2 text-theme-1"></i>
        Subcategories
    </h6>
    <div class="row g-2">
        @foreach($category->children as $subcategory)
        <div class="col-6 col-md-3">
            <a href="{{ route('categories.show', $subcategory->slug) }}" class="text-decoration-none">
                <div class="card adminuiux-card text-center" style="border-radius: 15px;">
                    <div class="card-body p-3">
                        <div class="mb-2">
                            <span style="font-size: 2rem;">{{ $subcategory->icon }}</span>
                        </div>
                        <h6 class="fw-bold text-theme-1 mb-1">{{ $subcategory->name }}</h6>
                        <span class="badge bg-theme-1 text-dark" style="border-radius: 8px; font-size: 0.8em;">
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
        <h6 class="fw-bold mb-0">
            <i class="bi bi-box-seam me-2 text-theme-1"></i>
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
                        <h6 class="text-theme-1 text-truncated mb-1" style="color: #ff9800 !important;">{{ $product->name }}</h6>
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
                    <h4 class="fw-bold mb-2">No Products Found</h4>
                    <p class="text-secondary mb-0">No products available in this category yet</p>
                </div>
                <a href="{{ route('categories.index') }}" class="btn btn-theme btn-lg px-5" style="border-radius: 15px; color: #ffffff !important; background-color: #004953 !important;">
                    <i class="bi bi-arrow-left me-2" style="color: #ffffff !important;"></i>
                    Browse Other Categories
                </a>
            </div>
        </div>
    </div>
@endif

</div>

@endsection 
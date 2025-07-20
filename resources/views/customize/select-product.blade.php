@extends('layouts.template')

@section('content')

<style>
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

/* Product cards specific styling */
.product-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.22) 0%,rgb(0, 0, 0) 100%) !important;
}

.product-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Progress steps styling */
.progress-step {
    transition: all 0.3s ease;
}

.progress-step:hover {
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

/* Font sizes and weights matching wallet page */
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

.product-title {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: var(--text-primary) !important;
}

.product-description {
    font-size: 0.75rem !important;
    color: var(--text-secondary) !important;
    font-weight: normal !important;
}

.product-price {
    font-size: 0.95rem !important;
    font-weight: 600 !important;
    color: var(--text-primary) !important;
}

.progress-step-title {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: var(--text-primary) !important;
}

.progress-step-label {
    font-size: 0.75rem !important;
    color: var(--text-secondary) !important;
    font-weight: normal !important;
}

.progress-step-number {
    font-size: 0.85rem !important;
    font-weight: 600 !important;
    color: var(--text-primary) !important;
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

/* Light theme specific overrides */
[data-theme="light"] .page-title {
    color: #000000 !important;
}

[data-theme="light"] .page-subtitle {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .product-title {
    color: #000000 !important;
}

[data-theme="light"] .product-description {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .product-price {
    color: #000000 !important;
}

[data-theme="light"] .progress-step-title {
    color: #000000 !important;
}

[data-theme="light"] .progress-step-label {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .progress-step-number {
    color: #000000 !important;
}

/* Active progress step */
.progress-step.active .progress-step-title {
    color: var(--text-primary) !important;
}

.progress-step.active .progress-step-label {
    color: var(--text-secondary) !important;
}

/* Inactive progress steps */
.progress-step:not(.active) .progress-step-title {
    color: var(--text-secondary) !important;
    opacity: 0.7 !important;
}

.progress-step:not(.active) .progress-step-label {
    color: var(--text-secondary) !important;
    opacity: 0.6 !important;
}

/* Light theme overrides for progress steps */
[data-theme="light"] .progress-step.active .progress-step-title {
    color: #000000 !important;
}

[data-theme="light"] .progress-step.active .progress-step-label {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .progress-step:not(.active) .progress-step-title {
    color: rgba(0, 0, 0, 0.6) !important;
    opacity: 1 !important;
}

[data-theme="light"] .progress-step:not(.active) .progress-step-label {
    color: rgba(0, 0, 0, 0.5) !important;
    opacity: 1 !important;
}

/* Light theme product card styling */
[data-theme="light"] .product-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .product-card:hover {
    background: #f8f9fa !important;
    border-color: #036674 !important;
    box-shadow: 0 8px 25px rgba(3, 102, 116, 0.2) !important;
}

/* Light theme progress step avatars */
[data-theme="light"] .progress-step .avatar {
    background-color: #036674 !important;
}

[data-theme="light"] .progress-step.active .avatar {
    background-color: #036674 !important;
}

[data-theme="light"] .progress-step.completed .avatar {
    background-color: #036674 !important;
}

/* Light theme header card styling */
[data-theme="light"] .header-card {
    background: #ffffff !important;
    border-radius: 12px !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .header-card .card-body {
    border-radius: 12px !important;
}

[data-theme="light"] .header-card .page-title {
    color: #000000 !important;
}

[data-theme="light"] .header-card .page-subtitle {
    color: rgba(0, 0, 0, 0.7) !important;
}
</style>
<div class="row justify-content-center mb-3">
    <div class="col-12 col-md-10">
        <!-- Progress Steps -->
        <div class="row gx-2 mb-3">
            <div class="col-3">
                <div class="progress-step completed text-center">
                    <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                        <i class="bi bi-check text-white"></i>
                    </div>
                    <h6 class="progress-step-title mb-1">Category</h6>
                    <p class="progress-step-label mb-0">Selected</p>
                </div>
            </div>
            <div class="col-3">
                <div class="progress-step active text-center">
                    <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                        <span class="progress-step-number text-white">2</span>
                    </div>
                    <h6 class="progress-step-title mb-1">Product</h6>
                    <p class="progress-step-label mb-0">Current</p>
                </div>
            </div>
            <div class="col-3">
                <div class="progress-step text-center">
                    <div class="avatar avatar-40 rounded bg-secondary mx-auto mb-2">
                        <span class="progress-step-number text-white">3</span>
                    </div>
                    <h6 class="progress-step-title mb-1">Type</h6>
                    <p class="progress-step-label mb-0">Next</p>
                </div>
            </div>
            <div class="col-3">
                <div class="progress-step text-center">
                    <div class="avatar avatar-40 rounded bg-secondary mx-auto mb-2">
                        <span class="progress-step-number text-white">4</span>
                    </div>
                    <h6 class="progress-step-title mb-1">Customize</h6>
                    <p class="progress-step-label mb-0">Final</p>
                </div>
            </div>
        </div>

        <!-- Category Header -->
        <div class="card adminuiux-card header-card mb-3">
            <div class="card-body text-center">
                <h5 class="page-title mb-1">Step 2: Choose Your Item</h5>
                <p class="page-subtitle mb-0">Select an item from {{ $category->name }} {{ $category->icon ?? '💎' }}</p>
            </div>
        </div>

        <!-- Products Grid -->
        @if($products->count() > 0)
            <div class="row gx-2 gy-3">
                @foreach($products as $product)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('customize.receiverInfo', $product->slug) }}" class="text-decoration-none">
                        <div class="card adminuiux-card h-100 product-card">
                            <div class="card-body text-center p-3">
                                <div class="mb-2">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                             class="rounded w-100" style="height: 120px; object-fit: cover;">
                                    @else
                                        <div class="avatar avatar-80 rounded bg-theme-accent-1 mx-auto d-flex align-items-center justify-content-center">
                                            <i class="bi bi-gift h2 text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <h6 class="product-title text-truncated mb-1">{{ $product->name }}</h6>
                                <p class="product-description mb-2">{{ Str::limit($product->description, 60) }}</p>
                                <div class="mb-2">
                                    <span class="product-price">₦{{ number_format($product->price_naira) }}</span>
                                </div>
                                <div class="mt-2">
                                    <small class="product-description">
                                        <i class="bi bi-arrow-right me-1"></i>Select Product
                                    </small>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        @else
            <div class="card adminuiux-card text-center py-5">
                <div class="card-body">
                    <i class="bi bi-box h1 text-secondary mb-3"></i>
                    <h5 class="page-title mb-2">No Products Available</h5>
                    <p class="page-subtitle mb-3">There are no products available in this category for customization.</p>
                    <a href="{{ route('customize.index') }}" class="btn btn-theme">
                        <i class="bi bi-arrow-left me-2"></i>Choose Another Category
                    </a>
                </div>
            </div>
        @endif

        <!-- Back Button -->
        <div class="text-center mt-3">
            <a href="{{ route('customize.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Categories
            </a>
        </div>
    </div>
</div>

<style>
.product-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.product-card:hover {
    transform: translateY(-3px);
    border-color: var(--dark-accent) !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3) !important;
}

/* Ensure text colors don't change on hover for links */
a:hover .text-theme-1,
a:hover .text-secondary,
a:hover .text-theme-accent-1 {
    color: inherit !important;
}

/* Add subtle hover effect for the entire card */
a:hover .product-card {
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.3) 0%,rgb(0, 0, 0) 100%) !important;
}

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
}

a.btn-theme:hover,
button.btn-theme:hover,
.btn.btn-theme:hover {
    color: #ffffff !important;
}

/* Force white text for all theme buttons */
.btn-theme,
.btn-theme *,
.btn-theme i,
.btn-theme span {
    color: #ffffff !important;
}

/* Most specific selectors to override template CSS */
div .btn-theme,
.card .btn-theme,
.card-body .btn-theme,
a.btn-theme,
button.btn-theme,
.btn.btn-theme {
    color: #ffffff !important;
    background-color: #004953 !important;
}

div .btn-theme:hover,
.card .btn-theme:hover,
.card-body .btn-theme:hover,
a.btn-theme:hover,
button.btn-theme:hover,
.btn.btn-theme:hover {
    color: #ffffff !important;
    background-color: #005a66 !important;
}

/* Override any template CSS variables */
.btn-theme {
    --bs-btn-color: #ffffff !important;
    --bs-btn-hover-color: #ffffff !important;
    color: #ffffff !important;
}
</style>
@endsection 
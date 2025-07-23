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

<!-- Header -->
<div class="d-flex align-items-center justify-content-between mb-3">
    <div>
        <h4 class="page-title mb-1">
            <i class="bi bi-grid-3x3-gap-fill me-2"></i>Categories
        </h4>
        <p class="page-subtitle mb-0">Browse all product categories</p>
    </div>
    <a href="{{ route('products.index') }}" class="btn btn-theme btn-sm" style="border-radius: 10px;">
        <i class="bi bi-box-seam me-1"></i> All Products
    </a>
</div>

<!-- Categories Grid -->
<div class="row gx-2 gy-3">
    @forelse($categories as $category)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                <div class="card adminuiux-card h-100 category-card">
                    @if($category->is_featured)
                        <div class="position-absolute top-0 end-0 m-2">
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-star me-1"></i>Featured
                            </span>
                        </div>
                    @endif
                    <div class="card-body text-center p-3">
                        <div class="mb-3">
                            <span class="display-1">{{ $category->icon ?? '🎁' }}</span>
                        </div>
                        <h6 class="category-title mb-2">{{ $category->name }}</h6>
                        <p class="category-description mb-2">{{ $category->description ?? 'Browse products' }}</p>
                        <span class="badge bg-theme-1 text-white" style="border-radius: 8px; font-size: 0.75rem;">
                            {{ round(($category->total_products_count ?? $category->products_count ?? 0) / 100) * 100 }} Products
                        </span>
                    </div>
                </div>
            </a>
        </div>
    @empty
        <div class="col-12">
            <div class="text-center py-5">
                <div class="mb-3">
                    <span class="display-1">📦</span>
                </div>
                <h5 class="text-muted">No categories available</h5>
                <p class="text-muted">Please contact an administrator to add categories.</p>
            </div>
        </div>
    @endforelse
</div>

@endsection 
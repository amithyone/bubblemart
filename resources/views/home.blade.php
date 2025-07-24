@extends('layouts.template')

@section('content')

<style>
/* Simple, clean styles for home page */
.home-product-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
}

.home-product-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Override template CSS for background images */
.card.home-product-card {
    background-image: inherit !important;
    background-size: cover !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
}

/* Force background images to show */
.card.home-product-card[style*="background-image"] {
    background-image: inherit !important;
    background-size: cover !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
}

/* Search bar styling */
.search-container {
    background: linear-gradient(135deg, rgba(0, 73, 83, 0.1) 0%, rgba(0, 0, 0, 0.2) 100%);
    border-radius: 20px;
    padding: 1rem;
    margin-bottom: 1rem;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.1);
}

.search-input {
    background: rgba(255, 255, 255, 0.1) !important;
    border: 1px solid rgba(255, 255, 255, 0.2) !important;
    color: var(--text-primary) !important;
    border-radius: 15px !important;
    padding: 0.75rem 1rem !important;
    font-size: 0.9rem !important;
}

.search-input::placeholder {
    color: var(--text-secondary) !important;
}

.search-input:focus {
    background: rgba(255, 255, 255, 0.15) !important;
    border-color: rgba(0, 73, 83, 0.5) !important;
    box-shadow: 0 0 0 0.2rem rgba(0, 73, 83, 0.25) !important;
    color: var(--text-primary) !important;
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

/* Text styling - Theme aware */
.welcome-label {
    font-size: 0.85rem !important;
    color: var(--text-secondary) !important;
    font-weight: normal !important;
}

.welcome-username {
    font-size: 0.95rem !important;
    font-weight: 600 !important;
    color: var(--text-primary) !important;
}

.banner-title {
    font-size: 0.95rem !important;
    font-weight: 600 !important;
    color: var(--text-primary) !important;
}

.banner-subtitle {
    font-size: 0.75rem !important;
    color: var(--text-secondary) !important;
    font-weight: normal !important;
}

.category-name {
    font-size: 0.75rem !important;
    color: var(--text-secondary) !important;
    font-weight: normal !important;
}

.product-name {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: var(--text-primary) !important;
}

.product-rating {
    font-size: 0.75rem !important;
    color: var(--text-secondary) !important;
    font-weight: normal !important;
}

.product-price {
    font-size: 0.95rem !important;
    font-weight: 600 !important;
    color: var(--text-primary) !important;
}

.product-store {
    font-size: 0.75rem !important;
    color: var(--text-secondary) !important;
    font-weight: normal !important;
}

/* Category slider card styling */
.swipernav .card {
    border-radius: 15px !important;
    overflow: hidden !important;
    background: rgba(0, 73, 83, 0.1) !important;
}

.swipernav .card-body {
    border-radius: 0 15px 15px 0 !important;
    background: transparent !important;
}

/* Light theme category slider styling */
[data-theme="light"] .swipernav .card {
    background: rgba(0, 73, 83, 0.05) !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .swipernav .card-body {
    background: transparent !important;
}

/* Override any template background overrides */
div.card.adminuiux-card.home-product-card[style*="background-image"] {
    background-image: inherit !important;
    background-size: cover !important;
    background-position: center !important;
    background-repeat: no-repeat !important;
}

/* Override template's dark-card background */
.card.home-product-card {
    background: none !important;
}

/* Most specific override for template CSS */
div.card.adminuiux-card.home-product-card {
    background: none !important;
}

/* Light theme specific overrides */
[data-theme="light"] .search-input {
    background: rgba(0, 0, 0, 0.05) !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #000000 !important;
}

[data-theme="light"] .search-input::placeholder {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .search-input:focus {
    background: rgba(0, 0, 0, 0.08) !important;
    border-color: rgba(0, 73, 83, 0.3) !important;
    color: #000000 !important;
}

[data-theme="light"] .search-container {
    background: linear-gradient(135deg, rgba(0, 73, 83, 0.05) 0%, rgba(0, 0, 0, 0.05) 100%) !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .welcome-label {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .welcome-username {
    color: #000000 !important;
}

[data-theme="light"] .banner-title {
    color: #000000 !important;
}

[data-theme="light"] .banner-subtitle {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .category-name {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .product-name {
    color: #ffffff !important;
}

[data-theme="light"] .product-rating {
    color: rgba(255, 255, 255, 0.8) !important;
}

[data-theme="light"] .product-price {
    color: #ffffff !important;
}

[data-theme="light"] .product-store {
    color: rgba(255, 255, 255, 0.6) !important;
}

/* Search icon theme awareness */
.search-icon {
    color: var(--text-secondary) !important;
}

[data-theme="light"] .search-icon {
    color: rgba(0, 0, 0, 0.6) !important;
}

/* Person icon theme awareness */
.person-icon {
    color: var(--text-secondary) !important;
}

[data-theme="light"] .person-icon {
    color: rgba(0, 0, 0, 0.7) !important;
}

/* Light theme button overrides for home page */
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

/* Featured Categories Styling */
.featured-category-card {
    transition: all 0.3s ease;
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
}

.featured-category-card:hover {
    transform: translateY(-3px) !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
}

.featured-category-card .badge {
    font-size: 0.7rem !important;
    padding: 0.25rem 0.5rem !important;
}

/* Featured section title styling */
.featured-section-title {
    font-size: 1.1rem !important;
    font-weight: 600 !important;
    color: var(--text-primary) !important;
}

[data-theme="light"] .featured-section-title {
    color: #000000 !important;
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

<!-- Search Bar -->
<div class="search-container">
    <form action="{{ route('search') }}" method="GET" class="d-flex gap-2">
        <div class="flex-grow-1 position-relative">
            <input type="text" 
                   name="search" 
                   class="form-control search-input" 
                   placeholder="Search for products, categories, or stores..." 
                   value="{{ $search ?? '' }}"
                   autocomplete="off">
            <div class="position-absolute top-50 end-0 translate-middle-y pe-3">
                <i class="bi bi-search search-icon opacity-50"></i>
            </div>
        </div>
        <button type="submit" class="btn search-btn">
            <i class="bi bi-search me-1"></i>Search
        </button>
    </form>
</div>

<!-- Banner/Featured Section -->
@php
    $featuredCategories = $categories->where('is_featured', true)->whereNotNull('image_path');
    $bannerCategories = $featuredCategories->take(3);
    $hasFeatured = $bannerCategories->count() >= 3;
@endphp

@if($hasFeatured)
<!-- Featured Categories Banner -->
<div class="row gx-2 mb-3">
    <div class="col-7">
        <div class="card adminuiux-card h-100 p-0 overflow-hidden position-relative">
            <img src="{{ asset('storage/' . $bannerCategories[0]->image_path) }}" class="w-100 h-100 object-fit-cover" style="min-height: 160px; max-height: 200px;" alt="{{ $bannerCategories[0]->name }}">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3" style="background:rgba(0,0,0,0.4);">
                <!-- Featured Badge -->
                <div class="position-absolute top-0 end-0 m-2">
                    <span class="badge bg-warning text-dark">
                        <i class="fas fa-star me-1"></i>Featured
                    </span>
                </div>
                <h5 class="banner-title mb-1">{{ $bannerCategories[0]->name }}</h5>
                <p class="banner-subtitle mb-2">{{ $bannerCategories[0]->description ?: 'Best gifts and collections' }}</p>
                <a href="{{ route('categories.show', $bannerCategories[0]) }}" class="btn btn-sm btn-theme">Shop Now</a>
            </div>
        </div>
    </div>
    <div class="col-5 d-flex flex-column gap-2">
        <a href="{{ route('categories.show', $bannerCategories[1]) }}" class="text-decoration-none">
            <div class="card adminuiux-card p-0 overflow-hidden position-relative flex-fill">
                <img src="{{ asset('storage/' . $bannerCategories[1]->image_path) }}" class="w-100 h-100 object-fit-cover" style="min-height: 75px; max-height: 90px;" alt="{{ $bannerCategories[1]->name }}">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-2" style="background:rgba(0,0,0,0.3);">
                    <!-- Featured Badge -->
                    <div class="position-absolute top-0 end-0 m-1">
                        <span class="badge bg-warning text-dark" style="font-size: 0.6rem;">
                            <i class="fas fa-star me-1"></i>Featured
                        </span>
                    </div>
                    <h6 class="banner-title mb-1">{{ $bannerCategories[1]->name }}</h6>
                </div>
            </div>
        </a>
        <a href="{{ route('categories.show', $bannerCategories[2]) }}" class="text-decoration-none">
            <div class="card adminuiux-card p-0 overflow-hidden position-relative flex-fill">
                <img src="{{ asset('storage/' . $bannerCategories[2]->image_path) }}" class="w-100 h-100 object-fit-cover" style="min-height: 75px; max-height: 90px;" alt="{{ $bannerCategories[2]->name }}">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-2" style="background:rgba(0,0,0,0.3);">
                    <!-- Featured Badge -->
                    <div class="position-absolute top-0 end-0 m-1">
                        <span class="badge bg-warning text-dark" style="font-size: 0.6rem;">
                            <i class="fas fa-star me-1"></i>Featured
                        </span>
                    </div>
                    <h6 class="banner-title mb-1">{{ $bannerCategories[2]->name }}</h6>
                </div>
            </div>
        </a>
    </div>
</div>
@elseif($categories->whereNotNull('image_path')->count() >= 3)
<!-- Regular Categories with Images -->
@php
    $categoriesWithImages = $categories->whereNotNull('image_path')->take(3);
@endphp
<div class="row gx-2 mb-3">
    <div class="col-7">
        <div class="card adminuiux-card h-100 p-0 overflow-hidden position-relative">
            <img src="{{ asset('storage/' . $categoriesWithImages->get(0)->image_path) }}" class="w-100 h-100 object-fit-cover" style="min-height: 160px; max-height: 200px;" alt="{{ $categoriesWithImages->get(0)->name }}">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3" style="background:rgba(0,0,0,0.4);">
                <h5 class="banner-title mb-1">{{ $categoriesWithImages->get(0)->name }}</h5>
                <p class="banner-subtitle mb-2">{{ $categoriesWithImages->get(0)->description ?: 'Best gifts and collections' }}</p>
                <a href="{{ route('categories.show', $categoriesWithImages->get(0)) }}" class="btn btn-sm btn-theme">Shop Now</a>
            </div>
        </div>
    </div>
    <div class="col-5 d-flex flex-column gap-2">
        @if($categoriesWithImages->get(1))
        <a href="{{ route('categories.show', $categoriesWithImages->get(1)) }}" class="text-decoration-none">
            <div class="card adminuiux-card p-0 overflow-hidden position-relative flex-fill">
                <img src="{{ asset('storage/' . $categoriesWithImages->get(1)->image_path) }}" class="w-100 h-100 object-fit-cover" style="min-height: 75px; max-height: 90px;" alt="{{ $categoriesWithImages->get(1)->name }}">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-2" style="background:rgba(0,0,0,0.3);">
                    <h6 class="banner-title mb-1">{{ $categoriesWithImages->get(1)->name }}</h6>
                </div>
            </div>
        </a>
        @endif
        @if($categoriesWithImages->get(2))
        <a href="{{ route('categories.show', $categoriesWithImages->get(2)) }}" class="text-decoration-none">
            <div class="card adminuiux-card p-0 overflow-hidden position-relative flex-fill">
                <img src="{{ asset('storage/' . $categoriesWithImages->get(2)->image_path) }}" class="w-100 h-100 object-fit-cover" style="min-height: 75px; max-height: 90px;" alt="{{ $categoriesWithImages->get(2)->name }}">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-2" style="background:rgba(0,0,0,0.3);">
                    <h6 class="banner-title mb-1">{{ $categoriesWithImages->get(2)->name }}</h6>
                </div>
            </div>
        </a>
        @endif
        @if(!$categoriesWithImages->get(1) || !$categoriesWithImages->get(2))
        <!-- Fill empty space if missing categories -->
        @if(!$categoriesWithImages->get(1))
        <a href="{{ route('categories.index') }}" class="text-decoration-none">
            <div class="card adminuiux-card p-0 overflow-hidden position-relative flex-fill">
                <img src="{{ asset('template-assets/img/ecommerce/image-4.jpg') }}" class="w-100 h-100 object-fit-cover" style="min-height: 75px; max-height: 90px;" alt="All Categories">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-2" style="background:rgba(0,0,0,0.3);">
                    <h6 class="banner-title mb-1">All Categories</h6>
                </div>
            </div>
        </a>
        @endif
        @if(!$categoriesWithImages->get(2))
        <a href="{{ route('products.index') }}" class="text-decoration-none">
            <div class="card adminuiux-card p-0 overflow-hidden position-relative flex-fill">
                <img src="{{ asset('template-assets/img/ecommerce/image-5.jpg') }}" class="w-100 h-100 object-fit-cover" style="min-height: 75px; max-height: 90px;" alt="All Products">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-2" style="background:rgba(0,0,0,0.3);">
                    <h6 class="banner-title mb-1">All Products</h6>
                </div>
            </div>
        </a>
        @endif
        @endif
    </div>
</div>
@else
<!-- Dynamic Fallback Banner Section -->
@php
    $availableCategories = $categories->whereNotNull('image_path')->take(3);
    $hasCategories = $availableCategories->count() > 0;
@endphp

@if($hasCategories && $availableCategories->get(0))
<!-- Dynamic Banner with Available Categories -->
<div class="row gx-2 mb-3">
    <div class="col-7">
        <div class="card adminuiux-card h-100 p-0 overflow-hidden position-relative">
            <img src="{{ asset('storage/' . $availableCategories->get(0)->image_path) }}" class="w-100 h-100 object-fit-cover" style="min-height: 160px; max-height: 200px;" alt="{{ $availableCategories->get(0)->name }}">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3" style="background:rgba(0,0,0,0.4);">
                <h5 class="banner-title mb-1">{{ $availableCategories->get(0)->name }}</h5>
                <p class="banner-subtitle mb-2">{{ $availableCategories->get(0)->description ?: 'Best gifts and collections' }}</p>
                <a href="{{ route('categories.show', $availableCategories->get(0)) }}" class="btn btn-sm btn-theme">Shop Now</a>
            </div>
        </div>
    </div>
    <div class="col-5 d-flex flex-column gap-2">
        @if($availableCategories->count() > 1 && $availableCategories->get(1))
        <a href="{{ route('categories.show', $availableCategories->get(1)) }}" class="text-decoration-none">
            <div class="card adminuiux-card p-0 overflow-hidden position-relative flex-fill">
                <img src="{{ asset('storage/' . $availableCategories->get(1)->image_path) }}" class="w-100 h-100 object-fit-cover" style="min-height: 75px; max-height: 90px;" alt="{{ $availableCategories->get(1)->name }}">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-2" style="background:rgba(0,0,0,0.3);">
                    <h6 class="banner-title mb-1">{{ $availableCategories->get(1)->name }}</h6>
                </div>
            </div>
        </a>
        @endif
        @if($availableCategories->count() > 2 && $availableCategories->get(2))
        <a href="{{ route('categories.show', $availableCategories->get(2)) }}" class="text-decoration-none">
            <div class="card adminuiux-card p-0 overflow-hidden position-relative flex-fill">
                <img src="{{ asset('storage/' . $availableCategories->get(2)->image_path) }}" class="w-100 h-100 object-fit-cover" style="min-height: 75px; max-height: 90px;" alt="{{ $availableCategories->get(2)->name }}">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-2" style="background:rgba(0,0,0,0.3);">
                    <h6 class="banner-title mb-1">{{ $availableCategories->get(2)->name }}</h6>
                </div>
            </div>
        </a>
        @endif
        @if($availableCategories->count() <= 1)
        <!-- Fill empty space if only 1 category -->
        <a href="{{ route('categories.index') }}" class="text-decoration-none">
            <div class="card adminuiux-card p-0 overflow-hidden position-relative flex-fill">
                <img src="{{ asset('template-assets/img/ecommerce/image-4.jpg') }}" class="w-100 h-100 object-fit-cover" style="min-height: 75px; max-height: 90px;" alt="All Categories">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-2" style="background:rgba(0,0,0,0.3);">
                    <h6 class="banner-title mb-1">All Categories</h6>
                </div>
            </div>
        </a>
        <a href="{{ route('products.index') }}" class="text-decoration-none">
            <div class="card adminuiux-card p-0 overflow-hidden position-relative flex-fill">
                <img src="{{ asset('template-assets/img/ecommerce/image-5.jpg') }}" class="w-100 h-100 object-fit-cover" style="min-height: 75px; max-height: 90px;" alt="All Products">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-2" style="background:rgba(0,0,0,0.3);">
                    <h6 class="banner-title mb-1">All Products</h6>
                </div>
            </div>
        </a>
        @endif
    </div>
</div>
@else
<!-- Generic Fallback Banner Section -->
<div class="row gx-2 mb-3">
    <div class="col-7">
        <div class="card adminuiux-card h-100 p-0 overflow-hidden position-relative">
            <img src="{{ asset('template-assets/img/ecommerce/image-3.jpg') }}" class="w-100 h-100 object-fit-cover" style="min-height: 160px; max-height: 200px;" alt="Welcome">
            <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-3" style="background:rgba(0,0,0,0.4);">
                <h5 class="banner-title mb-1">Welcome to Bublemart</h5>
                <p class="banner-subtitle mb-2">Discover amazing gifts and collections</p>
                <a href="{{ route('categories.index') }}" class="btn btn-sm btn-theme">Explore Now</a>
            </div>
        </div>
    </div>
    <div class="col-5 d-flex flex-column gap-2">
        <a href="{{ route('categories.index') }}" class="text-decoration-none">
            <div class="card adminuiux-card p-0 overflow-hidden position-relative flex-fill">
                <img src="{{ asset('template-assets/img/ecommerce/image-4.jpg') }}" class="w-100 h-100 object-fit-cover" style="min-height: 75px; max-height: 90px;" alt="Categories">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-2" style="background:rgba(0,0,0,0.3);">
                    <h6 class="banner-title mb-1">Categories</h6>
                </div>
            </div>
        </a>
        <a href="{{ route('products.index') }}" class="text-decoration-none">
            <div class="card adminuiux-card p-0 overflow-hidden position-relative flex-fill">
                <img src="{{ asset('template-assets/img/ecommerce/image-5.jpg') }}" class="w-100 h-100 object-fit-cover" style="min-height: 75px; max-height: 90px;" alt="Products">
                <div class="position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-end p-2" style="background:rgba(0,0,0,0.3);">
                    <h6 class="banner-title mb-1">Products</h6>
                </div>
            </div>
        </a>
    </div>
</div>
@endif
@endif



<!-- All Categories Swiper -->
<div class="swiper swipernav mb-3">
    <div class="swiper-wrapper">
        @foreach($categories as $category)
        <a href="{{ route('categories.show', $category) }}" class="swiper-slide w-auto style-none" style="margin-right: 20px;">
            <div class="card adminuiux-card">
                <div class="row gx-0">
                    <div class="col-auto">
                        <div class="avatar avatar-40 rounded" style="background-color: #004953;">
                            @if(str_contains(strtolower($category->name), 'flower'))
                                <i class="bi bi-flower1 h4 text-white"></i>
                            @elseif(str_contains(strtolower($category->name), 'food') || str_contains(strtolower($category->name), 'dining'))
                                <i class="bi bi-cup-straw h4 text-white"></i>
                            @elseif(str_contains(strtolower($category->name), 'jewelry'))
                                <i class="bi bi-gem h4 text-white"></i>
                            @elseif(str_contains(strtolower($category->name), 'electronics') || str_contains(strtolower($category->name), 'smartphone') || str_contains(strtolower($category->name), 'laptop') || str_contains(strtolower($category->name), 'headphone'))
                                <i class="bi bi-phone h4 text-white"></i>
                            @elseif(str_contains(strtolower($category->name), 'fashion') || str_contains(strtolower($category->name), 'wear') || str_contains(strtolower($category->name), 'shirt') || str_contains(strtolower($category->name), 'hoodie') || str_contains(strtolower($category->name), 'dress') || str_contains(strtolower($category->name), 'jean') || str_contains(strtolower($category->name), 'shoe'))
                                <i class="bi bi-shirt h4 text-white"></i>
                            @elseif(str_contains(strtolower($category->name), 'home') || str_contains(strtolower($category->name), 'garden') || str_contains(strtolower($category->name), 'living') || str_contains(strtolower($category->name), 'furniture') || str_contains(strtolower($category->name), 'decor') || str_contains(strtolower($category->name), 'kitchen'))
                                <i class="bi bi-house h4 text-white"></i>
                            @elseif(str_contains(strtolower($category->name), 'book') || str_contains(strtolower($category->name), 'media'))
                                <i class="bi bi-journal-text h4 text-white"></i>
                            @elseif(str_contains(strtolower($category->name), 'sport') || str_contains(strtolower($category->name), 'outdoor'))
                                <i class="bi bi-trophy h4 text-white"></i>
                            @elseif(str_contains(strtolower($category->name), 'frame'))
                                <i class="bi bi-image h4 text-white"></i>
                            @elseif(str_contains(strtolower($category->name), 'drinkware') || str_contains(strtolower($category->name), 'mug') || str_contains(strtolower($category->name), 'cup'))
                                <i class="bi bi-cup-hot h4 text-white"></i>
                            @elseif(str_contains(strtolower($category->name), 'card'))
                                <i class="bi bi-card-text h4 text-white"></i>
                            @elseif(str_contains(strtolower($category->name), 'watch'))
                                <i class="bi bi-clock h4 text-white"></i>
                            @elseif(str_contains(strtolower($category->name), 'accessory'))
                                <i class="bi bi-bag h4 text-white"></i>
                            @else
                                <i class="bi bi-gift h4 text-white"></i>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body py-2">
                            <p class="category-name text-truncated mb-0">{{ $category->name }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
        <a href="{{ route('categories.index') }}" class="swiper-slide w-auto style-none" style="margin-right: 20px;">
            <div class="card adminuiux-card">
                <div class="row gx-0">
                    <div class="col-auto">
                        <div class="avatar avatar-40 rounded" style="background-color: #004953;">
                            <i class="bi bi-tags h4 text-white"></i>
                        </div>
                    </div>
                    <div class="col">
                        <div class="card-body py-2">
                            <p class="category-name text-truncated mb-0">All Categories</p>
                        </div>
                    </div>
                </div>
            </div>
        </a>
    </div>
    <div class="swiper-pagination white-pagination text-left mb-3"></div>
</div>

<!-- Shop Items Section -->
<div class="row gx-2 gy-3">
    @foreach($products->take(6) as $product)
    <div class="col-6">
        <div class="card adminuiux-card home-product-card mb-2 position-relative" style="border-radius: 20px; min-height: 200px; background-image: url('{{ \App\Helpers\StorageHelper::getProductImageUrl($product) }}') !important; background-size: cover !important; background-position: center !important; background-repeat: no-repeat !important;">
            <!-- Overlay for better text readability -->
            <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.7) 100%); border-radius: 20px;"></div>
            
            <!-- Action buttons -->
            <div class="position-absolute top-0 end-0 m-2">
                <i class="bi bi-heart text-white" style="text-shadow: 0 1px 3px rgba(0,0,0,0.5);"></i>
            </div>
            <form action="{{ route('cart.add', $product->id) }}" method="POST" class="position-absolute top-0 start-0 m-2">
                @csrf
                <button type="submit" class="btn btn-sm btn-theme-accent-1 rounded-circle" style="width: 32px; height: 32px; padding: 0; box-shadow: 0 2px 8px rgba(0,0,0,0.3);">
                    <i class="bi bi-cart-plus text-white" style="font-size: 0.8rem;"></i>
                </button>
            </form>
            
            <!-- Product info overlay -->
            <div class="position-absolute bottom-0 start-0 w-100 p-3" style="border-radius: 0 0 20px 20px;">
                <a href="{{ route('products.show', $product) }}" class="style-none">
                    <h6 class="product-name text-truncated mb-1" style="text-shadow: 0 1px 3px rgba(0,0,0,0.7);">{{ $product->name }}</h6>
                </a>
                <div class="d-flex align-items-center mb-1">
                    <span class="me-1 product-rating" style="text-shadow: 0 1px 2px rgba(0,0,0,0.7);"><i class="bi bi-star-fill text-warning"></i> {{ number_format($product->rating ?? 4.5, 1) }}</span>
                    <span class="product-rating" style="text-shadow: 0 1px 2px rgba(0,0,0,0.7);">({{ $product->reviews_count ?? rand(10, 50) }})</span>
                </div>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="product-price" style="text-shadow: 0 1px 3px rgba(0,0,0,0.7);">₦{{ number_format(round($product->price_naira / 100) * 100) }}</span>
                    <span class="product-store" style="text-shadow: 0 1px 2px rgba(0,0,0,0.7);">{{ $product->store->name ?? 'Bubblemart Store' }}</span>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection

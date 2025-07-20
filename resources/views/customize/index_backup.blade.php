@extends('layouts.template')

@section('content')
<!-- breadcrumb -->
<div class="container mt-3">
    <div class="row gx-1 align-items-center">
        <div class="col col-sm mb-3 mb-md-0">
            <nav aria-label="breadcrumb" class="mb-1">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item bi"><a href="{{ route('home') }}"><i class="bi bi-house-door"></i> Home</a></li>
                    <li class="breadcrumb-item active bi" aria-current="page">Customize Gift</li>
                </ol>
            </nav>
            <h5>Customize Your Gift</h5>
        </div>
        <div class="col-auto mb-3 mb-md-0">
            <a href="{{ route('home') }}" class="btn btn-square btn-outline-secondary"><i class="bi bi-arrow-left"></i></a>
        </div>
    </div>
</div>

<!-- content -->
<div class="container mt-3 mt-lg-4 mt-xl-5" id="main-content">
    <!-- welcome section -->
    <div class="row gx-3 mb-4">
        <div class="col-12">
            <div class="card bg-none mb-3 mb-lg-4">
                <div class="card-body text-center">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-auto mb-3 mb-lg-4">
                            <div class="avatar avatar-120 rounded bg-theme-accent-1 d-flex align-items-center justify-content-center mx-auto">
                                <i class="bi bi-gift h1 text-white"></i>
                            </div>
                        </div>
                        <div class="col mb-3 mb-lg-4">
                            <h4 class="fw-bold text-theme-accent-1 mb-0">Customize Your Perfect Gift</h4>
                            <p class="mb-2 text-truncated">Follow these steps to create a personalized gift</p>
                            <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;"">Choose from our curated categories and make it special</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Progress Steps -->
    <div class="row gx-3 mb-4">
        <div class="col-12">
            <div class="card adminuiux-card">
                <div class="card-body">
                    <div class="row gx-3">
                        <div class="col-6 col-md-3 mb-3">
                            <div class="progress-step active text-center">
                                <div class="avatar avatar-50 rounded bg-theme-accent-1 mx-auto mb-2">
                                    <span class="text-white fw-bold" style="font-size: 0.85rem !important; font-weight: 600 !important; color: #ffffff !important;"">1</span>
                                </div>
                                <h6 class="mb-1 text-theme-accent-1">Select Category</h6>
                                <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" mb-0">Choose your gift type</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="progress-step text-center">
                                <div class="avatar avatar-50 rounded bg-secondary mx-auto mb-2">
                                    <span class="text-white fw-bold" style="font-size: 0.85rem !important; font-weight: 600 !important; color: #ffffff !important;"">2</span>
                                </div>
                                <h6 class="mb-1 text-secondary">Choose Item</h6>
                                <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" mb-0">Pick your favorite</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="progress-step text-center">
                                <div class="avatar avatar-50 rounded bg-secondary mx-auto mb-2">
                                    <span class="text-white fw-bold" style="font-size: 0.85rem !important; font-weight: 600 !important; color: #ffffff !important;"">3</span>
                                </div>
                                <h6 class="mb-1 text-secondary">Customize</h6>
                                <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" mb-0">Make it personal</p>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-3">
                            <div class="progress-step text-center">
                                <div class="avatar avatar-50 rounded bg-secondary mx-auto mb-2">
                                    <span class="text-white fw-bold" style="font-size: 0.85rem !important; font-weight: 600 !important; color: #ffffff !important;"">4</span>
                                </div>
                                <h6 class="mb-1 text-secondary">Checkout</h6>
                                <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" mb-0">Complete order</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Categories -->
    <div class="row gx-3">
        <div class="col-12">
            <div class="card adminuiux-card">
                <div class="card-header">
                    <h6 class="mb-0"><i class="bi bi-tags me-2"></i>Step 1: Select a Category</h6>
                </div>
                <div class="card-body">
                    <div class="row gx-3">
                        @foreach($categories as $category)
                        <div class="col-12 col-md-6 col-lg-4 mb-3">
                            <a href="{{ route('customize.category', $category->slug) }}" class="text-decoration-none">
                                <div class="card adminuiux-card category-card h-100 text-center border-0">
                                    <div class="card-body">
                                        <div class="avatar avatar-80 rounded bg-light mb-3 mx-auto category-icon">
                                            @if($category->image)
                                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-100 h-100 object-fit-cover rounded">
                                            @else
                                                <i class="bi bi-tag h2 text-theme-accent-1"></i>
                                            @endif
                                        </div>
                                        <h6 class="card-title text-theme-1 mb-2">{{ $category->name }}</h6>
                                        <p class="card-text text-secondary small mb-0">{{ $category->description }}</p>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Info -->
    <div class="row gx-3 mt-4">
        <div class="col-12 col-md-4">
            <div class="card adminuiux-card text-center">
                <div class="card-body">
                    <div class="avatar avatar-60 rounded bg-success mb-3 mx-auto">
                        <i class="bi bi-shield-check h2 text-white"></i>
                    </div>
                    <h6 class="mb-2">Secure Shopping</h6>
                    <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" mb-0">Safe and protected transactions</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card adminuiux-card text-center">
                <div class="card-body">
                    <div class="avatar avatar-60 rounded bg-primary mb-3 mx-auto">
                        <i class="bi bi-truck h2 text-white"></i>
                    </div>
                    <h6 class="mb-2">Fast Delivery</h6>
                    <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" mb-0">Quick and reliable shipping</p>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card adminuiux-card text-center">
                <div class="card-body">
                    <div class="avatar avatar-60 rounded bg-warning mb-3 mx-auto">
                        <i class="bi bi-heart h2 text-white"></i>
                    </div>
                    <h6 class="mb-2">Quality Gifts</h6>
                    <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" mb-0">Curated selection of premium items</p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.category-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3) !important;
    border-color: var(--dark-accent) !important;
}

.category-icon {
    transition: transform 0.3s ease;
}

.category-card:hover .category-icon {
    transform: scale(1.1);
}

.progress-step {
    transition: all 0.3s ease;
}

.progress-step.active .avatar {
    background: var(--dark-accent) !important;
}

.progress-step.active h6 {
    color: var(--dark-accent) !important;
}
</style>
@endsection 
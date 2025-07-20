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

/* Customization type cards specific styling */
.customization-type-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.22) 0%,rgb(0, 0, 0) 100%) !important;
}

.customization-type-card:hover {
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

/* Font sizes and weights matching wallet page */
.page-title {
    font-size: 0.95rem !important;
    font-weight: 600 !important;
    color: #ffffff !important;
}

.page-subtitle {
    font-size: 0.75rem !important;
    color: rgba(255,255,255,0.6) !important;
    font-weight: normal !important;
}

.customization-type-title {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: #ffffff !important;
}

.customization-type-description {
    font-size: 0.75rem !important;
    color: rgba(255,255,255,0.7) !important;
    font-weight: normal !important;
}

.progress-step-title {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: #ffffff !important;
}

.progress-step-label {
    font-size: 0.75rem !important;
    color: rgba(255,255,255,0.6) !important;
    font-weight: normal !important;
}

.progress-step-number {
    font-size: 0.85rem !important;
    font-weight: 600 !important;
    color: #ffffff !important;
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
}.info-card {
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.22) 0%,rgb(0, 0, 0) 100%) !important;
}
</style>
<div class="row justify-content-center mb-3">
    <div class="col-12 col-md-8">
        <!-- Progress Steps -->
        <div class="row gx-2 mb-3">
            <div class="col-3">
                <div class="progress-step completed text-center">
                    <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                        <i class="bi bi-check text-white"></i>
                    </div>
                    <h6 class="mb-1 text-theme-accent-1">Category</h6>
                    <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" class="mb-0">Selected</p>
                </div>
            </div>
            <div class="col-3">
                <div class="progress-step completed text-center">
                    <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                        <i class="bi bi-check text-white"></i>
                    </div>
                    <h6 class="mb-1 text-theme-accent-1">Product</h6>
                    <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" class="mb-0">Selected</p>
                </div>
            </div>
            <div class="col-3">
                <div class="progress-step completed text-center">
                    <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                        <i class="bi bi-check text-white"></i>
                    </div>
                    <h6 class="mb-1 text-theme-accent-1">Address</h6>
                    <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" class="mb-0">Completed</p>
                </div>
            </div>
            <div class="col-3">
                <div class="progress-step active text-center">
                    <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                        <span class="text-white fw-bold" style="font-size: 0.85rem !important; font-weight: 600 !important; color: #ffffff !important;">4</span>
                    </div>
                    <h6 class="mb-1 text-theme-accent-1">Type</h6>
                    <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" class="mb-0">Current</p>
                </div>
            </div>
        </div>

        <!-- Selected Product Card -->
        <div class="card adminuiux-card header-card mb-3">
            <div class="card-body">
                <h6 class="fw-bold text-theme-1" style="font-size: 0.85rem !important; font-weight: 500 !important; color: #ffffff !important;" class="mb-2">Selected Product</h6>
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="avatar avatar-50 rounded">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <i class="bi bi-gift h4 text-theme-accent-1"></i>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <h6 class="mb-1 text-theme-1">{{ $product->name }}</h6>
                        <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" class="mb-0">{{ Str::limit($product->description, 80) }}</p>
                    </div>
                    <div class="col-auto text-end">
                        <span class="fw-bold text-theme-accent-1" style="font-size: 0.95rem !important; font-weight: 600 !important; color: #ffffff !important;">₦{{ number_format($product->price_naira) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customization Types -->
        <div class="card adminuiux-card">
            <div class="card-body">
                <h5 class="fw-bold text-theme-1" style="font-size: 0.95rem !important; font-weight: 600 !important; color: #ffffff !important;" mb-3 text-center">Step 3: Choose Customization Type</h5>
                
                <div class="row gx-2 gy-3">
                    @foreach($customizationTypes as $type => $info)
                    <div class="col-12 col-md-6">
                        <a href="{{ route('customize.form', $product->slug) }}?type={{ $type }}" class="text-decoration-none">
                            <div class="card adminuiux-card h-100 customization-type-card">
                                <div class="card-body text-center p-3">
                                    <div class="mb-3">
                                        <div class="avatar avatar-60 rounded bg-theme-accent-1 mx-auto d-flex align-items-center justify-content-center">
                                            <i class="{{ $info['icon'] }} h3 text-white"></i>
                                        </div>
                                    </div>
                                    <h6 class="text-theme-1" style="font-size: 0.85rem !important; font-weight: 500 !important; color: #ffffff !important;" class="mb-2">{{ $info['name'] }}</h6>
                                    <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" class="mb-3">{{ $info['description'] }}</p>
                                    
                                    <div class="mb-3">
                                        <small class="text-secondary">
                                            <strong>Options:</strong> 
                                            @foreach($info['options'] as $option)
                                                <span class="badge bg-secondary me-1">{{ ucfirst($option) }}</span>
                                            @endforeach
                                        </small>
                                    </div>
                                    
                                    <div class="mt-3">
                                        <small class="text-theme-accent-1">
                                            <i class="bi bi-arrow-right me-1"></i>Choose {{ $info['name'] }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-3">
            <a href="{{ route('customize.category', $product->category->slug) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Products
            </a>
        </div>
    </div>
</div>

<style>
.customization-type-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.customization-type-card:hover {
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
a:hover .customization-type-card {
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.3) 0%,rgb(0, 0, 0) 100%) !important;
}
</style>
@endsection 
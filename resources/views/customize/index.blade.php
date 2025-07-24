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

/* Progress steps styling */
.progress-step {
    transition: all 0.3s ease;
}

.progress-step:hover {
    transform: translateY(-2px);
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

/* Light theme overrides */
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

/* Header card styling */
.header-card {
    background: linear-gradient(135deg,rgba(16, 17, 19, 0.44) 0%,rgb(0, 0, 0) 100%) !important;
}

/* Light theme header card styling */
[data-theme="light"] .header-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 35px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .header-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-2px);
}

/* Light theme header card avatar styling */
[data-theme="light"] .header-card .avatar {
    border-radius: 15px !important;
    background: #036674 !important;
    box-shadow: 0 4px 15px rgba(3, 102, 116, 0.3) !important;
}

[data-theme="light"] .header-card .avatar i {
    color: #ffffff !important;
}

/* Info card styling */
.info-card {
    background: linear-gradient(135deg,rgb(19, 16, 16) 0%,rgb(0, 0, 0) 100%) !important;
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

[data-theme="light"] .progress-step-title {
    color: #000000 !important;
}

[data-theme="light"] .progress-step-label {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .progress-step-number {
    color: #000000 !important;
}

/* Info card text theme awareness */
.info-card-title {
    color: var(--text-primary) !important;
}

[data-theme="light"] .info-card-title {
    color: #000000 !important;
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

/* Form styling */
.form-control {
    background: rgba(255,255,255,0.1) !important;
    border: 1px solid rgba(255,255,255,0.2) !important;
    color: #ffffff !important;
}

.form-control:focus {
    background: rgba(255,255,255,0.15) !important;
    border-color: #ff9800 !important;
    color: #ffffff !important;
    box-shadow: 0 0 0 0.2rem rgba(255,152,0,0.25) !important;
}

.form-control::placeholder {
    color: #b0b0b0 !important;
}

.input-group-text {
    background: rgba(255,255,255,0.1) !important;
    border: 1px solid rgba(255,255,255,0.2) !important;
    color: #b0b0b0 !important;
}

/* Select styling */
.form-select {
    background: rgba(255,255,255,0.1) !important;
    border: 1px solid rgba(255,255,255,0.2) !important;
    color: #ffffff !important;
}

.form-select:focus {
    background: rgba(255,255,255,0.15) !important;
    border-color: #ff9800 !important;
    color: #ffffff !important;
    box-shadow: 0 0 0 0.2rem rgba(255,152,0,0.25) !important;
}

/* Filter card styling */
.filter-card {
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
}

/* Badge styling for active filters */
.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

.bg-primary {
    background: rgba(0,123,255,0.8) !important;
    color: #ffffff !important;
}

.bg-info {
    background: rgba(23,162,184,0.8) !important;
    color: #ffffff !important;
}

.bg-secondary {
    background: rgba(108,117,125,0.8) !important;
    color: #ffffff !important;
}

/* Button styling */
.btn-theme {
    background: #004953 !important;
    border: none !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
}

.btn-theme:hover {
    background: #005a66 !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,73,83,0.3) !important;
}

.btn-outline-secondary {
    border: 1px solid #6c757d !important;
    color: #6c757d !important;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: #6c757d !important;
    border-color: #6c757d !important;
    color: #ffffff !important;
}
</style>
<div class="row justify-content-center mb-3">
    <div class="col-12 col-md-10">
        <!-- Header -->
        <div class="card adminuiux-card header-card mb-3">
            <div class="card-body text-center">
                <div class="avatar avatar-60 rounded bg-theme-accent-1 mx-auto mb-3 d-flex align-items-center justify-content-center">
                    <i class="bi bi-magic h2 text-black"></i>
                </div>
                <h4 class="page-title mb-2">Customize Your Gift</h4>
                <p class="page-subtitle mb-0">Choose a category and create something truly special!</p>
            </div>
        </div>

        <!-- Progress Steps -->
        <div class="row gx-2 mb-3">
            <div class="col-3">
                <div class="progress-step active text-center">
                    <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                        <span class="progress-step-number text-white">1</span>
                    </div>
                    <h6 class="progress-step-title mb-1">Category</h6>
                    <p class="progress-step-label mb-0">Current</p>
                </div>
            </div>
            <div class="col-3">
                <div class="progress-step text-center">
                    <div class="avatar avatar-40 rounded bg-secondary mx-auto mb-2">
                        <span class="progress-step-number text-white">2</span>
                    </div>
                    <h6 class="progress-step-title mb-1">Product</h6>
                    <p class="progress-step-label mb-0">Next</p>
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

        <!-- Categories Grid -->
        <div class="row gx-2 gy-3">
            @forelse($categories as $category)
                <div class="col-6 col-md-4 col-lg-3">
                    <a href="{{ route('customize.category', $category->slug) }}" class="text-decoration-none">
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
                                <p class="category-description mb-0">{{ $category->description ?? 'Custom gifts' }}</p>
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

        <!-- Info Card -->
        <div class="card adminuiux-card info-card mt-3">
            <div class="card-body">
                <h6 class="fw-bold info-card-title mb-2">
                    <i class="bi bi-info-circle me-2"></i>How It Works
                </h6>
                <div class="row gx-3">
                    <div class="col-6 col-md-3">
                        <div class="text-center">
                            <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2 d-flex align-items-center justify-content-center">
                                <span class="text-white fw-bold">1</span>
                            </div>
                            <small class="text-secondary">Choose Category</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center">
                            <div class="avatar avatar-40 rounded bg-secondary mx-auto mb-2 d-flex align-items-center justify-content-center">
                                <span class="text-white fw-bold">2</span>
                            </div>
                            <small class="text-secondary">Select Product</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center">
                            <div class="avatar avatar-40 rounded bg-secondary mx-auto mb-2 d-flex align-items-center justify-content-center">
                                <span class="text-white fw-bold">3</span>
                            </div>
                            <small class="text-secondary">Pick Type</small>
                        </div>
                    </div>
                    <div class="col-6 col-md-3">
                        <div class="text-center">
                            <div class="avatar avatar-40 rounded bg-secondary mx-auto mb-2 d-flex align-items-center justify-content-center">
                                <span class="text-white fw-bold">4</span>
                            </div>
                            <small class="text-secondary">Customize</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.category-card {
    transition: all 0.3s ease;
    cursor: pointer;
    position: relative;
}

.category-card:hover {
    transform: translateY(-3px);
    border-color: var(--dark-accent) !important;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3) !important;
}

.category-card::after {
    content: '';
    position: absolute;
    top: 10px;
    right: 10px;
    width: 8px;
    height: 8px;
    background: var(--dark-accent);
    border-radius: 50%;
    opacity: 0;
    transition: opacity 0.3s ease;
}

.category-card:hover::after {
    opacity: 1;
}

/* Ensure text colors remain consistent */
.category-card .text-theme-1 {
    color: #ffffff !important;
}

.category-card .text-secondary {
    color: #adb5bd !important;
}

/* Remove any link styling */
.category-card a {
    text-decoration: none;
    color: inherit;
}
</style>
@endsection 
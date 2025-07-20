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

/* Checkout cards specific styling */
.checkout-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.22) 0%,rgb(0, 0, 0) 100%) !important;
}

.checkout-card:hover {
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

.order-summary-title {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: #ffffff !important;
}

.order-summary-text {
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

/* Light theme success message styling */
[data-theme="light"] .header-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 12px !important;
}

[data-theme="light"] .header-card .card-body {
    border-radius: 12px !important;
}

[data-theme="light"] .success-title {
    color: #000000 !important;
    font-size: 0.95rem !important;
    font-weight: 600 !important;
}

[data-theme="light"] .success-subtitle {
    color: rgba(0, 0, 0, 0.7) !important;
    font-size: 0.75rem !important;
    font-weight: normal !important;
}

/* Light theme progress step avatars */
[data-theme="light"] .progress-step .avatar {
    background-color: #036674 !important;
}

[data-theme="light"] .progress-step.completed .avatar {
    background-color: #036674 !important;
}

/* Light theme checkout card styling - cleaner approach */
[data-theme="light"] .checkout-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 12px !important;
}

[data-theme="light"] .checkout-card .card-body {
    border-radius: 12px !important;
}

/* Light theme text colors for checkout cards */
[data-theme="light"] .checkout-card .text-theme-1 {
    color: #000000 !important;
}

[data-theme="light"] .checkout-card .text-secondary {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .checkout-card .text-theme-accent-1 {
    color: #036674 !important;
}

/* Light theme cost summary card - specific targeting */
[data-theme="light"] .card.bg-dark {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 12px !important;
}

[data-theme="light"] .card.bg-dark .card-body {
    border-radius: 12px !important;
}

[data-theme="light"] .card.bg-dark .text-theme-accent-1 {
    color: #036674 !important;
}

/* Light theme specific card headers */
[data-theme="light"] .checkout-card h6.fw-bold.text-theme-1 {
    background: #036674 !important;
    color: #ffffff !important;
    padding: 12px 16px !important;
    margin: -16px -16px 16px -16px !important;
    border-radius: 12px 12px 0 0 !important;
}

/* Light theme cost summary header */
[data-theme="light"] .card.bg-dark h6.fw-bold.text-theme-1 {
    background: #036674 !important;
    color: #ffffff !important;
    padding: 12px 16px !important;
    margin: -16px -16px 16px -16px !important;
    border-radius: 12px 12px 0 0 !important;
}

/* Light theme cost summary card styling */
[data-theme="light"] .card:not(.header-card):not(.checkout-card) {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 12px !important;
}

[data-theme="light"] .card:not(.header-card):not(.checkout-card) .card-body {
    border-radius: 12px !important;
}

[data-theme="light"] .card:not(.header-card):not(.checkout-card) h6.fw-bold.text-theme-1 {
    background: #036674 !important;
    color: #ffffff !important;
    padding: 12px 16px !important;
    margin: -16px -16px 16px -16px !important;
    border-radius: 12px 12px 0 0 !important;
}

[data-theme="light"] .card:not(.header-card):not(.checkout-card) .text-theme-accent-1 {
    color: #036674 !important;
}

/* Cost number styling for light theme */
[data-theme="light"] .cost-number {
    color: #036674 !important;
    font-size: 0.95rem !important;
    font-weight: 600 !important;
}

/* Dark theme cost number styling */
[data-theme="dark"] .cost-number {
    color: #ffffff !important;
    font-size: 0.95rem !important;
    font-weight: 600 !important;
}

/* Light theme button styling */
[data-theme="light"] .btn-theme {
    background: #036674 !important;
    border-color: #036674 !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-theme:hover {
    background: #025a66 !important;
    border-color: #025a66 !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-theme i {
    color: #ffffff !important;
}

[data-theme="light"] .btn-outline-theme {
    background: transparent !important;
    border-color: #036674 !important;
    color: #036674 !important;
}

[data-theme="light"] .btn-outline-theme:hover {
    background: #036674 !important;
    border-color: #036674 !important;
    color: #ffffff !important;
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
                    <h6 class="mb-1 text-theme-accent-1">Delivery</h6>
                    <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" class="mb-0">Completed</p>
                </div>
            </div>
            <div class="col-3">
                <div class="progress-step completed text-center">
                    <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                        <i class="bi bi-check text-white"></i>
                    </div>
                    <h6 class="mb-1 text-theme-accent-1">Customize</h6>
                    <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" class="mb-0">Completed</p>
                </div>
            </div>
        </div>

        <!-- Success Message -->
        <div class="card adminuiux-card header-card mb-3">
            <div class="card-body text-center">
                <div class="avatar avatar-60 rounded bg-success mx-auto mb-3 d-flex align-items-center justify-content-center">
                    <i class="bi bi-check-circle h2 text-white"></i>
                </div>
                <h5 class="fw-bold text-theme-1 success-title mb-2">Customization Created!</h5>
                <p class="text-secondary success-subtitle mb-0">Your personalized gift is ready for checkout.</p>
            </div>
        </div>

        <!-- Customization Details -->
        <div class="card adminuiux-card checkout-card mb-3">
            <div class="card-body">
                <h6 class="fw-bold text-theme-1" style="font-size: 0.85rem !important; font-weight: 500 !important; color: #ffffff !important;" class="mb-3">Customization Details</h6>
                
                <div class="row align-items-center mb-3">
                    <div class="col-auto">
                        <div class="avatar avatar-50 rounded">
                            @if($customization->product->image)
                                <img src="{{ asset('storage/' . $customization->product->image) }}" alt="{{ $customization->product->name }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <i class="bi bi-gift h4 text-theme-accent-1"></i>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <h6 class="mb-1 text-theme-1">{{ $customization->product->name }}</h6>
                        <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" class="mb-0">{{ $customization->product->description }}</p>
                    </div>
                    <div class="col-auto text-end">
                        <span class="fw-bold text-theme-accent-1" style="font-size: 0.95rem !important; font-weight: 600 !important; color: #ffffff !important;">₦{{ number_format($customization->product->price_naira) }}</span>
                    </div>
                </div>

                <div class="row gx-3">
                    <div class="col-6">
                        <div class="mb-2">
                            <small class="text-secondary">Customization Type:</small>
                            <p class="mb-0 fw-bold text-theme-1">{{ ucfirst($customization->type) }}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <small class="text-secondary">Status:</small>
                            <p class="mb-0">
                                <span class="badge bg-warning">{{ ucfirst($customization->status) }}</span>
                            </p>
                        </div>
                    </div>
                </div>

                @if($customization->message)
                <div class="mb-2">
                    <small class="text-secondary">Message:</small>
                    <p class="mb-0 text-theme-1">{{ $customization->message }}</p>
                </div>
                @endif

                @if($customization->media_path)
                <div class="mb-2">
                    <small class="text-secondary">Image:</small>
                    <p class="mb-0">
                        <img src="{{ asset('storage/' . $customization->media_path) }}" alt="Custom Image" class="rounded" style="max-width: 100px; max-height: 100px;">
                    </p>
                </div>
                @endif

                @if($customization->special_request)
                <div class="mb-2">
                    <small class="text-secondary">Special Request:</small>
                    <p class="mb-0 text-theme-1">{{ $customization->special_request }}</p>
                </div>
                @endif

                <!-- Product-specific details -->
                @if($customization->ring_size)
                <div class="mb-2">
                    <small class="text-secondary">Ring Size:</small>
                    <p class="mb-0 fw-bold text-theme-1">{{ $customization->ring_size }}</p>
                </div>
                @endif

                @if($customization->apparel_size)
                <div class="mb-2">
                    <small class="text-secondary">Size:</small>
                    <p class="mb-0 fw-bold text-theme-1">{{ $customization->apparel_size }}</p>
                </div>
                @endif

                @if($customization->frame_size)
                <div class="mb-2">
                    <small class="text-secondary">Frame Size:</small>
                    <p class="mb-0 fw-bold text-theme-1">{{ ucfirst($customization->frame_size) }}</p>
                </div>
                @endif

                @if($customization->cup_type)
                <div class="mb-2">
                    <small class="text-secondary">Cup Type:</small>
                    <p class="mb-0 fw-bold text-theme-1">{{ ucfirst(str_replace('_', ' ', $customization->cup_type)) }}</p>
                </div>
                @endif

                @if($customization->card_type)
                <div class="mb-2">
                    <small class="text-secondary">Card Type:</small>
                    <p class="mb-0 fw-bold text-theme-1">{{ ucfirst(str_replace('_', ' ', $customization->card_type)) }}</p>
                </div>
                @endif

                @if($customization->pillow_size)
                <div class="mb-2">
                    <small class="text-secondary">Pillow Size:</small>
                    <p class="mb-0 fw-bold text-theme-1">{{ ucfirst(str_replace('_', ' ', $customization->pillow_size)) }}</p>
                </div>
                @endif

                @if($customization->blanket_size)
                <div class="mb-2">
                    <small class="text-secondary">Blanket Size:</small>
                    <p class="mb-0 fw-bold text-theme-1">{{ ucfirst($customization->blanket_size) }}</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Delivery Information -->
        <div class="card adminuiux-card checkout-card mb-3">
            <div class="card-body">
                <h6 class="fw-bold text-theme-1" style="font-size: 0.85rem !important; font-weight: 500 !important; color: #ffffff !important;" class="mb-3">Delivery Information</h6>
                
                <div class="row gx-3">
                    <div class="col-6">
                        <div class="mb-2">
                            <small class="text-secondary">Sender:</small>
                            <p class="mb-0 fw-bold text-theme-1">{{ $customization->sender_name }}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <small class="text-secondary">Receiver:</small>
                            <p class="mb-0 fw-bold text-theme-1">{{ $customization->receiver_name }} ({{ ucfirst($customization->receiver_gender) }})</p>
                        </div>
                    </div>
                </div>

                <div class="mb-2">
                    <small class="text-secondary">Phone:</small>
                    <p class="mb-0 fw-bold text-theme-1">{{ $customization->receiver_phone }}</p>
                </div>

                <div class="mb-2">
                    <small class="text-secondary">Delivery Method:</small>
                    <p class="mb-0">
                        <span class="badge bg-theme-accent-1">{{ ucfirst(str_replace('_', ' ', $customization->delivery_method)) }}</span>
                    </p>
                </div>

                @if($customization->delivery_method === 'home_delivery')
                    <div class="mb-2">
                        <small class="text-secondary">Address:</small>
                        <p class="mb-0 text-theme-1">
                            {{ $customization->receiver_house_number }} {{ $customization->receiver_street }}<br>
                            {{ $customization->receiver_city }}, {{ $customization->receiver_state }} {{ $customization->receiver_zip }}
                        </p>
                    </div>
                @endif

                @if($customization->receiver_note)
                    <div class="mb-2">
                        <small class="text-secondary">Note:</small>
                        <p class="mb-0 text-theme-1">{{ $customization->receiver_note }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Cost Summary -->
        <div class="card adminuiux-card mb-3">
            <div class="card-body">
                <h6 class="fw-bold text-theme-1" style="font-size: 0.85rem !important; font-weight: 500 !important; color: #ffffff !important;" class="mb-3">Cost Summary</h6>
                
                <div class="row mb-2">
                    <div class="col-6">
                        <span class="text-secondary">Product Price:</span>
                    </div>
                    <div class="col-6 text-end">
                        <span class="fw-bold text-theme-accent-1 cost-number">₦{{ number_format($customization->product->price_naira) }}</span>
                    </div>
                </div>
                
                <div class="row mb-2">
                    <div class="col-6">
                        <span class="text-secondary">{{ ucfirst($customization->type) }} Cost:</span>
                    </div>
                    <div class="col-6 text-end">
                        <span class="fw-bold text-theme-accent-1 cost-number">₦{{ number_format($customization->additional_cost) }}</span>
                    </div>
                </div>
                
                <hr style="border-color: var(--dark-border);">
                
                <div class="row">
                    <div class="col-6">
                        <span class="fw-bold text-theme-1">Total:</span>
                    </div>
                    <div class="col-6 text-end">
                        <span class="fw-bold text-theme-accent-1 cost-number">₦{{ number_format($customization->product->price_naira + $customization->additional_cost) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="d-grid gap-2">
            <form action="{{ route('cart.add', $customization->product->id) }}" method="POST" class="d-inline">
                @csrf
                <input type="hidden" name="customization_id" value="{{ $customization->id }}">
                <button type="submit" class="btn btn-theme btn-lg w-100">
                    <i class="bi bi-cart-plus me-2"></i>Add to Cart
                </button>
            </form>
            <a href="{{ route('customize.index') }}" class="btn btn-outline-theme">
                <i class="bi bi-plus-circle me-2"></i>Create Another Customization
            </a>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-3">
            <a href="{{ route('customize.form', $customization->product->slug) }}?type={{ $customization->type }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Customization
            </a>
        </div>
    </div>
</div>
@endsection 
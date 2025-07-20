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

/* Form cards specific styling */
.form-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.22) 0%,rgb(0, 0, 0) 100%) !important;
}

.form-card:hover {
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
    color: var(--text-primary) !important;
}

.page-subtitle {
    font-size: 0.75rem !important;
    color: var(--text-secondary) !important;
    font-weight: normal !important;
}

.form-label {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: var(--text-primary) !important;
}

.form-text {
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

/* Light theme specific overrides */
[data-theme="light"] .page-title {
    color: #000000 !important;
}

[data-theme="light"] .page-subtitle {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .form-label {
    color: #000000 !important;
}

[data-theme="light"] .form-text {
    color: rgba(0, 0, 0, 0.6) !important;
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

/* Light theme header card styling - matching step 2 */
[data-theme="light"] .header-card {
    background: #ffffff !important;
    border-radius: 12px !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .header-card .card-body {
    border-radius: 12px !important;
}

[data-theme="light"] .header-card .page-title,
[data-theme="light"] .header-card h6,
[data-theme="light"] .header-card .text-theme-1 {
    color: #000000 !important;
}

[data-theme="light"] .header-card .page-subtitle,
[data-theme="light"] .header-card p,
[data-theme="light"] .header-card .text-secondary {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .header-card .text-theme-accent-1 {
    color: #036674 !important;
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

/* Light theme form card header styling */
[data-theme="light"] .form-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 12px !important;
}

[data-theme="light"] .form-card .card-body {
    border-radius: 12px !important;
}

[data-theme="light"] .form-card h5,
[data-theme="light"] .form-card .fw-bold.text-theme-1 {
    color: #000000 !important;
    background: #036674 !important;
    padding: 12px 16px !important;
    margin: -16px -16px 16px -16px !important;
    border-radius: 12px 12px 0 0 !important;
    color: #ffffff !important;
}

[data-theme="light"] .form-card .form-label {
    color: #000000 !important;
}

[data-theme="light"] .form-card .form-text {
    color: rgba(0, 0, 0, 0.7) !important;
}

/* Light theme cost summary styling */
[data-theme="light"] .card.bg-dark {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .card.bg-dark .card-title {
    color: #000000 !important;
}

[data-theme="light"] .card.bg-dark .text-theme-1 {
    color: #000000 !important;
}

[data-theme="light"] .card.bg-dark .text-theme-accent-1 {
    color: #036674 !important;
}

[data-theme="light"] .card.bg-dark .text-secondary {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .card.bg-dark p,
[data-theme="light"] .card.bg-dark .small {
    color: rgba(0, 0, 0, 0.8) !important;
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

/* Dark theme alert styling */
[data-theme="dark"] .alert-info {
    background: #ffc107 !important;
    border-color: #ffc107 !important;
    color: #000000 !important;
}

[data-theme="dark"] .alert-info strong {
    color: #000000 !important;
}

[data-theme="dark"] .alert-info i {
    color: #000000 !important;
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
            <div class="col-2">
                <div class="progress-step completed text-center">
                    <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                        <i class="bi bi-check text-white"></i>
                    </div>
                    <h6 class="progress-step-title mb-1">Category</h6>
                    <p class="progress-step-label mb-0">Selected</p>
                </div>
            </div>
            <div class="col-2">
                <div class="progress-step completed text-center">
                    <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                        <i class="bi bi-check text-white"></i>
                    </div>
                    <h6 class="progress-step-title mb-1">Product</h6>
                    <p class="progress-step-label mb-0">Selected</p>
                </div>
            </div>
            <div class="col-2">
                <div class="progress-step completed text-center">
                    <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                        <i class="bi bi-check text-white"></i>
                    </div>
                    <h6 class="progress-step-title mb-1">Address</h6>
                    <p class="progress-step-label mb-0">Completed</p>
                </div>
            </div>
            <div class="col-2">
                <div class="progress-step completed text-center">
                    <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                        <i class="bi bi-check text-white"></i>
                    </div>
                    <h6 class="progress-step-title mb-1">Type</h6>
                    <p class="progress-step-label mb-0">Completed</p>
                </div>
            </div>
            <div class="col-2">
                <div class="progress-step active text-center">
                    <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                        <span class="progress-step-number text-white">5</span>
                    </div>
                    <h6 class="progress-step-title mb-1">Customize</h6>
                    <p class="progress-step-label mb-0">Current</p>
                </div>
            </div>
        </div>

        <!-- Product Summary Card -->
        <div class="card adminuiux-card header-card mb-3">
            <div class="card-body">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <div class="avatar avatar-60 rounded">
                            @if($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-100 h-100 object-fit-cover">
                            @else
                                <i class="bi bi-gift h3 text-theme-accent-1"></i>
                            @endif
                        </div>
                    </div>
                    <div class="col">
                        <h6 class="mb-1 text-theme-1">{{ $product->name }}</h6>
                        <p class="small text-secondary" style="font-size: 0.75rem !important; color: rgba(255,255,255,0.6) !important; font-weight: normal !important;" class="mb-1">{{ $product->description }}</p>
                        <span class="badge bg-theme-accent-1">{{ ucfirst($type) }} Customization</span>
                        @if(isset($receiverInfo['delivery_method']))
                            <div class="mt-2">
                                <small class="text-info">
                                    <i class="bi bi-truck me-1"></i>
                                    {{ ucfirst(str_replace('_', ' ', $receiverInfo['delivery_method'])) }} - 
                                    {{ $receiverInfo['receiver_city'] ?? 'Address provided' }}
                                </small>
                            </div>
                        @endif
                    </div>
                    <div class="col-auto text-end">
                        <h6 class="mb-0 text-theme-accent-1">₦{{ number_format($product->price_naira) }}</h6>
                        <small class="text-secondary">Base Price</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customization Form -->
        <div class="card adminuiux-card form-card">
            <div class="card-body">
                <h5 class="fw-bold text-theme-1" style="font-size: 0.95rem !important; font-weight: 600 !important; color: #ffffff !important;" class="mb-3">Step 4: Add Your Personal Touch</h5>
                
                @if(isset($receiverInfo['delivery_method']))
                    <div class="alert alert-info mb-3" style="background: rgba(13, 202, 240, 0.1); border-color: var(--dark-accent);">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Delivery Method:</strong> {{ ucfirst(str_replace('_', ' ', $receiverInfo['delivery_method'])) }}
                        @if($receiverInfo['delivery_method'] === 'store_pickup')
                            - We'll use your address to find the closest store location for pickup.
                        @else
                            - Your order will be delivered to the address you provided.
                        @endif
                    </div>
                @endif
                
                <form action="{{ route('customize.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="customization_type" value="{{ $type }}">
                    
                    <!-- Product-Specific Options -->
                    @foreach($productOptions as $fieldName => $fieldConfig)
                        <div class="mb-3">
                            <label for="{{ $fieldName }}" class="form-label fw-bold">
                                <i class="bi bi-gear me-2"></i>{{ $fieldConfig['label'] }}
                                @if($fieldConfig['required'])
                                    <span class="text-danger">*</span>
                                @endif
                            </label>
                            @if($fieldConfig['type'] === 'select')
                                <select class="form-select" id="{{ $fieldName }}" name="{{ $fieldName }}" 
                                        @if($fieldConfig['required']) required @endif>
                                    <option value="">Select {{ $fieldConfig['label'] }}</option>
                                    @foreach($fieldConfig['options'] as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    @endforeach

                    <!-- Content Type Selection -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="bi bi-palette me-2"></i>Choose Content Type:
                        </label>
                        <div class="row gx-2">
                            @if($type === 'card')
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="content_type" id="message" value="message" checked>
                                        <label class="form-check-label" for="message">
                                            <i class="bi bi-chat me-2"></i>Personal Message
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="content_type" id="image" value="image">
                                        <label class="form-check-label" for="image">
                                            <i class="bi bi-image me-2"></i>Custom Image
                                        </label>
                                    </div>
                                </div>
                            @else
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="content_type" id="text" value="text" checked>
                                        <label class="form-check-label" for="text">
                                            <i class="bi bi-type me-2"></i>Custom Text
                                        </label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="content_type" id="image" value="image">
                                        <label class="form-check-label" for="image">
                                            <i class="bi bi-image me-2"></i>Custom Image
                                        </label>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Message/Text Input -->
                    <div class="mb-3" id="messageSection">
                        <label for="message" class="form-label fw-bold">
                            @if($type === 'card')
                                <i class="bi bi-envelope me-2"></i>Your Personal Message
                            @else
                                <i class="bi bi-type me-2"></i>Text to {{ ucfirst($type) }}
                            @endif
                        </label>
                        <textarea class="form-control" id="message" name="message" rows="3" 
                            placeholder="@if($type === 'card') Write your personal message here... @else Enter the text you want to {{ $type }}... @endif"></textarea>
                        <div class="form-text">
                            @if($type === 'card')
                                This message will be included with your gift card.
                            @else
                                This text will be {{ $type }}d directly on the gift.
                            @endif
                        </div>
                    </div>

                    <!-- Image Upload -->
                    <div class="mb-3" id="imageSection" style="display: none;">
                        <label for="image" class="form-label fw-bold">
                            <i class="bi bi-image me-2"></i>Upload Your Image
                        </label>
                        <div class="image-upload-container">
                            <input type="file" class="form-control" id="image" name="image" accept="image/*" onchange="previewImage(this)">
                            <div class="form-text">
                                @if($type === 'card')
                                    This image will be included with your gift card.
                                @else
                                    This image will be {{ $type }}d directly on the gift.
                                @endif
                                <br>Supported formats: JPG, PNG, GIF (Max: 5MB)
                            </div>
                            <div id="imagePreview" class="mt-2" style="display: none;">
                                <img id="previewImg" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; max-height: 200px;">
                                <button type="button" class="btn btn-sm btn-outline-danger mt-1" onclick="removeImage()">
                                    <i class="bi bi-trash me-1"></i>Remove Image
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Special Request -->
                    <div class="mb-3">
                        <label for="special_request" class="form-label fw-bold">
                            <i class="bi bi-star me-2"></i>Special Request (Optional)
                        </label>
                        <textarea class="form-control" id="special_request" name="special_request" rows="2" 
                            placeholder="Any special instructions or requests for your gift..."></textarea>
                        <div class="form-text">
                            Additional cost: ₦{{ number_format(2 * 1600, 2) }} for special requests
                        </div>
                    </div>

                    <!-- Cost Summary -->
                    <div class="card bg-dark mb-3" style="border: 1px solid var(--dark-border);">
                        <div class="card-body">
                            <h6 class="card-title text-theme-1">Cost Summary</h6>
                            <div class="row">
                                <div class="col-6">
                                    <p class="mb-1 small">Product: <span class="fw-bold text-theme-accent-1 cost-number">₦{{ number_format($product->price_naira) }}</span></p>
                                    <p class="mb-1 small">{{ ucfirst($type) }}: <span class="fw-bold text-theme-accent-1 cost-number">₦{{ number_format($customizationInfo['base_cost'] * 1600, 2) }}</span></p>
                                    <p class="mb-0 small">Special Request: <span class="fw-bold text-theme-accent-1 cost-number">₦{{ number_format(2 * 1600, 2) }}</span> <small class="text-secondary">(if added)</small></p>
                                </div>
                                <div class="col-6 text-end">
                                    <p class="mb-1">Estimated Total: <span class="fw-bold text-theme-accent-1 cost-number">₦{{ number_format(($product->price_naira + $customizationInfo['base_cost'] * 1600 + 2 * 1600), 2) }}</span></p>
                                    <small class="text-secondary">Final cost at checkout</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid">
                        @auth
                            <button type="submit" class="btn btn-theme btn-lg rounded-pill">
                                <i class="bi bi-cart-plus me-2"></i>Proceed to Checkout
                            </button>
                        @else
                            <div class="alert alert-info mb-3" style="background: rgba(255, 152, 0, 0.1); border-color: var(--dark-accent);">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Login Required:</strong> You need to be logged in to complete your customization.
                            </div>
                            <div class="d-grid gap-2">
                                <a href="{{ route('login') }}" class="btn btn-theme btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Login to Continue
                                </a>
                                <a href="{{ route('register') }}" class="btn btn-outline-theme btn-lg">
                                    <i class="bi bi-person-plus me-2"></i>Create Account
                                </a>
                            </div>
                        @endauth
                    </div>
                </form>
            </div>
        </div>

        <!-- Back Button -->
        <div class="text-center mt-3">
            <a href="{{ route('customize.product', $product->slug) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Back to Customization Types
            </a>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const messageRadio = document.getElementById('message');
    const imageRadio = document.getElementById('image');
    const textRadio = document.getElementById('text');
    const messageSection = document.getElementById('messageSection');
    const imageSection = document.getElementById('imageSection');

    function toggleSections() {
        console.log('Toggle sections called');
        if (messageRadio && messageRadio.checked) {
            messageSection.style.display = 'block';
            imageSection.style.display = 'none';
            console.log('Message section shown');
        } else if (imageRadio && imageRadio.checked) {
            messageSection.style.display = 'none';
            imageSection.style.display = 'block';
            console.log('Image section shown');
        } else if (textRadio && textRadio.checked) {
            messageSection.style.display = 'block';
            imageSection.style.display = 'none';
            console.log('Text section shown');
        }
    }

    // Add event listeners
    if (messageRadio) {
        messageRadio.addEventListener('change', toggleSections);
        console.log('Message radio listener added');
    }
    if (imageRadio) {
        imageRadio.addEventListener('change', toggleSections);
        console.log('Image radio listener added');
    }
    if (textRadio) {
        textRadio.addEventListener('change', toggleSections);
        console.log('Text radio listener added');
    }

    // Initial toggle
    toggleSections();
});

// Image preview functionality
function previewImage(input) {
    const preview = document.getElementById('imagePreview');
    const previewImg = document.getElementById('previewImg');
    
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            preview.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    } else {
        preview.style.display = 'none';
    }
}

function removeImage() {
    const input = document.getElementById('image');
    const preview = document.getElementById('imagePreview');
    
    input.value = '';
    preview.style.display = 'none';
}

// Form validation
document.querySelector('form').addEventListener('submit', function(e) {
    const contentType = document.querySelector('input[name="content_type"]:checked');
    const message = document.getElementById('message');
    const image = document.getElementById('image');
    
    if (contentType && contentType.value === 'image') {
        if (!image.files || image.files.length === 0) {
            e.preventDefault();
            alert('Please select an image to upload.');
            return false;
        }
    } else if (contentType && contentType.value === 'message') {
        if (!message.value.trim()) {
            e.preventDefault();
            alert('Please enter a message.');
            return false;
        }
    }
});
</script>
@endsection 
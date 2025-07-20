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
}

.info-card {
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.22) 0%,rgb(0, 0, 0) 100%) !important;
}

/* Form validation styles */
.form-control.is-invalid,
.form-select.is-invalid {
    border-color: #dc3545 !important;
    box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
    background-color: rgba(220, 53, 69, 0.1) !important;
}

.form-control.is-valid,
.form-select.is-valid {
    border-color: #198754 !important;
    box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.25) !important;
    background-color: rgba(25, 135, 84, 0.1) !important;
}

.invalid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.75rem;
    color: #dc3545 !important;
}

.valid-feedback {
    display: block;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.75rem;
    color: #198754 !important;
}

/* Alert styling for form errors */
.alert-danger {
    background: rgba(220, 53, 69, 0.1) !important;
    border-color: rgba(220, 53, 69, 0.3) !important;
    color: #dc3545 !important;
}

.alert-info {
    background: rgba(13, 202, 240, 0.1) !important;
    border-color: rgba(13, 202, 240, 0.3) !important;
    color: #0dcaf0 !important;
}

/* Focus states for better UX */
.form-control:focus,
.form-select:focus {
    border-color: #ff6b35 !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25) !important;
}

/* Autocomplete styling */
input[list] {
    background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m1 6 7 7 7-7'/%3e%3c/svg%3e");
    background-repeat: no-repeat;
    background-position: right 0.75rem center;
    background-size: 16px 12px;
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

/* Light theme card header styling */
[data-theme="light"] .header-card {
    background: #036674 !important;
}

[data-theme="light"] .form-card {
    background: #036674 !important;
}

[data-theme="light"] .info-card {
    background: #036674 !important;
}

/* Light theme card header text */
[data-theme="light"] .card-header h5 {
    color: #ffffff !important;
}

/* Card header styling for both themes */
.card-header {
    background: #036674 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1) !important;
}

.card-header h5 {
    color: #ffffff !important;
    margin: 0 !important;
}

/* Light theme specific card header adjustments */
[data-theme="light"] .card-header {
    background: #036674 !important;
    border-bottom: 1px solid rgba(255, 255, 255, 0.2) !important;
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
</style>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="d-flex align-items-center">
                    <a href="{{ route('customize.category', $product->category->slug) }}" class="btn btn-link text-decoration-none me-3">
                        <i class="bi bi-arrow-left fs-4 text-warning"></i>
                    </a>
                    <h1 class="h3 mb-0 page-title">Sender & Delivery Details</h1>
                </div>
                <div class="page-subtitle">
                    Step 3 of 4
                </div>
            </div>

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
                    <div class="progress-step completed text-center">
                        <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                            <i class="bi bi-check text-white"></i>
                        </div>
                        <h6 class="progress-step-title mb-1">Product</h6>
                        <p class="progress-step-label mb-0">Selected</p>
                    </div>
                </div>
                <div class="col-3">
                    <div class="progress-step active text-center">
                        <div class="avatar avatar-40 rounded bg-theme-accent-1 mx-auto mb-2">
                            <span class="progress-step-number text-white">3</span>
                        </div>
                        <h6 class="progress-step-title mb-1">Address</h6>
                        <p class="progress-step-label mb-0">Current</p>
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

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('customize.receiverInfoStore', $product->slug) }}" method="POST">
                @csrf
                
                <!-- Sender Information -->
                <div class="card adminuiux-card form-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 text-warning">
                            <i class="bi bi-person-circle me-2"></i>
                            Sender Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="sender_name" class="form-label fw-bold">
                                Your Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="sender_name" 
                                   name="sender_name" 
                                   value="{{ old('sender_name') }}"
                                   class="form-control"
                                   placeholder="Enter your name"
                                   required>
                        </div>
                    </div>
                </div>

                <!-- Receiver Information (Optional) -->
                <div class="card adminuiux-card form-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 text-info">
                            <i class="bi bi-person-badge me-2"></i>
                            Receiver Information (Optional)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="receiver_name" class="form-label fw-bold">
                                    Receiver Name
                                </label>
                                <input type="text" 
                                       id="receiver_name" 
                                       name="receiver_name" 
                                       value="{{ old('receiver_name') }}"
                                       class="form-control"
                                       placeholder="Who is this gift for?">
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="receiver_gender" class="form-label fw-bold">
                                    Gender
                                </label>
                                <select id="receiver_gender" 
                                        name="receiver_gender"
                                        class="form-select">
                                    <option value="">Select gender</option>
                                    <option value="male" {{ old('receiver_gender') == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('receiver_gender') == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('receiver_gender') == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="receiver_phone" class="form-label fw-bold">
                                Receiver Phone
                            </label>
                            <input type="tel" 
                                   id="receiver_phone" 
                                   name="receiver_phone" 
                                   value="{{ old('receiver_phone') }}"
                                   class="form-control"
                                   placeholder="Phone number for delivery">
                        </div>
                    </div>
                </div>

                <!-- Delivery Information -->
                <div class="card adminuiux-card form-card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0 text-success">
                            <i class="bi bi-truck me-2"></i>
                            Delivery Information
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label for="delivery_method" class="form-label fw-bold">
                                Delivery Method <span class="text-danger">*</span>
                            </label>
                            <select id="delivery_method" 
                                    name="delivery_method"
                                    class="form-select"
                                    required>
                                <option value="">Select delivery method</option>
                                <option value="home_delivery" {{ old('delivery_method') == 'home_delivery' ? 'selected' : '' }}>Home Delivery</option>
                                <option value="store_pickup" {{ old('delivery_method') == 'store_pickup' ? 'selected' : '' }}>Store Pickup</option>
                            </select>
                            <div class="form-text">
                                <i class="bi bi-info-circle me-1"></i>
                                Address is required to determine the closest store location for pickup or for home delivery.
                            </div>
                        </div>
                        
                        <div id="address_fields">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="receiver_street" class="form-label fw-bold">
                                        Street Address <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           id="receiver_street" 
                                           name="receiver_street" 
                                           value="{{ old('receiver_street') }}"
                                           class="form-control @error('receiver_street') is-invalid @enderror"
                                           placeholder="123 Main Street"
                                           required>
                                    @error('receiver_street')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="receiver_house_number" class="form-label fw-bold">
                                        Apt/Suite Number
                                    </label>
                                    <input type="text" 
                                           id="receiver_house_number" 
                                           name="receiver_house_number" 
                                           value="{{ old('receiver_house_number') }}"
                                           class="form-control"
                                           placeholder="Apt 4B, Suite 100">
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label for="receiver_city" class="form-label fw-bold">
                                        City <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           id="receiver_city" 
                                           name="receiver_city" 
                                           value="{{ old('receiver_city') }}"
                                           class="form-control @error('receiver_city') is-invalid @enderror"
                                           placeholder="New York"
                                           required>
                                    @error('receiver_city')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="receiver_state" class="form-label fw-bold">
                                        State <span class="text-danger">*</span>
                                    </label>
                                    <select id="receiver_state" 
                                            name="receiver_state" 
                                            class="form-select"
                                            required>
                                        <option value="">Select State</option>
                                        <option value="AL" {{ old('receiver_state') == 'AL' ? 'selected' : '' }}>Alabama</option>
                                        <option value="AK" {{ old('receiver_state') == 'AK' ? 'selected' : '' }}>Alaska</option>
                                        <option value="AZ" {{ old('receiver_state') == 'AZ' ? 'selected' : '' }}>Arizona</option>
                                        <option value="AR" {{ old('receiver_state') == 'AR' ? 'selected' : '' }}>Arkansas</option>
                                        <option value="CA" {{ old('receiver_state') == 'CA' ? 'selected' : '' }}>California</option>
                                        <option value="CO" {{ old('receiver_state') == 'CO' ? 'selected' : '' }}>Colorado</option>
                                        <option value="CT" {{ old('receiver_state') == 'CT' ? 'selected' : '' }}>Connecticut</option>
                                        <option value="DE" {{ old('receiver_state') == 'DE' ? 'selected' : '' }}>Delaware</option>
                                        <option value="DC" {{ old('receiver_state') == 'DC' ? 'selected' : '' }}>District of Columbia</option>
                                        <option value="FL" {{ old('receiver_state') == 'FL' ? 'selected' : '' }}>Florida</option>
                                        <option value="GA" {{ old('receiver_state') == 'GA' ? 'selected' : '' }}>Georgia</option>
                                        <option value="HI" {{ old('receiver_state') == 'HI' ? 'selected' : '' }}>Hawaii</option>
                                        <option value="ID" {{ old('receiver_state') == 'ID' ? 'selected' : '' }}>Idaho</option>
                                        <option value="IL" {{ old('receiver_state') == 'IL' ? 'selected' : '' }}>Illinois</option>
                                        <option value="IN" {{ old('receiver_state') == 'IN' ? 'selected' : '' }}>Indiana</option>
                                        <option value="IA" {{ old('receiver_state') == 'IA' ? 'selected' : '' }}>Iowa</option>
                                        <option value="KS" {{ old('receiver_state') == 'KS' ? 'selected' : '' }}>Kansas</option>
                                        <option value="KY" {{ old('receiver_state') == 'KY' ? 'selected' : '' }}>Kentucky</option>
                                        <option value="LA" {{ old('receiver_state') == 'LA' ? 'selected' : '' }}>Louisiana</option>
                                        <option value="ME" {{ old('receiver_state') == 'ME' ? 'selected' : '' }}>Maine</option>
                                        <option value="MD" {{ old('receiver_state') == 'MD' ? 'selected' : '' }}>Maryland</option>
                                        <option value="MA" {{ old('receiver_state') == 'MA' ? 'selected' : '' }}>Massachusetts</option>
                                        <option value="MI" {{ old('receiver_state') == 'MI' ? 'selected' : '' }}>Michigan</option>
                                        <option value="MN" {{ old('receiver_state') == 'MN' ? 'selected' : '' }}>Minnesota</option>
                                        <option value="MS" {{ old('receiver_state') == 'MS' ? 'selected' : '' }}>Mississippi</option>
                                        <option value="MO" {{ old('receiver_state') == 'MO' ? 'selected' : '' }}>Missouri</option>
                                        <option value="MT" {{ old('receiver_state') == 'MT' ? 'selected' : '' }}>Montana</option>
                                        <option value="NE" {{ old('receiver_state') == 'NE' ? 'selected' : '' }}>Nebraska</option>
                                        <option value="NV" {{ old('receiver_state') == 'NV' ? 'selected' : '' }}>Nevada</option>
                                        <option value="NH" {{ old('receiver_state') == 'NH' ? 'selected' : '' }}>New Hampshire</option>
                                        <option value="NJ" {{ old('receiver_state') == 'NJ' ? 'selected' : '' }}>New Jersey</option>
                                        <option value="NM" {{ old('receiver_state') == 'NM' ? 'selected' : '' }}>New Mexico</option>
                                        <option value="NY" {{ old('receiver_state') == 'NY' ? 'selected' : '' }}>New York</option>
                                        <option value="NC" {{ old('receiver_state') == 'NC' ? 'selected' : '' }}>North Carolina</option>
                                        <option value="ND" {{ old('receiver_state') == 'ND' ? 'selected' : '' }}>North Dakota</option>
                                        <option value="OH" {{ old('receiver_state') == 'OH' ? 'selected' : '' }}>Ohio</option>
                                        <option value="OK" {{ old('receiver_state') == 'OK' ? 'selected' : '' }}>Oklahoma</option>
                                        <option value="OR" {{ old('receiver_state') == 'OR' ? 'selected' : '' }}>Oregon</option>
                                        <option value="PA" {{ old('receiver_state') == 'PA' ? 'selected' : '' }}>Pennsylvania</option>
                                        <option value="RI" {{ old('receiver_state') == 'RI' ? 'selected' : '' }}>Rhode Island</option>
                                        <option value="SC" {{ old('receiver_state') == 'SC' ? 'selected' : '' }}>South Carolina</option>
                                        <option value="SD" {{ old('receiver_state') == 'SD' ? 'selected' : '' }}>South Dakota</option>
                                        <option value="TN" {{ old('receiver_state') == 'TN' ? 'selected' : '' }}>Tennessee</option>
                                        <option value="TX" {{ old('receiver_state') == 'TX' ? 'selected' : '' }}>Texas</option>
                                        <option value="UT" {{ old('receiver_state') == 'UT' ? 'selected' : '' }}>Utah</option>
                                        <option value="VT" {{ old('receiver_state') == 'VT' ? 'selected' : '' }}>Vermont</option>
                                        <option value="VA" {{ old('receiver_state') == 'VA' ? 'selected' : '' }}>Virginia</option>
                                        <option value="WA" {{ old('receiver_state') == 'WA' ? 'selected' : '' }}>Washington</option>
                                        <option value="WV" {{ old('receiver_state') == 'WV' ? 'selected' : '' }}>West Virginia</option>
                                        <option value="WI" {{ old('receiver_state') == 'WI' ? 'selected' : '' }}>Wisconsin</option>
                                        <option value="WY" {{ old('receiver_state') == 'WY' ? 'selected' : '' }}>Wyoming</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label for="receiver_zip" class="form-label fw-bold">
                                        ZIP Code <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           id="receiver_zip" 
                                           name="receiver_zip" 
                                           value="{{ old('receiver_zip') }}"
                                           class="form-control"
                                           placeholder="12345"
                                           pattern="[0-9]{5}(-[0-9]{4})?"
                                           maxlength="10"
                                           required>
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Enter 5-digit ZIP code (e.g., 12345) or ZIP+4 (e.g., 12345-6789)
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="receiver_address" class="form-label fw-bold">
                                    Additional Address Details
                                </label>
                                <textarea id="receiver_address" 
                                          name="receiver_address" 
                                          rows="3"
                                          class="form-control"
                                          placeholder="Any additional address information (landmarks, building name, floor number, etc.)">{{ old('receiver_address') }}</textarea>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    Additional details help us locate your address more accurately for delivery.
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="receiver_note" class="form-label fw-bold">
                                Gift Note (Optional)
                            </label>
                            <textarea id="receiver_note" 
                                      name="receiver_note" 
                                      rows="3"
                                      class="form-control"
                                      placeholder="Add a personal message to your gift">{{ old('receiver_note') }}</textarea>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="d-flex flex-column flex-md-row gap-3">
                    <a href="{{ route('customize.product', $product->slug) }}" 
                       class="btn btn-secondary flex-fill">
                        <i class="bi bi-arrow-left me-2"></i>
                        Back
                    </a>
                    
                    <button type="submit" 
                            class="btn btn-warning flex-fill">
                        Continue to Customization
                        <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const deliveryMethod = document.getElementById('delivery_method');
    const addressFields = document.getElementById('address_fields');
    const zipInput = document.getElementById('receiver_zip');
    const cityInput = document.getElementById('receiver_city');
    const stateSelect = document.getElementById('receiver_state');
    const streetInput = document.getElementById('receiver_street');
    const form = document.querySelector('form');
    
    // ZIP Code validation and formatting
    zipInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
        
        if (value.length >= 5) {
            if (value.length >= 9) {
                value = value.slice(0, 5) + '-' + value.slice(5, 9);
            } else {
                value = value.slice(0, 5);
            }
        }
        
        e.target.value = value;
    });
    
    // ZIP Code validation
    zipInput.addEventListener('blur', function() {
        const zip = this.value.replace(/\D/g, '');
        if (zip.length < 5) {
            this.setCustomValidity('Please enter a valid 5-digit ZIP code');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });
    
    // State selection validation
    stateSelect.addEventListener('change', function() {
        if (this.value === '') {
            this.setCustomValidity('Please select a state');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });
    
    // City validation
    cityInput.addEventListener('blur', function() {
        if (this.value.trim() === '') {
            this.setCustomValidity('Please enter a city name');
            this.classList.add('is-invalid');
        } else if (this.value.trim().length < 2) {
            this.setCustomValidity('City name must be at least 2 characters');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });
    
    // Street address validation
    streetInput.addEventListener('blur', function() {
        if (this.value.trim() === '') {
            this.setCustomValidity('Please enter a street address');
            this.classList.add('is-invalid');
        } else if (this.value.trim().length < 5) {
            this.setCustomValidity('Street address must be at least 5 characters');
            this.classList.add('is-invalid');
        } else {
            this.setCustomValidity('');
            this.classList.remove('is-invalid');
        }
    });
    
    // Major US cities for autocomplete suggestions
    const majorCities = {
        'NY': ['New York', 'Buffalo', 'Rochester', 'Yonkers', 'Syracuse'],
        'CA': ['Los Angeles', 'San Francisco', 'San Diego', 'Sacramento', 'San Jose'],
        'TX': ['Houston', 'Dallas', 'Austin', 'San Antonio', 'Fort Worth'],
        'FL': ['Miami', 'Orlando', 'Tampa', 'Jacksonville', 'Fort Lauderdale'],
        'IL': ['Chicago', 'Springfield', 'Peoria', 'Rockford', 'Naperville'],
        'PA': ['Philadelphia', 'Pittsburgh', 'Allentown', 'Erie', 'Reading'],
        'OH': ['Columbus', 'Cleveland', 'Cincinnati', 'Toledo', 'Akron'],
        'MI': ['Detroit', 'Grand Rapids', 'Warren', 'Sterling Heights', 'Lansing'],
        'GA': ['Atlanta', 'Augusta', 'Columbus', 'Macon', 'Savannah'],
        'NC': ['Charlotte', 'Raleigh', 'Greensboro', 'Durham', 'Winston-Salem'],
        'VA': ['Virginia Beach', 'Richmond', 'Norfolk', 'Arlington', 'Newport News'],
        'WA': ['Seattle', 'Spokane', 'Tacoma', 'Vancouver', 'Bellevue'],
        'MA': ['Boston', 'Worcester', 'Springfield', 'Lowell', 'Cambridge'],
        'TN': ['Nashville', 'Memphis', 'Knoxville', 'Chattanooga', 'Clarksville'],
        'IN': ['Indianapolis', 'Fort Wayne', 'Evansville', 'South Bend', 'Carmel'],
        'MO': ['Kansas City', 'St. Louis', 'Springfield', 'Columbia', 'Independence'],
        'MD': ['Baltimore', 'Frederick', 'Rockville', 'Gaithersburg', 'Bowie'],
        'CO': ['Denver', 'Colorado Springs', 'Aurora', 'Fort Collins', 'Lakewood'],
        'WI': ['Milwaukee', 'Madison', 'Green Bay', 'Kenosha', 'Racine'],
        'MN': ['Minneapolis', 'St. Paul', 'Rochester', 'Duluth', 'Bloomington']
    };
    
    // City autocomplete based on selected state
    stateSelect.addEventListener('change', function() {
        const selectedState = this.value;
        const citySuggestions = majorCities[selectedState] || [];
        
        // Clear existing datalist
        const existingDatalist = document.getElementById('city-suggestions');
        if (existingDatalist) {
            existingDatalist.remove();
        }
        
        if (citySuggestions.length > 0) {
            const datalist = document.createElement('datalist');
            datalist.id = 'city-suggestions';
            
            citySuggestions.forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                datalist.appendChild(option);
            });
            
            document.body.appendChild(datalist);
            cityInput.setAttribute('list', 'city-suggestions');
        } else {
            cityInput.removeAttribute('list');
        }
    });
    
    // Address fields visibility and label updates
    function updateAddressFieldLabels() {
        const isStorePickup = deliveryMethod.value === 'store_pickup';
        const addressLabels = addressFields.querySelectorAll('label');
        
        addressLabels.forEach(label => {
            if (label.textContent.includes('Street') || label.textContent.includes('House Number') || 
                label.textContent.includes('City') || label.textContent.includes('ZIP Code')) {
                if (isStorePickup) {
                    if (!label.innerHTML.includes('(for store location)')) {
                        label.innerHTML = label.innerHTML.replace(' <span class="text-danger">*</span>', ' <span class="text-danger">*</span> <small class="text-info">(for store location)</small>');
                    }
                } else {
                    label.innerHTML = label.innerHTML.replace(' <small class="text-info">(for store location)</small>', '');
                }
            }
        });
    }
    
    deliveryMethod.addEventListener('change', updateAddressFieldLabels);
    updateAddressFieldLabels(); // Initial state
    
    // Form validation before submit
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validate required fields
        const requiredFields = [
            { element: streetInput, name: 'Street Address' },
            { element: cityInput, name: 'City' },
            { element: stateSelect, name: 'State' },
            { element: zipInput, name: 'ZIP Code' }
        ];
        
        requiredFields.forEach(field => {
            if (field.element.value.trim() === '') {
                field.element.setCustomValidity(`${field.name} is required`);
                field.element.classList.add('is-invalid');
                isValid = false;
            } else {
                field.element.setCustomValidity('');
                field.element.classList.remove('is-invalid');
            }
        });
        
        // Additional ZIP code validation
        const zip = zipInput.value.replace(/\D/g, '');
        if (zip.length < 5) {
            zipInput.setCustomValidity('Please enter a valid 5-digit ZIP code');
            zipInput.classList.add('is-invalid');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            
            // Show error message
            const errorDiv = document.createElement('div');
            errorDiv.className = 'alert alert-danger mt-3';
            errorDiv.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Please correct the errors above before continuing.';
            
            const existingError = form.querySelector('.alert-danger');
            if (existingError) {
                existingError.remove();
            }
            
            form.insertBefore(errorDiv, form.firstChild);
            
            // Scroll to first error
            const firstError = form.querySelector('.is-invalid');
            if (firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                firstError.focus();
            }
        }
    });
    
    // Real-time validation feedback
    const inputs = [streetInput, cityInput, zipInput];
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            if (this.classList.contains('is-invalid')) {
                this.classList.remove('is-invalid');
                this.setCustomValidity('');
            }
        });
    });
    
    // Phone number formatting
    const phoneInput = document.getElementById('receiver_phone');
    if (phoneInput) {
        phoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            
            if (value.length >= 6) {
                value = value.slice(0, 3) + '-' + value.slice(3, 6) + '-' + value.slice(6, 10);
            } else if (value.length >= 3) {
                value = value.slice(0, 3) + '-' + value.slice(3);
            }
            
            e.target.value = value;
        });
    }
});
</script>
@endsection 
@extends('layouts.template')

@section('content')

<style>
/* Mobile Styles */
@media (max-width: 768px) {
    body {
        min-height: 100vh !important;
        margin: 0 !important;
        padding: 0 !important;
    }
    
    .container {
        padding: 0 12px !important;
        margin: 0 !important;
        max-width: 100% !important;
    }
    
    .mobile-only {
        display: block !important;
        min-height: 100vh;
        padding: 1rem 0 2rem 0;
    }
    
    .desktop-only {
        display: none !important;
    }
    
    .add-funds-header {
        background: linear-gradient(135deg, rgb(19, 16, 16) 0%, rgb(0, 0, 0) 100%) !important;
        border: none !important;
        border-radius: 20px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
    }
    
    .current-balance {
        font-size: 1.8rem !important;
        font-weight: 700;
        color: #ffffff !important;
        margin-bottom: 0.5rem;
    }
    
    .balance-label {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.8) !important;
        margin-bottom: 0.5rem;
    }
    
    .amount-options {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }
    
    .amount-option {
        background: linear-gradient(135deg, rgb(19, 16, 16) 0%, rgb(0, 0, 0) 100%) !important;
        border: none !important;
        border-radius: 20px;
        padding: 0.5rem 0.2rem;
        text-align: center;
        color: #ffffff !important;
        font-size: 0.75rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
    }
    
    .amount-option:hover {
        background: linear-gradient(135deg, rgb(0, 0, 0) 0%, rgb(19, 16, 16) 100%) !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.4) !important;
    }
    
    .amount-option input[type="radio"]:checked + label {
        background: linear-gradient(135deg, #004953 0%, #005a66 100%) !important;
        color: #ffffff !important;
    }
    
    .custom-amount-input {
        background: linear-gradient(135deg, rgb(19, 16, 16) 0%, rgb(0, 0, 0) 100%) !important;
        border: none !important;
        border-radius: 20px;
        padding: 0.75rem;
        color: #ffffff !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
    }
    
    .custom-amount-input::placeholder {
        color: rgba(255,255,255,0.6) !important;
    }
    
    .payment-method {
        background: linear-gradient(135deg, rgb(19, 16, 16) 0%, rgb(0, 0, 0) 100%) !important;
        border: none !important;
        border-radius: 20px;
        padding: 0.75rem;
        margin-bottom: 0.75rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
    }
    
    .virtual-account-card {
        background: linear-gradient(135deg, rgb(19, 16, 16) 0%, rgb(0, 0, 0) 100%) !important;
        border: none !important;
        border-radius: 20px;
        padding: 0.75rem;
        margin-bottom: 0.75rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
    }
    
    .account-info {
        background: rgba(255,255,255,0.1) !important;
        border-radius: 15px;
        padding: 0.75rem;
        margin-bottom: 0.5rem;
    }
    
    .account-label {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.7) !important;
        margin-bottom: 0.25rem;
    }
    
    .account-value {
        font-size: 0.9rem;
        font-weight: 600;
        color: #ffffff !important;
        margin-bottom: 0.5rem;
    }
    
    .copy-btn {
        background: linear-gradient(135deg, #004953 0%, #005a66 100%) !important;
        border: none !important;
        border-radius: 15px;
        padding: 0.5rem 1rem;
        color: #ffffff !important;
        font-size: 0.8rem;
        transition: all 0.3s ease;
    }
    
    .copy-btn:hover {
        background: linear-gradient(135deg, #005a66 0%, #004953 100%) !important;
        transform: translateY(-1px);
    }
    
    .submit-btn {
        background: linear-gradient(135deg, #004953 0%, #005a66 100%) !important;
        border: none !important;
        border-radius: 20px;
        padding: 1rem;
        color: #ffffff !important;
        font-size: 1rem;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
    }
    
    .submit-btn:hover {
        background: linear-gradient(135deg, #005a66 0%, #004953 100%) !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.4) !important;
    }
    
    .submit-btn:disabled {
        background: rgba(255,255,255,0.2) !important;
        color: rgba(255,255,255,0.5) !important;
        cursor: not-allowed;
    }

    /* Light theme payment confirmation button */
    [data-theme="light"] .submit-btn {
        background: linear-gradient(135deg, #004953 0%, #005a66 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }

    [data-theme="light"] .submit-btn:hover {
        background: linear-gradient(135deg, #005a66 0%, #004953 100%) !important;
        transform: translateY(-1px);
    }

    [data-theme="light"] .submit-btn:disabled {
        background: rgba(0, 0, 0, 0.2) !important;
        color: rgba(0, 0, 0, 0.5) !important;
        cursor: not-allowed;
    }

    [data-theme="light"] .btn-warning {
        background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%) !important;
        color: #000000 !important;
        border: none !important;
    }

    [data-theme="light"] .btn-success {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }

    [data-theme="light"] .btn-danger {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important;
        color: #ffffff !important;
        border: none !important;
    }

    /* Modal backdrop and content styling for both themes */
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.8) !important;
        opacity: 1 !important;
    }

    /* Payment confirmation modal specific styling */
    #paymentConfirmationModal {
        background: rgba(0, 0, 0, 0.8) !important;
        z-index: 9999 !important;
    }

    #paymentConfirmationModal .modal-dialog {
        z-index: 10000 !important;
    }

    #paymentConfirmationModal .modal-content {
        border: 2px solid #17a2b8 !important;
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.6) !important;
    }

    .modal-content {
        background: #ffffff !important;
        border-radius: 15px !important;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3) !important;
        border: none !important;
    }

    .modal-header {
        border-radius: 15px 15px 0 0 !important;
        border-bottom: 1px solid #dee2e6 !important;
    }

    .modal-body {
        background: #ffffff !important;
        padding: 2rem !important;
    }

    .modal-footer {
        background: #f8f9fa !important;
        border-radius: 0 0 15px 15px !important;
        border-top: 1px solid #dee2e6 !important;
    }

    /* Dark theme modal overrides */
    [data-theme="dark"] .modal-content {
        background: #2d3748 !important;
        color: #ffffff !important;
    }

    [data-theme="dark"] .modal-header {
        background: #4a5568 !important;
        border-bottom: 1px solid #4a5568 !important;
    }

    [data-theme="dark"] .modal-body {
        background: #2d3748 !important;
        color: #ffffff !important;
    }

    [data-theme="dark"] .modal-footer {
        background: #4a5568 !important;
        border-top: 1px solid #4a5568 !important;
    }

    [data-theme="dark"] .modal-title,
    [data-theme="dark"] .modal-body h6,
    [data-theme="dark"] .modal-body p {
        color: #ffffff !important;
    }

    [data-theme="dark"] .modal-body .text-muted {
        color: #a0aec0 !important;
    }
    
    .breadcrumb {
        margin-bottom: 0.5rem;
        font-size: 0.8rem;
    }
    
    .breadcrumb-item {
        padding: 0.2rem 0;
    }
    
    .breadcrumb-item a {
        color: #ffffff !important;
    }
    
    .breadcrumb-item.active {
        color: rgba(255,255,255,0.7) !important;
    }
    
    /* Override template background colors */
    .mobile-only,
    .mobile-only *,
    .mobile-container,
    .mobile-container *,
    .container-fluid,
    .container,
    .row,
    .col,
    .col-12 {
        background-color: transparent !important;
    }
    
    /* Ensure no background from template CSS */
    body > *,
    body > * > * {
        background-color: transparent !important;
    }
    
    /* Override any template footer/container backgrounds */
    footer,
    .footer,
    .mobile-footer,
    .bottom-nav,
    .bottom-navigation {
        background-color: transparent !important;
    }
}

/* Desktop Styles */
@media (min-width: 769px) {
    .mobile-only {
        display: none !important;
    }
    
    .desktop-only {
        display: block !important;
    }
    
    .container {
        padding: 0 20px;
    }
    
    .card {
        margin-bottom: 1.5rem;
        border-radius: 20px;
        background: linear-gradient(135deg, rgb(19, 16, 16) 0%, rgb(0, 0, 0) 100%) !important;
        backdrop-filter: blur(10px) !important;
        border: none !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
    }
    
    .card-body {
        padding: 1.5rem;
    }
    
    .card-header {
        padding: 1.25rem 1.5rem;
    }
}

/* Color Classes */
.text-main {
    color: #004953 !important;
}

.text-accent-green {
    color: #00A86B !important;
}

.text-accent-red {
    color: #F94943 !important;
}

.text-accent-orange {
    color: #FCA488 !important;
}

.bg-main {
    background-color: #004953 !important;
}

.bg-accent-green {
    background-color: #00A86B !important;
}

.bg-accent-red {
    background-color: #F94943 !important;
}

.bg-accent-orange {
    background-color: #FCA488 !important;
}

/* Force remove all template background colors */
* {
    background-color: transparent !important;
}

/* Override any inline styles with background */
[style*="background"] {
    background: transparent !important;
}

/* Specific overrides for template elements */
.adminuiux-mobile-footer,
.mobile-container,
.template-container,
.ecommerce-footer,
.footer,
.bottom-nav {
    background: transparent !important;
}

/* Light theme styling for add funds page */
[data-theme="light"] .add-funds-header {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .current-balance {
    color: #000000 !important;
}

[data-theme="light"] .balance-label {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .amount-option {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #000000 !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .amount-option:hover {
    background: #f8f9fa !important;
    border-color: #036674 !important;
    box-shadow: 0 6px 20px rgba(3, 102, 116, 0.2) !important;
}

[data-theme="light"] .amount-option input[type="radio"]:checked + label {
    background: #036674 !important;
    color: #ffffff !important;
}

[data-theme="light"] .custom-amount-input {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #000000 !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .custom-amount-input::placeholder {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .payment-method {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .virtual-account-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .account-info {
    background: rgba(0, 0, 0, 0.05) !important;
}

[data-theme="light"] .account-label {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .account-value {
    color: #000000 !important;
}

[data-theme="light"] .copy-btn {
    background: #036674 !important;
    color: #ffffff !important;
}

[data-theme="light"] .copy-btn:hover {
    background: #025a66 !important;
}

[data-theme="light"] .submit-btn {
    background: #036674 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(3, 102, 116, 0.2) !important;
}

[data-theme="light"] .submit-btn:hover {
    background: #025a66 !important;
    box-shadow: 0 6px 20px rgba(3, 102, 116, 0.3) !important;
}

[data-theme="light"] .submit-btn:disabled {
    background: rgba(0, 0, 0, 0.2) !important;
    color: rgba(0, 0, 0, 0.5) !important;
}

[data-theme="light"] .breadcrumb-item a {
    color: #000000 !important;
}

[data-theme="light"] .breadcrumb-item.active {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .card-header {
    background: #036674 !important;
    color: #ffffff !important;
    border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .text-main {
    color: #036674 !important;
}

[data-theme="light"] .text-info {
    color: #036674 !important;
}

[data-theme="light"] .text-success {
    color: #28a745 !important;
}

[data-theme="light"] .text-light {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .btn-outline-success {
    border-color: #036674 !important;
    color: #036674 !important;
}

[data-theme="light"] .btn-outline-success:hover {
    background: #036674 !important;
    color: #ffffff !important;
}

[data-theme="light"] .alert-danger {
    background: #f8d7da !important;
    border-color: #f5c6cb !important;
    color: #721c24 !important;
}

/* Light theme form labels */
[data-theme="light"] .form-label {
    color: #000000 !important;
}

[data-theme="light"] .form-label.fw-bold {
    color: #000000 !important;
}

/* Light theme text colors */
[data-theme="light"] .text-secondary {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .text-muted {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .text-light {
    color: rgba(0, 0, 0, 0.6) !important;
}
</style>

<div class="container">
    <div class="mobile-only d-md-none">
        <!-- Compact Breadcrumb -->
            <nav aria-label="breadcrumb" class="mb-1">
                <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i class="bi bi-house-door"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('wallet.index') }}" class="text-decoration-none"><i class="bi bi-wallet2"></i></a></li>
                <li class="breadcrumb-item active">Add Funds</li>
                </ol>
            </nav>
        
        <!-- Compact Add Funds Header -->
        <div class="add-funds-header">
            <div class="balance-label">Current Balance</div>
            <div class="current-balance">{{ $wallet->formatted_balance }}</div>
            <div class="balance-label">{{ Auth::user()->name }}</div>
</div>

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

        <!-- Compact Amount Selection -->
        <div class="amount-options">
            <div>
                <input type="radio" class="btn-check" name="amount" id="amount_1000_mobile" value="1000" autocomplete="off">
                <label class="amount-option" for="amount_1000_mobile">₦1,000</label>
                            </div>
            <div>
                <input type="radio" class="btn-check" name="amount" id="amount_2000_mobile" value="2000" autocomplete="off">
                <label class="amount-option" for="amount_2000_mobile">₦2,000</label>
                        </div>
            <div>
                <input type="radio" class="btn-check" name="amount" id="amount_5000_mobile" value="5000" autocomplete="off">
                <label class="amount-option" for="amount_5000_mobile">₦5,000</label>
                        </div>
            <div>
                <input type="radio" class="btn-check" name="amount" id="amount_10000_mobile" value="10000" autocomplete="off">
                <label class="amount-option" for="amount_10000_mobile">₦10,000</label>
            </div>
        </div>
        
        <!-- Custom Amount Input -->
        <div class="mb-3">
            <input type="number" class="form-control custom-amount-input" id="custom_amount_mobile" name="custom_amount" 
                   min="1000" max="1000000" step="100" placeholder="Or enter custom amount">
        </div>
        
        <!-- Charge Information Mobile -->
        <div class="mb-3" id="charge-info-section-mobile" style="display: none;">
            <div class="virtual-account-card">
                <div class="text-center mb-2">
                    <i class="bi bi-calculator text-main"></i>
                    <div class="account-label">Transaction Charges</div>
                </div>
                <div class="account-info">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="account-label">Base Amount:</span>
                        <span class="account-value" id="base-amount-mobile">₦0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="account-label">Service Charge:</span>
                        <span class="account-value text-info" id="service-charge-mobile">₦0.00</span>
                    </div>
                    <hr class="my-2">
                    <div class="d-flex justify-content-between">
                        <span class="account-label">Total to Pay:</span>
                        <span class="account-value text-success fw-bold" id="total-amount-mobile">₦0.00</span>
                    </div>
                    <div class="mt-2">
                        <small class="text-light" id="charge-breakdown-mobile"></small>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Payment Method -->
        <div class="payment-method">
            <input type="radio" class="btn-check" name="payment_method" id="xtrapay_mobile" value="xtrapay" autocomplete="off" checked>
            <label class="btn btn-outline-success w-100 py-2" for="xtrapay_mobile">
                <i class="bi bi-bank me-2"></i>XtraPay Virtual Account
            </label>
        </div>
        
        <div class="payment-method">
            <input type="radio" class="btn-check" name="payment_method" id="payvibe_mobile" value="payvibe" autocomplete="off">
            <label class="btn btn-outline-primary w-100 py-2" for="payvibe_mobile">
                <i class="bi bi-credit-card me-2"></i>PayVibe Virtual Account
            </label>
        </div>
        
        <!-- Virtual Account Details -->
        <div id="xtrapay-details-mobile" class="virtual-account-card">
            <div class="text-center mb-3">
                <i class="bi bi-info-circle text-main"></i>
                <div class="account-label">Transfer to Virtual Account</div>
            </div>
            
            <div id="virtual-account-info-mobile">
                <div class="text-center">
                    <div class="spinner-border spinner-border-sm text-main" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-light small">Generating account...</p>
                </div>
            </div>
        </div>
        
        <!-- PayVibe Virtual Account Details -->
        <div id="payvibe-details-mobile" class="virtual-account-card" style="display: none;">
            <div class="text-center mb-3">
                <i class="bi bi-credit-card text-primary"></i>
                <div class="account-label">Transfer to PayVibe Virtual Account</div>
            </div>
            
            <div id="payvibe-account-info-mobile">
                <div class="text-center">
                    <div class="spinner-border spinner-border-sm text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2 text-light small">Generating PayVibe account...</p>
                </div>
            </div>
        </div>
        
        <!-- Submit Button -->
        <form action="{{ route('wallet.store-funds') }}" method="POST" id="addFundsFormMobile">
            @csrf
            <input type="hidden" name="amount" id="mobile_amount_hidden">
            <input type="hidden" name="custom_amount" id="mobile_custom_amount_hidden">
            <input type="hidden" name="payment_method" value="xtrapay">
            <button type="submit" class="submit-btn" id="submitBtnMobile" disabled>
                <i class="bi bi-shield-check me-2"></i>Add Funds
            </button>
        </form>
    </div>

    <!-- Desktop Layout -->
    <div class="desktop-only d-none d-md-block">
        <div class="row gx-1 align-items-center mb-4">
            <div class="col col-sm">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item bi"><a href="{{ route('home') }}"><i class="bi bi-house-door"></i> Home</a></li>
                        <li class="breadcrumb-item bi"><a href="{{ route('wallet.index') }}"><i class="bi bi-wallet2"></i> Wallet</a></li>
                        <li class="breadcrumb-item active bi" aria-current="page">Add Funds</li>
                    </ol>
                </nav>
                <h4 class="mb-0">Add Funds to Wallet</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('wallet.index') }}" class="btn btn-main">
                    <i class="bi bi-arrow-left me-2"></i>Back to Wallet
                </a>
            </div>
        </div>

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="bi bi-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="row gx-4">
        <div class="col-12 col-lg-8">
                <div class="card">
                <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-credit-card me-2"></i>Payment Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('wallet.store-funds') }}" method="POST" id="addFundsForm">
                        @csrf
                        
                        <!-- Amount Selection -->
                        <div class="mb-4">
                                <label class="form-label fw-bold mb-3">Select Amount:</label>
                            <div class="row gx-2">
                                <div class="col-6 col-md-3 mb-2">
                                    <input type="radio" class="btn-check" name="amount" id="amount_1000" value="1000" autocomplete="off">
                                        <label class="btn btn-outline-main w-100" for="amount_1000">
                                        <strong>₦1,000</strong>
                                    </label>
                                </div>
                                <div class="col-6 col-md-3 mb-2">
                                    <input type="radio" class="btn-check" name="amount" id="amount_2000" value="2000" autocomplete="off">
                                        <label class="btn btn-outline-main w-100" for="amount_2000">
                                        <strong>₦2,000</strong>
                                    </label>
                                </div>
                                <div class="col-6 col-md-3 mb-2">
                                    <input type="radio" class="btn-check" name="amount" id="amount_5000" value="5000" autocomplete="off">
                                        <label class="btn btn-outline-main w-100" for="amount_5000">
                                        <strong>₦5,000</strong>
                                    </label>
                                </div>
                                <div class="col-6 col-md-3 mb-2">
                                    <input type="radio" class="btn-check" name="amount" id="amount_10000" value="10000" autocomplete="off">
                                        <label class="btn btn-outline-main w-100" for="amount_10000">
                                        <strong>₦10,000</strong>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Custom Amount -->
                            <div class="mt-3">
                                    <label class="form-label">Or enter custom amount:</label>
                                <div class="input-group">
                                        <span class="input-group-text bg-main text-white">₦</span>
                                    <input type="number" class="form-control" id="custom_amount" name="custom_amount" 
                                           min="1000" max="1000000" step="100" placeholder="Enter amount">
                                    </div>
                            </div>
                        </div>

                        <!-- Charge Information -->
                        <div class="mb-4" id="charge-info-section" style="display: none;">
                            <div class="card border-info">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0"><i class="bi bi-calculator me-2"></i>Transaction Charges</h6>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Base Amount:</small>
                                            <div class="fw-bold" id="base-amount">₦0.00</div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Service Charge:</small>
                                            <div class="fw-bold text-info" id="service-charge">₦0.00</div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12">
                                            <small class="text-muted">Total Amount to Pay:</small>
                                            <div class="h5 fw-bold text-success mb-0" id="total-amount">₦0.00</div>
                                        </div>
                                    </div>
                                    <div class="mt-2">
                                        <small class="text-muted" id="charge-breakdown"></small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div class="mb-4">
                                <label class="form-label fw-bold mb-3">Payment Method:</label>
                            <div class="row gx-2">
                                    <div class="col-12 mb-2">
                                    <input type="radio" class="btn-check" name="payment_method" id="xtrapay" value="xtrapay" autocomplete="off" checked>
                                    <label class="btn btn-outline-success w-100" for="xtrapay">
                                            <i class="bi bi-bank me-2"></i>XtraPay Virtual Account
                                    </label>
                                </div>
                                <div class="col-12">
                                    <input type="radio" class="btn-check" name="payment_method" id="payvibe" value="payvibe" autocomplete="off">
                                    <label class="btn btn-outline-primary w-100" for="payvibe">
                                            <i class="bi bi-credit-card me-2"></i>PayVibe Virtual Account
                                    </label>
                                </div>
                            </div>
                        </div>

                            <!-- Virtual Account Details -->
                            <div id="xtrapay-details" class="mb-4">
                            <div class="alert alert-info">
                                    <h6 class="mb-1"><i class="bi bi-info-circle me-2"></i>Virtual Account Details</h6>
                                    <p class="mb-0">Transfer the amount to the account details below. Your wallet will be credited automatically once payment is confirmed.</p>
                            </div>
                            
                                <div id="virtual-account-info" class="card">
                                    <div class="card-body">
                                <div class="text-center">
                                            <div class="spinner-border spinner-border-sm text-main" role="status">
                                        <span class="visually-hidden">Loading...</span>
                                    </div>
                                            <p class="mt-2 text-secondary">Generating virtual account...</p>
                            </div>
                        </div>
                            </div>
                        </div>

                        <!-- PayVibe Virtual Account Details -->
                        <div id="payvibe-details" class="mb-4" style="display: none;">
                            <div class="alert alert-primary">
                                <h6 class="mb-1"><i class="bi bi-credit-card me-2"></i>PayVibe Virtual Account Details</h6>
                                <p class="mb-0">Transfer the amount to the PayVibe account details below. Your wallet will be credited automatically once payment is confirmed.</p>
                            </div>
                            
                            <div id="payvibe-account-info" class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="spinner-border spinner-border-sm text-primary" role="status">
                                            <span class="visually-hidden">Loading...</span>
                                        </div>
                                        <p class="mt-2 text-secondary">Generating PayVibe account...</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                                <button type="submit" class="btn btn-main btn-lg" id="submitBtn" disabled>
                                    <i class="bi bi-shield-check me-2"></i>Add Funds
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-4">
                <div class="card">
                <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-wallet2 me-2"></i>Current Balance</h5>
                </div>
                    <div class="card-body text-center">
                        <h2 class="text-main mb-2">{{ $wallet->formatted_balance }}</h2>
                        <p class="text-secondary mb-0">{{ Auth::user()->name }}'s Wallet</p>
                </div>
            </div>

                <div class="card mt-4">
                <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>How it Works</h5>
                </div>
                <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-1-circle text-main me-2 mt-1"></i>
                            <small class="text-secondary">Select your preferred amount</small>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-2-circle text-main me-2 mt-1"></i>
                            <small class="text-secondary">Transfer to the virtual account</small>
                        </div>
                        <div class="d-flex align-items-start">
                            <i class="bi bi-3-circle text-main me-2 mt-1"></i>
                            <small class="text-secondary">Wallet credited automatically</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Mobile form elements
    const mobileAmountInputs = document.querySelectorAll('input[name="amount"]');
    const mobileCustomAmountInput = document.getElementById('custom_amount_mobile');
    const mobileSubmitBtn = document.getElementById('submitBtnMobile');
    const mobileForm = document.getElementById('addFundsFormMobile');
    
    // Desktop form elements
    const desktopAmountInputs = document.querySelectorAll('input[name="amount"]');
    const desktopCustomAmountInput = document.getElementById('custom_amount');
    const desktopSubmitBtn = document.getElementById('submitBtn');
    const desktopForm = document.getElementById('addFundsForm');
    
    // Function to handle amount selection
    function handleAmountSelection(amountInputs, customAmountInput, submitBtn, isMobile = false) {
        let selectedAmount = 0;
        let amountSource = '';
        
        // Check if any preset amount is selected
        amountInputs.forEach(input => {
            if (input.checked) {
                selectedAmount = parseInt(input.value);
                amountSource = 'preset';
                // Clear custom amount when preset is selected
                if (customAmountInput) {
                    customAmountInput.value = '';
                }
            }
        });
        
        // Check custom amount if no preset is selected
        if (selectedAmount === 0 && customAmountInput && customAmountInput.value) {
            selectedAmount = parseInt(customAmountInput.value);
            amountSource = 'custom';
        }
        
        // Update hidden inputs for mobile form
        if (isMobile) {
            const mobileAmountHidden = document.getElementById('mobile_amount_hidden');
            const mobileCustomAmountHidden = document.getElementById('mobile_custom_amount_hidden');
            
            if (amountSource === 'preset') {
                mobileAmountHidden.value = selectedAmount;
                mobileCustomAmountHidden.value = '';
            } else if (amountSource === 'custom') {
                mobileAmountHidden.value = '';
                mobileCustomAmountHidden.value = selectedAmount;
            } else {
                mobileAmountHidden.value = '';
                mobileCustomAmountHidden.value = '';
            }
        }
        
        // Enable/disable submit button and update charge info
        if (selectedAmount >= 1000) {
            submitBtn.disabled = false;
            submitBtn.classList.remove('btn-secondary');
            submitBtn.classList.add('btn-main');
            
            // Update charge information
            updateChargeInfo(selectedAmount, isMobile);
        } else {
            submitBtn.disabled = true;
            submitBtn.classList.remove('btn-main');
            submitBtn.classList.add('btn-secondary');
            
            // Hide charge information
            hideChargeInfo(isMobile);
        }
        
        return selectedAmount;
    }
    
    // Function to update charge information
    function updateChargeInfo(amount, isMobile = false) {
        fetch('{{ route("wallet.charge-info") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                amount: amount,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const chargeInfo = data.charge_info;
                const breakdown = chargeInfo.breakdown;
                
                if (isMobile) {
                    // Update mobile charge info
                    document.getElementById('base-amount-mobile').textContent = chargeInfo.formatted.base_amount;
                    document.getElementById('service-charge-mobile').textContent = chargeInfo.formatted.charge;
                    document.getElementById('total-amount-mobile').textContent = chargeInfo.formatted.total_amount;
                    document.getElementById('charge-breakdown-mobile').textContent = 
                        `${breakdown.tier} - Fixed: ${breakdown.fixed_charge}, Rate: ${breakdown.percentage_rate}`;
                    
                    document.getElementById('charge-info-section-mobile').style.display = 'block';
                } else {
                    // Update desktop charge info
                    document.getElementById('base-amount').textContent = chargeInfo.formatted.base_amount;
                    document.getElementById('service-charge').textContent = chargeInfo.formatted.charge;
                    document.getElementById('total-amount').textContent = chargeInfo.formatted.total_amount;
                    document.getElementById('charge-breakdown').textContent = 
                        `${breakdown.tier} - Fixed: ₦${breakdown.fixed_charge}, Rate: ${breakdown.percentage_rate}`;
                    
                    document.getElementById('charge-info-section').style.display = 'block';
                }
            }
        })
        .catch(error => {
            console.error('Error fetching charge info:', error);
        });
    }
    
    // Function to hide charge information
    function hideChargeInfo(isMobile = false) {
        if (isMobile) {
            document.getElementById('charge-info-section-mobile').style.display = 'none';
        } else {
            document.getElementById('charge-info-section').style.display = 'none';
        }
    }
    
    // Mobile amount selection handlers
    mobileAmountInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Uncheck other radio buttons
            mobileAmountInputs.forEach(otherInput => {
                if (otherInput !== this) {
                    otherInput.checked = false;
                }
            });
            
            // Check this radio button
            this.checked = true;
            
            // Update submit button
            handleAmountSelection(mobileAmountInputs, mobileCustomAmountInput, mobileSubmitBtn, true);
            
            // Generate virtual account if amount is selected
            if (this.checked && parseInt(this.value) >= 1000) {
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
                generateVirtualAccount('mobile', selectedMethod);
            }
        });
    });
    
    // Mobile custom amount handler
    if (mobileCustomAmountInput) {
        mobileCustomAmountInput.addEventListener('input', function() {
            // Uncheck all preset amounts
            mobileAmountInputs.forEach(input => {
                input.checked = false;
            });
            
            // Update submit button
            const selectedAmount = handleAmountSelection(mobileAmountInputs, mobileCustomAmountInput, mobileSubmitBtn, true);
            
            // Generate virtual account if amount is valid
            if (selectedAmount >= 1000) {
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
                generateVirtualAccount('mobile', selectedMethod);
            }
        });
    }
    
    // Desktop amount selection handlers
    desktopAmountInputs.forEach(input => {
        input.addEventListener('change', function() {
            // Uncheck other radio buttons
            desktopAmountInputs.forEach(otherInput => {
                if (otherInput !== this) {
                    otherInput.checked = false;
                }
            });
            
            // Check this radio button
            this.checked = true;
            
            // Update submit button
            handleAmountSelection(desktopAmountInputs, desktopCustomAmountInput, desktopSubmitBtn);
            
            // Generate virtual account if amount is selected
            if (this.checked && parseInt(this.value) >= 1000) {
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
                generateVirtualAccount('desktop', selectedMethod);
            }
        });
    });
    
    // Desktop custom amount handler
    if (desktopCustomAmountInput) {
        desktopCustomAmountInput.addEventListener('input', function() {
            // Uncheck all preset amounts
            desktopAmountInputs.forEach(input => {
                input.checked = false;
            });
            
            // Update submit button
            const selectedAmount = handleAmountSelection(desktopAmountInputs, desktopCustomAmountInput, desktopSubmitBtn);
            
            // Generate virtual account if amount is valid
            if (selectedAmount >= 1000) {
                const selectedMethod = document.querySelector('input[name="payment_method"]:checked').value;
                generateVirtualAccount('desktop', selectedMethod);
            }
        });
    }
    
    // Payment method change handlers
    const paymentMethodInputs = document.querySelectorAll('input[name="payment_method"]');
    paymentMethodInputs.forEach(input => {
        input.addEventListener('change', function() {
            const selectedMethod = this.value;
            const isMobile = this.id.includes('mobile');
            
            // Hide all virtual account details
            if (isMobile) {
                document.getElementById('xtrapay-details-mobile').style.display = 'none';
                document.getElementById('payvibe-details-mobile').style.display = 'none';
            } else {
                document.getElementById('xtrapay-details').style.display = 'none';
                document.getElementById('payvibe-details').style.display = 'none';
            }
            
            // Show selected method details and generate account
            if (selectedMethod === 'xtrapay') {
                if (isMobile) {
                    document.getElementById('xtrapay-details-mobile').style.display = 'block';
                } else {
                    document.getElementById('xtrapay-details').style.display = 'block';
                }
            } else if (selectedMethod === 'payvibe') {
                if (isMobile) {
                    document.getElementById('payvibe-details-mobile').style.display = 'block';
                } else {
                    document.getElementById('payvibe-details').style.display = 'block';
                }
            }
            
            // Generate virtual account for selected method
            const selectedAmount = isMobile ? 
                handleAmountSelection(mobileAmountInputs, mobileCustomAmountInput, mobileSubmitBtn, true) :
                handleAmountSelection(desktopAmountInputs, desktopCustomAmountInput, desktopSubmitBtn);
            
            if (selectedAmount >= 1000) {
                generateVirtualAccount(isMobile ? 'mobile' : 'desktop', selectedMethod);
            }
        });
    });
    
    // Function to generate virtual account
    function generateVirtualAccount(layout, method = 'xtrapay') {
        const isPayVibe = method === 'payvibe';
        const accountInfoElement = layout === 'mobile' ? 
            (isPayVibe ? document.getElementById('payvibe-account-info-mobile') : document.getElementById('virtual-account-info-mobile')) : 
            (isPayVibe ? document.getElementById('payvibe-account-info') : document.getElementById('virtual-account-info'));
        
        if (!accountInfoElement) return;
        
        // Show loading state
        accountInfoElement.innerHTML = `
            <div class="text-center">
                <div class="spinner-border spinner-border-sm ${isPayVibe ? 'text-primary' : 'text-main'}" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <p class="mt-2 text-light small">Generating ${isPayVibe ? 'PayVibe' : 'virtual'} account...</p>
            </div>
        `;
        
        // Get selected amount
        const selectedAmount = layout === 'mobile' ? 
            handleAmountSelection(mobileAmountInputs, mobileCustomAmountInput, mobileSubmitBtn, true) :
            handleAmountSelection(desktopAmountInputs, desktopCustomAmountInput, desktopSubmitBtn);
        
        // Get charge info to calculate total amount
        fetch('{{ route("wallet.charge-info") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json'
            },
            credentials: 'same-origin',
            body: JSON.stringify({
                amount: selectedAmount,
                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            })
        })
        .then(response => response.json())
        .then(chargeData => {
            if (chargeData.success) {
                const totalAmount = chargeData.charge_info.total;
                
                // Make actual API call to generate virtual account with total amount
                const endpoint = isPayVibe ? '{{ route("wallet.generate-payvibe") }}' : '{{ route("wallet.generate-xtrapay") }}';
                return fetch(endpoint, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    },
                    credentials: 'same-origin',
                    body: JSON.stringify({
                        amount: selectedAmount, // Send base amount, backend will calculate total
                        _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    })
                });
            } else {
                throw new Error('Failed to calculate charges');
            }
        })
        .then(response => response.json())
        .then(data => {
            console.log('PayVibe API Response:', data); // Debug log
            
            if (data.success) {
                // Use real virtual account data from API
                const virtualAccount = {
                    account_number: data.accountNumber,
                    account_name: data.accountName,
                    bank_name: data.bank,
                    amount: data.amount
                };
                
                // Get charge info for display
                const chargeInfo = data.charge_info;
            
                // Update account info display
                if (layout === 'mobile') {
                    accountInfoElement.innerHTML = `
                        <div class="account-info">
                            <div class="account-label">Account Number</div>
                            <div class="account-value">${virtualAccount.account_number}</div>
                            <button class="copy-btn" onclick="copyToClipboard('${virtualAccount.account_number}')">
                                <i class="bi bi-copy me-1"></i>Copy
                            </button>
                        </div>
                        <div class="account-info">
                            <div class="account-label">Account Name</div>
                            <div class="account-value">${virtualAccount.account_name}</div>
                            <button class="copy-btn" onclick="copyToClipboard('${virtualAccount.account_name}')">
                                <i class="bi bi-copy me-1"></i>Copy
                            </button>
                        </div>
                        <div class="account-info">
                            <div class="account-label">Bank</div>
                            <div class="account-value">${virtualAccount.bank_name}</div>
                        </div>
                        <div class="account-info">
                            <div class="account-label">Base Amount</div>
                            <div class="account-value">${chargeInfo.formatted.base_amount}</div>
                        </div>
                        <div class="account-info">
                            <div class="account-label">Service Charge</div>
                            <div class="account-value text-info">${chargeInfo.formatted.charge}</div>
                        </div>
                        <div class="account-info">
                            <div class="account-label">Total to Transfer</div>
                            <div class="account-value text-success fw-bold">${chargeInfo.formatted.total_amount}</div>
                        </div>
                        <div class="account-info">
                            <div class="account-label">Payment Status</div>
                            <div class="account-value text-warning">Waiting for Payment</div>
                        </div>
                        <div class="mt-3">
                            <button class="submit-btn" onclick="confirmPayment('${data.reference}', '${selectedAmount}')" id="confirm-payment-btn">
                                <i class="bi bi-check-circle me-2"></i>I Have Paid
                            </button>
                            <div class="mt-2 text-center">
                                <small class="text-light">Click this button after you have made the transfer</small>
                            </div>
                        </div>
                    `;
                } else {
                    accountInfoElement.innerHTML = `
                        <div class="row gx-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-secondary">Account Number</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="${virtualAccount.account_number}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('${virtualAccount.account_number}')">
                                        <i class="bi bi-copy"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-secondary">Account Name</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" value="${virtualAccount.account_name}" readonly>
                                    <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('${virtualAccount.account_name}')">
                                        <i class="bi bi-copy"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="row gx-3">
                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-secondary">Bank</label>
                                <input type="text" class="form-control" value="${virtualAccount.bank_name}" readonly>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label small text-secondary">Amount to Transfer</label>
                                <input type="text" class="form-control" value="${chargeInfo.formatted.total_amount}" readonly>
                            </div>
                        </div>
                        <div class="alert alert-warning">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Important:</strong> Transfer exactly ${chargeInfo.formatted.total_amount} to avoid delays in crediting your wallet.
                        </div>
                        <div class="text-center">
                            <button class="btn btn-main" onclick="confirmPayment('${data.reference}', '${selectedAmount}')" id="confirm-payment-btn">
                                <i class="bi bi-check-circle me-2"></i>I Have Paid
                            </button>
                            <div class="mt-2">
                                <small class="text-secondary">Click this button after you have made the transfer</small>
                            </div>
                        </div>
                    `;
                }
            } else {
                // Show error message
                console.error('PayVibe API Error:', data);
                accountInfoElement.innerHTML = `
                    <div class="text-center">
                        <i class="bi bi-exclamation-triangle text-danger" style="font-size: 2rem;"></i>
                        <p class="mt-2 text-danger">Failed to generate account</p>
                        <p class="text-secondary small">${data.message || 'Please try again later'}</p>
                        <button class="btn btn-sm btn-outline-primary mt-2" onclick="generateVirtualAccount('${layout}', '${method}')">
                            <i class="bi bi-arrow-clockwise me-1"></i>Retry
                        </button>
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('PayVibe API Error:', error);
            accountInfoElement.innerHTML = `
                <div class="text-center">
                    <i class="bi bi-exclamation-triangle text-danger" style="font-size: 2rem;"></i>
                    <p class="mt-2 text-danger">Network Error</p>
                    <p class="text-secondary small">Please check your connection and try again</p>
                    <button class="btn btn-sm btn-outline-primary mt-2" onclick="generateVirtualAccount('${layout}', '${method}')">
                        <i class="bi bi-arrow-clockwise me-1"></i>Retry
                    </button>
                </div>
            `;
        });
    }
    
    // Form submission handlers
    if (mobileForm) {
        mobileForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const selectedAmount = handleAmountSelection(mobileAmountInputs, mobileCustomAmountInput, mobileSubmitBtn, true);
            
            if (selectedAmount < 1000) {
                showValidationErrorModal('Invalid Amount', 'Please select a valid amount (minimum ₦1,000)');
                return;
            }
            
            // Submit the form
            this.submit();
        });
    }
    
    if (desktopForm) {
        desktopForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const selectedAmount = handleAmountSelection(desktopAmountInputs, desktopCustomAmountInput, desktopSubmitBtn);
            
            if (selectedAmount < 1000) {
                showValidationErrorModal('Invalid Amount', 'Please select a valid amount (minimum ₦1,000)');
                return;
            }
            
            // Submit the form
            this.submit();
        });
    }
});

// Function to copy text to clipboard
function copyToClipboard(text) {
    // Try modern clipboard API first
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(function() {
            showCopySuccess();
        }).catch(function(err) {
            console.error('Clipboard API failed:', err);
            fallbackCopyTextToClipboard(text);
        });
    } else {
        // Fallback for older browsers or non-secure contexts
        fallbackCopyTextToClipboard(text);
    }
}

// Fallback copy method
function fallbackCopyTextToClipboard(text) {
    const textArea = document.createElement("textarea");
    textArea.value = text;
    
    // Avoid scrolling to bottom
    textArea.style.top = "0";
    textArea.style.left = "0";
    textArea.style.position = "fixed";
    textArea.style.opacity = "0";
    
    document.body.appendChild(textArea);
    textArea.focus();
    textArea.select();
    
    try {
        const successful = document.execCommand('copy');
        if (successful) {
            showCopySuccess();
        } else {
            showCopyError();
        }
    } catch (err) {
        console.error('Fallback copy failed:', err);
        showCopyError();
    }
    
    document.body.removeChild(textArea);
}

// Show success message
function showCopySuccess() {
    const button = event.target.closest('button');
    if (button) {
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bi bi-check"></i> Copied!';
        button.classList.remove('btn-outline-secondary', 'copy-btn');
        button.classList.add('btn-success');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-success');
            if (button.classList.contains('btn-outline-secondary')) {
                button.classList.add('btn-outline-secondary');
            } else {
                button.classList.add('copy-btn');
            }
        }, 2000);
    }
}

// Show error message
function showCopyError() {
    const button = event.target.closest('button');
    if (button) {
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="bi bi-exclamation"></i> Failed';
        button.classList.remove('btn-outline-secondary', 'copy-btn');
        button.classList.add('btn-danger');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('btn-danger');
            if (button.classList.contains('btn-outline-secondary')) {
                button.classList.add('btn-outline-secondary');
            } else {
                button.classList.add('copy-btn');
            }
        }, 2000);
    }
}

// Show validation error modal
function showValidationErrorModal(title, message) {
    const modal = `
        <div class="modal fade" id="validationErrorModal" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
                    <div class="modal-header bg-warning text-dark" style="background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%) !important; border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title">
                            <i class="bi bi-exclamation-triangle me-2"></i>${title}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="background: #ffffff; padding: 2rem;">
                        <div class="text-center mb-3">
                            <i class="bi bi-exclamation-triangle text-warning" style="font-size: 3rem; color: #ffc107;"></i>
                        </div>
                        <p class="text-center mb-0" style="color: #333333;">${message}</p>
                    </div>
                    <div class="modal-footer" style="background: #f8f9fa; border-radius: 0 0 15px 15px; border-top: 1px solid #dee2e6;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: #6c757d; border: none; border-radius: 8px;">
                            <i class="bi bi-x me-2"></i>Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('validationErrorModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to page
    document.body.insertAdjacentHTML('beforeend', modal);
    
    // Show modal
    const modalElement = document.getElementById('validationErrorModal');
    const bootstrapModal = new bootstrap.Modal(modalElement);
    bootstrapModal.show();
}

// Function to confirm payment and start status checking
function confirmPayment(reference, amount) {
    const confirmButton = document.getElementById('confirm-payment-btn');
    const originalText = confirmButton.innerHTML;
    
    // Update button to show checking status
    confirmButton.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Checking Payment...';
    confirmButton.disabled = true;
    confirmButton.classList.remove('btn-main', 'submit-btn');
    confirmButton.classList.add('btn-warning');
    
    // Show payment confirmation modal
    showPaymentConfirmationModal(reference, amount);
    
    // Start checking payment status after a short delay
    setTimeout(() => {
        checkPaymentStatus(reference, confirmButton, originalText);
    }, 1000);
}

// Function to check payment status
function checkPaymentStatus(reference, button, originalText) {
    console.log('Checking payment status for reference:', reference);
    
    fetch('{{ route("wallet.check-payment-status") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'Accept': 'application/json'
        },
        credentials: 'same-origin',
        body: JSON.stringify({
            reference: reference,
            _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            if (data.payment_status === 'paid') {
                // Payment successful - close confirmation modal first
                closePaymentConfirmationModal();
                
                // Update button
                button.innerHTML = '<i class="bi bi-check-circle me-2"></i>Payment Confirmed!';
                button.classList.remove('btn-warning');
                button.classList.add('btn-success');
                
                // Update payment status display
                updatePaymentStatusDisplay('Payment Confirmed', 'text-success');
                
                // Show success modal
                showPaymentSuccessModal(data.transaction_details);
                
                // Redirect to wallet after 3 seconds
                setTimeout(() => {
                    window.location.href = '{{ route("wallet.index") }}';
                }, 3000);
                
            } else if (data.payment_status === 'pending') {
                // Payment still pending, check again in 10 seconds
                button.innerHTML = '<i class="bi bi-clock me-2"></i>Payment Pending...';
                
                // Update confirmation modal status
                updateConfirmationModalStatus('Payment still pending...', 'info');
                
                setTimeout(() => {
                    checkPaymentStatus(reference, button, originalText);
                }, 10000); // Check again in 10 seconds
                
            } else {
                // Payment failed or other status - close confirmation modal first
                closePaymentConfirmationModal();
                
                // Update button
                button.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Payment Failed';
                button.classList.remove('btn-warning');
                button.classList.add('btn-danger');
                button.disabled = false;
                
                updatePaymentStatusDisplay('Payment Failed', 'text-danger');
                
                // Show error modal
                showPaymentErrorModal('Payment Failed', data.message || 'Payment verification failed. Please try again or contact support.');
            }
        } else {
            // API error - close confirmation modal first
            closePaymentConfirmationModal();
            
            // Update button
            button.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Check Failed';
            button.classList.remove('btn-warning');
            button.classList.add('btn-danger');
            button.disabled = false;
            
            showPaymentErrorModal('Status Check Error', data.message || 'Error checking payment status. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error checking payment status:', error);
        
        // Close confirmation modal first
        closePaymentConfirmationModal();
        
        // Update button
        button.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Check Failed';
        button.classList.remove('btn-warning');
        button.classList.add('btn-danger');
        button.disabled = false;
        
        showPaymentErrorModal('Status Check Error', 'Error checking payment status. Please try again or contact support if you have already made the transfer.');
    });
}

// Function to update payment status display
function updatePaymentStatusDisplay(status, textClass) {
    // Update mobile status
    const mobileStatusElement = document.querySelector('.account-info .account-value.text-warning');
    if (mobileStatusElement) {
        mobileStatusElement.textContent = status;
        mobileStatusElement.className = `account-value ${textClass}`;
    }
    
    // Update desktop status
    const desktopStatusElement = document.querySelector('input[value="Waiting for Payment"]');
    if (desktopStatusElement) {
        desktopStatusElement.value = status;
        desktopStatusElement.className = `form-control ${textClass}`;
    }
}

// Function to show payment confirmation modal
function showPaymentConfirmationModal(reference, amount) {
    const modal = `
        <div class="modal fade" id="paymentConfirmationModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" style="background: rgba(0, 0, 0, 0.8);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5); border: 2px solid #17a2b8;">
                    <div class="modal-header bg-info text-white" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%) !important; border-radius: 15px 15px 0 0; border-bottom: 2px solid #17a2b8;">
                        <h5 class="modal-title">
                            <i class="bi bi-info-circle me-2"></i>Payment Confirmation
                        </h5>
                        <!-- Remove close button to prevent manual closing -->
                    </div>
                    <div class="modal-body" style="background: #ffffff; padding: 2rem;">
                        <div class="text-center mb-3">
                            <i class="bi bi-check-circle text-info" style="font-size: 3rem; color: #17a2b8;"></i>
                        </div>
                        <h6 class="text-center mb-3" style="color: #333333;">Thank you for confirming your payment!</h6>
                        <p class="text-center mb-3" style="color: #666666;">We are now checking your payment status. This may take a few moments.</p>
                        <div class="alert alert-info" style="background: #d1ecf1; border: 2px solid #bee5eb; color: #0c5460; border-radius: 10px;">
                            <strong>Reference:</strong> ${reference}<br>
                            <strong>Amount:</strong> ₦${parseInt(amount).toLocaleString()}
                        </div>
                        <div class="text-center mt-3">
                            <div class="spinner-border text-info" role="status" style="width: 2rem; height: 2rem;">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            <p class="mt-2 mb-0" style="color: #666666;">Checking payment status...</p>
                        </div>
                        <p class="text-center small text-muted mt-3">
                            <strong>Please wait:</strong> This modal will automatically close when payment is confirmed or if there's an issue.
                        </p>
                    </div>
                    <div class="modal-footer" style="background: #f8f9fa; border-radius: 0 0 15px 15px; border-top: 2px solid #dee2e6;">
                        <button type="button" class="btn btn-secondary" onclick="closePaymentConfirmationModal()" style="background: #6c757d; border: none; border-radius: 8px;">
                            <i class="bi bi-x me-2"></i>Cancel Check
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('paymentConfirmationModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to page
    document.body.insertAdjacentHTML('beforeend', modal);
    
    // Show modal
    const modalElement = document.getElementById('paymentConfirmationModal');
    const bootstrapModal = new bootstrap.Modal(modalElement);
    bootstrapModal.show();
}

// Function to show payment success modal
function showPaymentSuccessModal(transactionDetails) {
    const modal = `
        <div class="modal fade" id="paymentSuccessModal" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
                    <div class="modal-header bg-success text-white" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%) !important; border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title">
                            <i class="bi bi-check-circle me-2"></i>Payment Successful!
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="background: #ffffff; padding: 2rem;">
                        <div class="text-center mb-3">
                            <i class="bi bi-check-circle text-success" style="font-size: 3rem; color: #28a745;"></i>
                        </div>
                        <h6 class="text-center mb-3" style="color: #333333;">Your wallet has been credited successfully!</h6>
                        <div class="alert alert-success" style="background: #d4edda; border: 1px solid #c3e6cb; color: #155724; border-radius: 10px;">
                            <strong>Amount Added:</strong> ₦${transactionDetails.amount}<br>
                            <strong>New Balance:</strong> ₦${transactionDetails.new_balance}<br>
                            <strong>Transaction ID:</strong> ${transactionDetails.transaction_id}
                        </div>
                        <p class="text-center small text-muted">
                            You will be redirected to your wallet in a few seconds...
                        </p>
                    </div>
                    <div class="modal-footer" style="background: #f8f9fa; border-radius: 0 0 15px 15px; border-top: 1px solid #dee2e6;">
                        <button type="button" class="btn btn-success" onclick="window.location.href='{{ route('wallet.index') }}'" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border: none; border-radius: 8px;">
                            <i class="bi bi-wallet me-2"></i>Go to Wallet
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('paymentSuccessModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to page
    document.body.insertAdjacentHTML('beforeend', modal);
    
    // Show modal
    const modalElement = document.getElementById('paymentSuccessModal');
    const bootstrapModal = new bootstrap.Modal(modalElement);
    bootstrapModal.show();
}

// Function to show payment error modal
function showPaymentErrorModal(title, message) {
    const modal = `
        <div class="modal fade" id="paymentErrorModal" tabindex="-1" style="background: rgba(0, 0, 0, 0.5);">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="background: #ffffff; border-radius: 15px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);">
                    <div class="modal-header bg-danger text-white" style="background: linear-gradient(135deg, #dc3545 0%, #c82333 100%) !important; border-radius: 15px 15px 0 0;">
                        <h5 class="modal-title">
                            <i class="bi bi-exclamation-triangle me-2"></i>${title}
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body" style="background: #ffffff; padding: 2rem;">
                        <div class="text-center mb-3">
                            <i class="bi bi-exclamation-triangle text-danger" style="font-size: 3rem; color: #dc3545;"></i>
                        </div>
                        <p class="text-center mb-0" style="color: #333333;">${message}</p>
                    </div>
                    <div class="modal-footer" style="background: #f8f9fa; border-radius: 0 0 15px 15px; border-top: 1px solid #dee2e6;">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background: #6c757d; border: none; border-radius: 8px;">
                            <i class="bi bi-x me-2"></i>Close
                        </button>
                        <button type="button" class="btn btn-warning" onclick="retryPaymentCheck()" style="background: linear-gradient(135deg, #ffc107 0%, #ffb300 100%); border: none; border-radius: 8px; color: #000000;">
                            <i class="bi bi-arrow-clockwise me-2"></i>Try Again
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Remove existing modal if any
    const existingModal = document.getElementById('paymentErrorModal');
    if (existingModal) {
        existingModal.remove();
    }
    
    // Add modal to page
    document.body.insertAdjacentHTML('beforeend', modal);
    
    // Show modal
    const modalElement = document.getElementById('paymentErrorModal');
    const bootstrapModal = new bootstrap.Modal(modalElement);
    bootstrapModal.show();
}

// Function to close payment confirmation modal
function closePaymentConfirmationModal() {
    const confirmationModal = document.getElementById('paymentConfirmationModal');
    if (confirmationModal) {
        const bootstrapModal = bootstrap.Modal.getInstance(confirmationModal);
        if (bootstrapModal) {
            bootstrapModal.hide();
        }
    }
}

// Function to update confirmation modal status
function updateConfirmationModalStatus(message, type) {
    const modal = document.getElementById('paymentConfirmationModal');
    if (modal) {
        const statusElement = modal.querySelector('.spinner-border').parentElement.querySelector('p');
        if (statusElement) {
            statusElement.textContent = message;
            statusElement.style.color = type === 'info' ? '#17a2b8' : '#dc3545';
        }
    }
}

// Function to retry payment check
function retryPaymentCheck() {
    // Close error modal
    const errorModal = document.getElementById('paymentErrorModal');
    if (errorModal) {
        const bootstrapModal = bootstrap.Modal.getInstance(errorModal);
        bootstrapModal.hide();
    }
    
    // Get the confirm payment button and retry
    const confirmButton = document.getElementById('confirm-payment-btn');
    if (confirmButton) {
        // Extract reference from button onclick attribute
        const onclickAttr = confirmButton.getAttribute('onclick');
        const match = onclickAttr.match(/confirmPayment\('([^']+)', '([^']+)'\)/);
        if (match) {
            const reference = match[1];
            const amount = match[2];
            confirmPayment(reference, amount);
        }
    }
}
</script>

@endsection 
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

/* Transaction cards specific styling */
.transaction-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.22) 0%,rgb(0, 0, 0) 100%) !important;
}

.transaction-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
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

/* Info card styling */
.info-card {
    background: linear-gradient(135deg,rgba(16, 16, 19, 0.22) 0%,rgb(0, 0, 0) 100%) !important;
}

/* Light theme info card styling */
[data-theme="light"] .info-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 20px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .info-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-2px);
}

/* Text color fixes for dark theme */
.text-theme-1 { color: #ffffff !important; }
.text-secondary { color: #b0b0b0 !important; }
.welcome-label { color: #b0b0b0 !important; }
.welcome-username { color: #ffffff !important; }

/* Light theme text color overrides */
[data-theme="light"] .text-theme-1 { color: #000000 !important; }
[data-theme="light"] .text-secondary { color: rgba(0, 0, 0, 0.6) !important; }
[data-theme="light"] .welcome-label { color: rgba(0, 0, 0, 0.6) !important; }
[data-theme="light"] .welcome-username { color: #000000 !important; }

/* Button styling */
.btn-theme {
    background: linear-gradient(135deg,rgb(24, 22, 20) 0%,rgba(11, 12, 16, 0.57) 100%) !important;
    border: none !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
    border-radius: 20px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.33) !important;
}

.btn-theme:hover {
    background: linear-gradient(135deg, #ff7300 0%, #ff6b35 100%) !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(255,152,0,0.4) !important;
}

/* Light theme button styling */
[data-theme="light"] .btn-theme {
    background: linear-gradient(135deg, #036674 0%, #0d8a9c 100%) !important;
    border: none !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
    border-radius: 20px !important;
    box-shadow: 0 4px 15px rgba(3, 102, 116, 0.3) !important;
}

[data-theme="light"] .btn-theme:hover {
    background: linear-gradient(135deg, #0d8a9c 0%, #036674 100%) !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(3, 102, 116, 0.4) !important;
}

/* Outline button styling for light theme */
[data-theme="light"] .btn-outline-theme {
    background: transparent !important;
    border: 2px solid #036674 !important;
    color: #036674 !important;
    transition: all 0.3s ease;
    border-radius: 20px !important;
}

[data-theme="light"] .btn-outline-theme:hover {
    background: #036674 !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(3, 102, 116, 0.3) !important;
}

/* Status indicator styling */
.status-indicator {
    width: 8px;
    height: 8px;
    border-radius: 50%;
    display: inline-block;
    margin-right: 8px;
}

.status-completed { background-color: #28a745; }
.status-pending { background-color: #ffc107; }
.status-failed { background-color: #dc3545; }

/* Light theme status indicators */
[data-theme="light"] .status-completed { background-color: #28a745; }
[data-theme="light"] .status-pending { background-color: #ffc107; }
[data-theme="light"] .status-failed { background-color: #dc3545; }

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

.transaction-title {
    font-size: 0.85rem !important;
    font-weight: 500 !important;
    color: var(--text-primary) !important;
}

.transaction-description {
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

[data-theme="light"] .transaction-title {
    color: #000000 !important;
}

[data-theme="light"] .transaction-description {
    color: rgba(0, 0, 0, 0.7) !important;
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

/* Breadcrumb styling */
.breadcrumb {
    background: transparent !important;
    padding: 0 !important;
    margin: 0 !important;
}

.breadcrumb-item a {
    color: var(--text-secondary) !important;
    text-decoration: none !important;
    transition: color 0.3s ease;
}

.breadcrumb-item a:hover {
    color: var(--text-primary) !important;
}

.breadcrumb-item.active {
    color: var(--text-primary) !important;
}

/* Light theme breadcrumb */
[data-theme="light"] .breadcrumb-item a {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .breadcrumb-item a:hover {
    color: #000000 !important;
}

[data-theme="light"] .breadcrumb-item.active {
    color: #000000 !important;
}

/* Avatar styling for transaction header */
.avatar-80 {
    width: 80px !important;
    height: 80px !important;
    border-radius: 20px !important;
    display: flex !important;
    align-items: center !important;
    justify-content: center !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2) !important;
}

[data-theme="light"] .avatar-80 {
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

/* Badge styling */
.badge {
    font-size: 0.75rem !important;
    font-weight: 500 !important;
    padding: 0.375rem 0.75rem !important;
    border-radius: 10px !important;
}

/* Fix status badge text colors for light theme */
[data-theme="light"] .badge.bg-success {
    color: #ffffff !important;
}

[data-theme="light"] .badge.bg-warning {
    color: #000000 !important;
}

[data-theme="light"] .badge.bg-danger {
    color: #ffffff !important;
}

[data-theme="light"] .badge.bg-secondary {
    color: #ffffff !important;
}

[data-theme="light"] .badge.bg-info {
    color: #ffffff !important;
}

/* Mobile padding */
@media (max-width: 768px) {
    .container { padding: 0 15px; }
    
    .avatar-80 {
        width: 60px !important;
        height: 60px !important;
    }
    
    .avatar-80 i {
        font-size: 1.5rem !important;
    }
}
</style>

<!-- breadcrumb -->
<div class="container mt-3">
    <div class="row gx-1 align-items-center">
        <div class="col col-sm mb-3 mb-md-0">
            <nav aria-label="breadcrumb" class="mb-1">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item bi"><a href="{{ route('home') }}"><i class="bi bi-house-door"></i> Home</a></li>
                    <li class="breadcrumb-item bi"><a href="{{ route('wallet.index') }}"><i class="bi bi-wallet2"></i> Wallet</a></li>
                    <li class="breadcrumb-item bi"><a href="{{ route('wallet.transactions') }}"><i class="bi bi-clock-history"></i> Transactions</a></li>
                    <li class="breadcrumb-item active bi" aria-current="page">Details</li>
                </ol>
            </nav>
            <h5 class="page-title">Transaction Details</h5>
        </div>
        <div class="col-auto mb-3 mb-md-0">
            <a href="{{ route('wallet.transactions') }}" class="btn btn-square btn-theme"><i class="bi bi-arrow-left"></i></a>
        </div>
    </div>
</div>

<!-- content -->
<div class="container mt-3 mt-lg-4 mt-xl-5" id="main-content">
    <!-- Transaction Header -->
    <div class="row gx-3 mb-4">
        <div class="col-12">
            <div class="card adminuiux-card header-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <div class="avatar avatar-80 rounded {{ $transaction->type === 'credit' ? 'bg-success' : 'bg-danger' }} d-flex align-items-center justify-content-center">
                                <i class="bi {{ $transaction->type === 'credit' ? 'bi-arrow-up' : 'bi-arrow-down' }} h1 text-white"></i>
                            </div>
                        </div>
                        <div class="col">
                            <h4 class="fw-bold transaction-title mb-1">{{ $transaction->description }}</h4>
                            <p class="transaction-description mb-2">Transaction #{{ $transaction->id }}</p>
                            <div class="d-flex align-items-center">
                                <span class="status-indicator status-{{ $transaction->status }}"></span>
                                <span class="{{ $transaction->status_badge_class }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </div>
                        </div>
                        <div class="col-auto text-end">
                            <h3 class="fw-bold {{ $transaction->type === 'credit' ? 'text-success' : 'text-danger' }} mb-1">
                                {{ $transaction->formatted_amount }}
                            </h3>
                            <p class="transaction-description mb-0">{{ $transaction->type === 'credit' ? 'Credit' : 'Debit' }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Information -->
    <div class="row gx-3 mb-4">
        <div class="col-12 col-md-6">
            <div class="card adminuiux-card info-card">
                <div class="card-header">
                    <h6 class="mb-0 transaction-title">
                        <i class="bi bi-info-circle me-2"></i>
                        Transaction Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row gx-3">
                        <div class="col-6 mb-3">
                            <p class="small transaction-description mb-1">Transaction ID</p>
                            <p class="fw-bold transaction-title mb-0">#{{ $transaction->id }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <p class="small transaction-description mb-1">Date & Time</p>
                            <p class="fw-bold transaction-title mb-0">{{ $transaction->created_at->format('M d, Y') }}</p>
                            <small class="transaction-description">{{ $transaction->created_at->format('g:i A') }}</small>
                        </div>
                        <div class="col-6 mb-3">
                            <p class="small transaction-description mb-1">Type</p>
                            <span class="badge {{ $transaction->type === 'credit' ? 'bg-success' : 'bg-danger' }}">
                                {{ $transaction->type === 'credit' ? 'Credit' : 'Debit' }}
                            </span>
                        </div>
                        <div class="col-6 mb-3">
                            <p class="small transaction-description mb-1">Status</p>
                            <span class="{{ $transaction->status_badge_class }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                        <div class="col-12">
                            <p class="small transaction-description mb-1">Description</p>
                            <p class="fw-bold transaction-title mb-0">{{ $transaction->description }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-12 col-md-6">
            <div class="card adminuiux-card info-card">
                <div class="card-header">
                    <h6 class="mb-0 transaction-title">
                        <i class="bi bi-calculator me-2"></i>
                        Financial Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row gx-3">
                        <div class="col-12 mb-3">
                            <p class="small transaction-description mb-1">Amount</p>
                            <h4 class="fw-bold {{ $transaction->type === 'credit' ? 'text-success' : 'text-danger' }} mb-0">
                                {{ $transaction->formatted_amount }}
                            </h4>
                        </div>
                        <div class="col-6 mb-3">
                            <p class="small transaction-description mb-1">Balance Before</p>
                            <p class="fw-bold transaction-title mb-0">₦{{ number_format($transaction->balance_before, 2) }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <p class="small transaction-description mb-1">Balance After</p>
                            <p class="fw-bold transaction-title mb-0">₦{{ number_format($transaction->balance_after, 2) }}</p>
                        </div>
                        @if($transaction->reference_type)
                        <div class="col-6 mb-3">
                            <p class="small transaction-description mb-1">Reference Type</p>
                            <p class="fw-bold transaction-title mb-0">{{ ucfirst($transaction->reference_type) }}</p>
                        </div>
                        <div class="col-6 mb-3">
                            <p class="small transaction-description mb-1">Reference ID</p>
                            <p class="fw-bold transaction-title mb-0">{{ $transaction->reference_id ?? 'N/A' }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row gx-3">
        <div class="col-12">
            <div class="d-flex flex-column flex-md-row gap-3 justify-content-center">
                <a href="{{ route('wallet.transactions') }}" class="btn btn-outline-theme flex-fill">
                    <i class="bi bi-clock-history me-2"></i>
                    View All Transactions
                </a>
                <a href="{{ route('wallet.index') }}" class="btn btn-theme flex-fill">
                    <i class="bi bi-wallet2 me-2"></i>
                    Back to Wallet
                </a>
            </div>
        </div>
    </div>
</div>

@endsection 
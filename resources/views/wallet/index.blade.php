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
    
    .wallet-header {
        background: linear-gradient(135deg, rgb(19, 16, 16) 0%, rgb(0, 0, 0) 100%) !important;
        border: none !important;
        border-radius: 20px;
        padding: 1rem;
        margin-bottom: 0.75rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
    }
    
    .wallet-balance {
        font-size: 1.8rem !important;
        font-weight: 700;
        color: #ffffff !important;
        margin-bottom: 0.5rem;
    }
    
    .wallet-label {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.8) !important;
        margin-bottom: 0.5rem;
    }
    
    .stats-row {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }
    
    .stat-item {
        flex: 1;
        background: linear-gradient(135deg, rgb(19, 16, 16) 0%, rgb(0, 0, 0) 100%) !important;
        border: none !important;
        border-radius: 20px;
        padding: 0.6rem 0.4rem;
        text-align: center;
    }
    
    .stat-value {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 0.2rem;
    }
    
    .stat-label {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.7) !important;
    }
    
    .action-buttons {
        display: flex;
        gap: 0.5rem;
        margin-bottom: 0.75rem;
    }
    
    .action-btn {
        flex: 1;
        background: linear-gradient(135deg, rgb(19, 16, 16) 0%, rgb(0, 0, 0) 100%) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 20px;
        padding: 0.75rem 0.4rem;
        font-size: 0.85rem;
        font-weight: 500;
        text-decoration: none !important;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
    }
    
    .action-btn:hover {
        background: linear-gradient(135deg, rgb(0, 0, 0) 0%, rgb(19, 16, 16) 100%) !important;
        color: #ffffff !important;
        transform: translateY(-1px);
        box-shadow: 0 6px 20px rgba(0,0,0,0.4) !important;
    }
    
    .action-btn i {
        display: block;
        font-size: 1.2rem;
        margin-bottom: 0.2rem;
        color: #ffffff !important;
    }
    
    .card {
        border: none !important;
        margin-bottom: 0.75rem !important;
        background: linear-gradient(135deg, rgb(19, 16, 16) 0%, rgb(0, 0, 0) 100%) !important;
        backdrop-filter: blur(10px) !important;
        border-radius: 20px !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
    }
    
    .card-body {
        padding: 0.75rem !important;
    }
    
    .card-header {
        padding: 0.75rem !important;
        border-bottom: 1px solid rgba(255,255,255,0.1) !important;
        background: transparent !important;
    }
    
    .transaction-item {
        display: flex;
        align-items: center;
        padding: 0.6rem;
        border-bottom: 1px solid rgba(255,255,255,0.1);
        text-decoration: none;
        color: inherit;
    }
    
    .transaction-item:last-child {
        border-bottom: none;
    }
    
    .transaction-icon {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 0.75rem;
        font-size: 0.8rem;
    }
    
    .transaction-details {
        flex: 1;
    }
    
    .transaction-time {
        font-size: 0.85rem;
        font-weight: 500;
        margin-bottom: 0.2rem;
        color: #ffffff !important;
    }
    
    .transaction-date {
        font-size: 0.75rem;
        color: rgba(255,255,255,0.6) !important;
    }
    
    .transaction-amount {
        font-size: 0.95rem;
        font-weight: 600;
        text-align: right;
    }
    
    .transaction-status {
        font-size: 0.75rem;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        margin-top: 0.2rem;
    }
    
    .section-header {
        font-size: 0.95rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        color: #004953 !important;
    }
    
    .view-all-link {
        font-size: 0.8rem !important;
        color: #004953 !important;
        text-decoration: none !important;
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
    
    /* Additional overrides for template CSS */
    .adminuiux-mobile-footer,
    .adminuiux-mobile-footer *,
    .mobile-container,
    .mobile-container *,
    .template-container,
    .template-container *,
    .ecommerce-footer,
    .ecommerce-footer * {
        background-color: transparent !important;
    }
    
    /* Force remove all backgrounds from template */
    *[style*="background"] {
        background: transparent !important;
    }
    
    /* Override any inline styles */
    [style*="background-color"] {
        background-color: transparent !important;
    }
    
    .view-all-link:hover {
        color: #005a66 !important;
    }
    
    .empty-state {
        text-align: center;
        padding: 1.5rem 0.75rem;
    }
    
    .empty-state i {
        font-size: 2rem;
        color: rgba(255,255,255,0.4);
        margin-bottom: 0.75rem;
    }
    
    .empty-state p {
        font-size: 0.85rem;
        color: rgba(255,255,255,0.6);
        margin-bottom: 0.75rem;
    }
    
    .empty-state .btn {
        font-size: 0.85rem;
        padding: 0.5rem 1rem;
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
    
    /* Override mobile footer background for wallet page */
    .adminuiux-mobile-footer {
        background: rgba(0, 0, 0, 0.9) !important;
        backdrop-filter: blur(10px) !important;
    }
    
    .adminuiux-mobile-footer .nav-link {
        color: rgba(255, 255, 255, 0.7) !important;
    }
    
    .adminuiux-mobile-footer .nav-link.active {
        color: #004953 !important;
    }
    
    .adminuiux-mobile-footer .nav-link:hover {
        color: #004953 !important;
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

.wallet-intro {
    background: linear-gradient(135deg, rgb(19, 16, 16) 0%, rgb(0, 0, 0) 100%) !important;
    border: none !important;
    border-radius: 20px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
}

.wallet-intro h4 {
    color: #004953;
    margin-bottom: 0.75rem;
    font-weight: 600;
}

.wallet-intro p {
    color: rgba(255,255,255,0.8);
    margin-bottom: 1rem;
    line-height: 1.6;
}

.wallet-features {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
}

.wallet-feature {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: rgba(255,255,255,0.7);
    font-size: 0.9rem;
}

.wallet-feature i {
    color: #004953;
    font-size: 1rem;
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

/* Light theme styling for wallet page */
[data-theme="light"] .wallet-header {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .wallet-balance {
    color: #000000 !important;
}

[data-theme="light"] .wallet-label {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .stat-item {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .stat-value {
    color: #000000 !important;
}

[data-theme="light"] .stat-label {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .action-btn {
    background: #036674 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(3, 102, 116, 0.2) !important;
}

[data-theme="light"] .action-btn:hover {
    background: #025a66 !important;
    box-shadow: 0 6px 20px rgba(3, 102, 116, 0.3) !important;
}

[data-theme="light"] .action-btn i {
    color: #ffffff !important;
}

[data-theme="light"] .card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .card-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
    background: #036674 !important;
    color: #ffffff !important;
    border-radius: 20px 20px 0 0 !important;
}

[data-theme="light"] .transaction-item {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #000000 !important;
}

[data-theme="light"] .transaction-time {
    color: #000000 !important;
}

/* Fix status badge text colors for light theme */
[data-theme="light"] .badge.bg-success {
    color: #000000 !important;
}

[data-theme="light"] .badge.bg-warning {
    color: #000000 !important;
}

[data-theme="light"] .badge.bg-danger {
    color: #000000 !important;
}

[data-theme="light"] .badge.bg-secondary {
    color: #ffffff !important;
}

[data-theme="light"] .badge.bg-info {
    color: #ffffff !important;
}

/* Strongest possible overrides for all badge types */
[data-theme="light"] .badge.bg-danger,
[data-theme="light"] span.badge.bg-danger,
[data-theme="light"] .badge.bg-danger *,
[data-theme="light"] span.badge.bg-danger * {
    color: #ffffff !important;
}

[data-theme="light"] .badge.bg-success,
[data-theme="light"] span.badge.bg-success,
[data-theme="light"] .badge.bg-success *,
[data-theme="light"] span.badge.bg-success * {
    color: #ffffff !important;
}

[data-theme="light"] .badge.bg-warning,
[data-theme="light"] span.badge.bg-warning,
[data-theme="light"] .badge.bg-warning *,
[data-theme="light"] span.badge.bg-warning * {
    color: #000000 !important;
}

[data-theme="light"] .badge.bg-secondary,
[data-theme="light"] span.badge.bg-secondary,
[data-theme="light"] .badge.bg-secondary *,
[data-theme="light"] span.badge.bg-secondary * {
    color: #ffffff !important;
}

[data-theme="light"] .badge.bg-info,
[data-theme="light"] span.badge.bg-info,
[data-theme="light"] .badge.bg-info *,
[data-theme="light"] span.badge.bg-info * {
    color: #ffffff !important;
}

[data-theme="light"] .transaction-date {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .transaction-amount {
    color: #000000 !important;
}

[data-theme="light"] .section-header {
    color: #036674 !important;
}

[data-theme="light"] .view-all-link {
    color: #036674 !important;
}

[data-theme="light"] .view-all-link:hover {
    color: #025a66 !important;
}

[data-theme="light"] .empty-state i {
    color: rgba(0, 0, 0, 0.4) !important;
}

[data-theme="light"] .empty-state p {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .breadcrumb-item a {
    color: #000000 !important;
}

[data-theme="light"] .breadcrumb-item.active {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .wallet-intro {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .wallet-intro h4 {
    color: #036674 !important;
}

[data-theme="light"] .wallet-intro p {
    color: rgba(0, 0, 0, 0.8) !important;
}

/* Light theme mobile footer */
[data-theme="light"] .adminuiux-mobile-footer {
    background: rgba(255, 255, 255, 0.9) !important;
}

[data-theme="light"] .adminuiux-mobile-footer .nav-link {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .adminuiux-mobile-footer .nav-link.active {
    color: #036674 !important;
}

[data-theme="light"] .adminuiux-mobile-footer .nav-link:hover {
    color: #036674 !important;
}

/* Light theme button overrides for wallet page */
[data-theme="light"] .btn-main {
    background-color: #036674 !important;
    border-color: #036674 !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-main:hover {
    background-color: #025a66 !important;
    border-color: #025a66 !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-outline-main {
    color: #036674 !important;
    border-color: #036674 !important;
    background-color: transparent !important;
}

[data-theme="light"] .btn-outline-main:hover {
    color: #ffffff !important;
    background-color: #036674 !important;
}

/* Light theme wallet features text */
[data-theme="light"] .wallet-features {
    color: rgba(0, 0, 0, 0.8) !important;
}

[data-theme="light"] .wallet-feature {
    color: rgba(0, 0, 0, 0.8) !important;
}

[data-theme="light"] .wallet-feature span {
    color: rgba(0, 0, 0, 0.8) !important;
}

[data-theme="light"] .wallet-feature i {
    color: #036674 !important;
}
    border-color: #036674 !important;
}

[data-theme="light"] .btn-outline-secondary {
    color: #6c757d !important;
    border-color: #6c757d !important;
    background-color: transparent !important;
}

[data-theme="light"] .btn-outline-secondary:hover {
    color: #ffffff !important;
    background-color: #6c757d !important;
    border-color: #6c757d !important;
}
</style>

<div class="container">
    <div class="mobile-only d-md-none">
        <!-- Compact Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i class="bi bi-house-door"></i></a></li>
                <li class="breadcrumb-item active">Wallet</li>
            </ol>
        </nav>
        
        <!-- Compact Wallet Header -->
        <div class="wallet-header">
            <div class="wallet-label">Balance</div>
            <div class="wallet-balance">{{ $wallet->formatted_balance }}</div>
            <div class="wallet-label">{{ Auth::user()->name }}</div>
        </div>
        
        <!-- Compact Stats Row -->
        <div class="stats-row">
            <div class="stat-item">
                <div class="stat-value text-accent-green">₦{{ number_format($stats['total_credits'], 0) }}</div>
                <div class="stat-label">Added</div>
            </div>
            <div class="stat-item">
                <div class="stat-value text-accent-red">₦{{ number_format($stats['total_debits'], 0) }}</div>
                <div class="stat-label">Spent</div>
            </div>
            <div class="stat-item">
                <div class="stat-value text-main">{{ $stats['transaction_count'] }}</div>
                <div class="stat-label">Txns</div>
            </div>
        </div>
        
        <!-- Compact Action Buttons -->
        <div class="action-buttons">
            <a href="{{ route('wallet.add-funds') }}" class="action-btn">
                <i class="bi bi-plus-circle"></i>Add
            </a>
            <a href="{{ route('wallet.transactions') }}" class="action-btn">
                <i class="bi bi-clock-history"></i>History
            </a>
            <a href="{{ route('customize.index') }}" class="action-btn">
                <i class="bi bi-cart"></i>Shop
            </a>
        </div>
        
        <!-- Compact Recent Transactions -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 section-header"><i class="bi bi-clock me-1"></i>Recent</h6>
                <a href="{{ route('wallet.transactions') }}" class="view-all-link">All</a>
            </div>
            <div class="card-body p-0">
                @if($recentTransactions->count() > 0)
                    @foreach($recentTransactions->take(3) as $transaction)
                    <a href="{{ route('wallet.transaction-details', $transaction->id) }}" class="transaction-item">
                        <div class="transaction-icon {{ $transaction->type === 'credit' ? 'bg-accent-green' : 'bg-accent-red' }}">
                            <i class="bi {{ $transaction->type === 'credit' ? 'bi-arrow-up' : 'bi-arrow-down' }} text-white"></i>
                        </div>
                        <div class="transaction-details">
                            <div class="transaction-time">{{ $transaction->created_at->format('g:i A') }}</div>
                            <div class="transaction-date">{{ $transaction->created_at->format('M d') }}</div>
                            <span class="transaction-status {{ $transaction->status_badge_class }}">
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </div>
                        <div class="transaction-amount {{ $transaction->type === 'credit' ? 'text-accent-green' : 'text-accent-red' }}">
                            {{ $transaction->formatted_amount }}
                        </div>
                    </a>
                    @endforeach
                @else
                    <div class="empty-state">
                        <i class="bi bi-inbox"></i>
                        <p>No transactions yet</p>
                        <a href="{{ route('wallet.add-funds') }}" class="btn btn-sm btn-main">Add Funds</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Desktop Layout -->
    <div class="desktop-only d-none d-md-block">
        <div class="row gx-1 align-items-center mb-4">
            <div class="col col-sm">
                <nav aria-label="breadcrumb" class="mb-1">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item bi"><a href="{{ route('home') }}"><i class="bi bi-house-door"></i> Home</a></li>
                        <li class="breadcrumb-item active bi" aria-current="page">Wallet</li>
                    </ol>
                </nav>
                <h4 class="mb-0">My Wallet</h4>
            </div>
            <div class="col-auto">
                <a href="{{ route('wallet.add-funds') }}" class="btn btn-main">
                    <i class="bi bi-plus me-2"></i>Add Funds
                </a>
            </div>
        </div>

        <!-- Wallet Introduction (Desktop Only) -->
        <div class="wallet-intro">
            <h4><i class="bi bi-wallet2 me-2"></i>Welcome to Your Digital Wallet</h4>
            <p>Your Bubblemart wallet is your secure digital payment hub. Add funds, track transactions, and manage your spending all in one place. Enjoy seamless shopping with instant balance updates and detailed transaction history.</p>
            <div class="wallet-features">
                <div class="wallet-feature">
                    <i class="bi bi-shield-check"></i>
                    <span>Secure Transactions</span>
                </div>
                <div class="wallet-feature">
                    <i class="bi bi-lightning"></i>
                    <span>Instant Updates</span>
                </div>
                <div class="wallet-feature">
                    <i class="bi bi-graph-up"></i>
                    <span>Track Spending</span>
                </div>
                <div class="wallet-feature">
                    <i class="bi bi-clock-history"></i>
                    <span>Full History</span>
                </div>
            </div>
        </div>

        <div class="row gx-4">
            <div class="col-12 col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row gx-1 align-items-center">
                            <div class="col">
                                <h5 class="mb-0"><i class="bi bi-cash-stack me-2"></i>Wallet Balance</h5>
                            </div>
                            <div class="col-auto">
                                <a href="{{ route('wallet.add-funds') }}" class="btn btn-sm btn-main">
                                    <i class="bi bi-plus me-1"></i>Add Funds
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gx-4 align-items-center">
                            <div class="col">
                                <h2 class="mb-2 text-main">{{ $wallet->formatted_balance }}</h2>
                                <p class="mb-0 text-secondary">{{ Auth::user()->name }}'s Wallet Balance</p>
                            </div>
                            <div class="col-auto">
                                <div class="row gx-4 text-center">
                                    <div class="col">
                                        <div class="text-accent-green fw-bold h5">₦{{ number_format($stats['total_credits'], 0) }}</div>
                                        <small class="text-secondary">Total Added</small>
                                    </div>
                                    <div class="col">
                                        <div class="text-accent-red fw-bold h5">₦{{ number_format($stats['total_debits'], 0) }}</div>
                                        <small class="text-secondary">Total Spent</small>
                                    </div>
                                    <div class="col">
                                        <div class="text-main fw-bold h5">{{ $stats['transaction_count'] }}</div>
                                        <small class="text-secondary">Transactions</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Transactions</h5>
                        <a href="{{ route('wallet.transactions') }}" class="btn btn-sm btn-outline-main">View All Transactions</a>
                    </div>
                    <div class="card-body p-0">
                        @if($recentTransactions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($recentTransactions->take(5) as $transaction)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="transaction-icon me-3 {{ $transaction->type === 'credit' ? 'bg-accent-green' : 'bg-accent-red' }}">
                                                        <i class="bi {{ $transaction->type === 'credit' ? 'bi-arrow-up' : 'bi-arrow-down' }} text-white"></i>
                                                    </div>
                                                    <span class="text-capitalize fw-medium">{{ $transaction->type }}</span>
                                                </div>
                                            </td>
                                            <td class="{{ $transaction->type === 'credit' ? 'text-accent-green' : 'text-accent-red' }} fw-bold">
                                                {{ $transaction->formatted_amount }}
                                            </td>
                                            <td>
                                                <span class="badge {{ $transaction->status_badge_class }}">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $transaction->created_at->format('M d, Y g:i A') }}</td>
                                            <td>
                                                <a href="{{ route('wallet.transaction-details', $transaction->id) }}" class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-eye me-1"></i>View
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-inbox h1 text-secondary mb-4"></i>
                                <h5 class="text-secondary mb-3">No transactions yet</h5>
                                <p class="text-secondary mb-4">Start by adding funds to your wallet to begin shopping</p>
                                <a href="{{ route('wallet.add-funds') }}" class="btn btn-main btn-lg">
                                    <i class="bi bi-plus-circle me-2"></i>Add Funds
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-3">
                            <a href="{{ route('wallet.add-funds') }}" class="btn btn-main btn-lg">
                                <i class="bi bi-plus-circle me-2"></i>Add Funds
                            </a>
                            <a href="{{ route('wallet.transactions') }}" class="btn btn-outline-main">
                                <i class="bi bi-clock-history me-2"></i>View Transaction History
                            </a>
                            <a href="{{ route('customize.index') }}" class="btn btn-outline-main">
                                <i class="bi bi-cart me-2"></i>Start Shopping
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Wallet Tips</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle text-accent-green me-2 mt-1"></i>
                            <small class="text-secondary">Keep your wallet topped up for seamless shopping</small>
                        </div>
                        <div class="d-flex align-items-start mb-3">
                            <i class="bi bi-check-circle text-accent-green me-2 mt-1"></i>
                            <small class="text-secondary">Track your spending with detailed transaction history</small>
                        </div>
                        <div class="d-flex align-items-start">
                            <i class="bi bi-check-circle text-accent-green me-2 mt-1"></i>
                            <small class="text-secondary">All transactions are secure and encrypted</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    function fixBadgeColors() {
        const isLightTheme = document.documentElement.getAttribute('data-theme') === 'light';
        const badges = document.querySelectorAll('.badge');
        
        badges.forEach(badge => {
            if (isLightTheme) {
                if (badge.classList.contains('bg-danger')) {
                    badge.style.color = '#000000';
                } else if (badge.classList.contains('bg-success')) {
                    badge.style.color = '#000000';
                } else if (badge.classList.contains('bg-warning')) {
                    badge.style.color = '#000000';
                } else if (badge.classList.contains('bg-secondary')) {
                    badge.style.color = '#ffffff';
                } else if (badge.classList.contains('bg-info')) {
                    badge.style.color = '#ffffff';
                }
            }
        });
    }
    
    // Fix on page load
    fixBadgeColors();
    
    // Fix when theme changes (if theme switcher exists)
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'data-theme') {
                setTimeout(fixBadgeColors, 100);
            }
        });
    });
    
    observer.observe(document.documentElement, {
        attributes: true,
        attributeFilter: ['data-theme']
    });
});
</script>

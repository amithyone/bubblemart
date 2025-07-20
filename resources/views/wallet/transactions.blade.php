@extends('layouts.template')

@section('content')
<style>
/* Remove card borders and add shadows - matching home page */
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
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
}

.transaction-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Light theme transaction card styling */
[data-theme="light"] .transaction-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 20px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .transaction-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-2px);
}

/* Summary card styling */
.summary-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
}

.summary-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Light theme summary card styling */
[data-theme="light"] .summary-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 20px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .summary-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-2px);
}

/* Empty state card */
.empty-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
}

.empty-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Light theme empty card styling */
[data-theme="light"] .empty-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 20px !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .empty-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15) !important;
    transform: translateY(-2px);
}

/* Table styling */
.table {
    color: #ffffff !important;
}

.table thead th {
    border-bottom: 1px solid rgba(255,255,255,0.2) !important;
    color: #ffffff !important;
    font-weight: 600;
}

.table tbody tr {
    border-bottom: 1px solid rgba(255,255,255,0.1) !important;
}

.table tbody tr:hover {
    background: rgba(255,255,255,0.05) !important;
}

/* Light theme table styling */
[data-theme="light"] .table {
    color: #000000 !important;
}

[data-theme="light"] .table thead th {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #000000 !important;
    font-weight: 600;
}

[data-theme="light"] .table tbody tr {
    border-bottom: 1px solid rgba(0, 0, 0, 0.05) !important;
}

[data-theme="light"] .table tbody tr:hover {
    background: rgba(0, 0, 0, 0.02) !important;
}

/* Badge styling */
.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

.bg-success {
    background: rgba(40,167,69,0.9) !important;
    color: #ffffff !important;
}

.bg-danger {
    background: rgba(220,53,69,0.9) !important;
    color: #ffffff !important;
}

.bg-primary {
    background: rgba(0,123,255,0.9) !important;
    color: #ffffff !important;
}

.bg-info {
    background: rgba(23,162,184,0.9) !important;
    color: #ffffff !important;
}

.bg-warning {
    background: rgba(255,152,0,0.9) !important;
    color: #ffffff !important;
}

.bg-secondary {
    background: rgba(108,117,125,0.9) !important;
    color: #ffffff !important;
}

/* Light theme badge styling */
[data-theme="light"] .bg-success {
    background: #28a745 !important;
    color: #ffffff !important;
}

[data-theme="light"] .bg-danger {
    background: #dc3545 !important;
    color: #ffffff !important;
}

[data-theme="light"] .bg-primary {
    background: #007bff !important;
    color: #ffffff !important;
}

[data-theme="light"] .bg-info {
    background: #17a2b8 !important;
    color: #ffffff !important;
}

[data-theme="light"] .bg-warning {
    background: #ffc107 !important;
    color: #000000 !important;
}

[data-theme="light"] .bg-secondary {
    background: #6c757d !important;
    color: #ffffff !important;
}

/* Light theme text color overrides for badges */
[data-theme="light"] .text-dark {
    color: #000000 !important;
}

[data-theme="light"] .badge.text-dark {
    color: #000000 !important;
}

/* Amount colors */
.text-success { color: #28a745 !important; }
.text-danger { color: #dc3545 !important; }
.text-primary { color: #007bff !important; }
.text-info { color: #17a2b8 !important; }

/* Button styling */
.btn-outline-secondary {
    border: 1px solid rgba(255,255,255,0.3) !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
}

.btn-outline-secondary:hover {
    background: rgba(255,255,255,0.1) !important;
    border-color: rgba(255,255,255,0.5) !important;
    color: #ffffff !important;
}

.btn-outline-primary {
    border: 1px solid #ff9800 !important;
    color: #ff9800 !important;
    transition: all 0.3s ease;
}

.btn-outline-primary:hover {
    background: #ff9800 !important;
    border-color: #ff9800 !important;
    color: #ffffff !important;
}

.btn-primary {
    background: #ff9800 !important;
    border: none !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    background: #ff7300 !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255,152,0,0.3) !important;
}

/* Light theme button styling */
[data-theme="light"] .btn-outline-secondary {
    border: 1px solid rgba(0, 0, 0, 0.2) !important;
    color: rgba(0, 0, 0, 0.7) !important;
    transition: all 0.3s ease;
}

[data-theme="light"] .btn-outline-secondary:hover {
    background: rgba(0, 0, 0, 0.05) !important;
    border-color: rgba(0, 0, 0, 0.3) !important;
    color: #000000 !important;
}

[data-theme="light"] .btn-outline-primary {
    border: 1px solid #036674 !important;
    color: #036674 !important;
    transition: all 0.3s ease;
}

[data-theme="light"] .btn-outline-primary:hover {
    background: #036674 !important;
    border-color: #036674 !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-primary {
    background: linear-gradient(135deg, #036674 0%, #0d8a9c 100%) !important;
    border: none !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
}

[data-theme="light"] .btn-primary:hover {
    background: linear-gradient(135deg, #0d8a9c 0%, #036674 100%) !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(3, 102, 116, 0.3) !important;
}

/* Mobile Styles - Matching Wallet Page */
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
    
    .card {
        border: none !important;
        margin-bottom: 0.75rem !important;
        background: linear-gradient(135deg, rgb(19, 16, 16) 0%, rgb(0, 0, 0) 100%) !important;
        backdrop-filter: blur(10px) !important;
        border-radius: 20px !important;
        box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
    }
    
    /* Light theme mobile card styling */
    [data-theme="light"] .card {
        background: #ffffff !important;
        border: 1px solid rgba(0, 0, 0, 0.1) !important;
        border-radius: 20px !important;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
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
        cursor: pointer;
        transition: all 0.3s ease;
    }
    
    .transaction-item:hover {
        background: rgba(255,255,255,0.05) !important;
    }
    
    /* Light theme mobile transaction item styling */
    [data-theme="light"] .transaction-item {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    [data-theme="light"] .transaction-item:hover {
        background: rgba(0, 0, 0, 0.02) !important;
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
        font-size: 0.85rem !important;
        font-weight: 500 !important;
        margin-bottom: 0.2rem;
        color: #ffffff !important;
        line-height: 1.2 !important;
    }
    
    .transaction-date {
        font-size: 0.75rem !important;
        color: rgba(255,255,255,0.6) !important;
        font-weight: normal !important;
        line-height: 1.2 !important;
    }
    
    /* Light theme mobile text styling */
    [data-theme="light"] .transaction-time {
        color: #000000 !important;
    }
    
    [data-theme="light"] .transaction-date {
        color: rgba(0, 0, 0, 0.6) !important;
    }
    
    .transaction-amount {
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        text-align: right;
        line-height: 1.2 !important;
    }
    
    .transaction-status {
        font-size: 0.75rem !important;
        padding: 0.2rem 0.4rem;
        border-radius: 4px;
        margin-top: 0.2rem;
        font-weight: normal !important;
        line-height: 1.2 !important;
    }
    
    /* Light theme mobile transaction status styling */
    [data-theme="light"] .transaction-status {
        font-weight: 500 !important;
    }
    
    .section-header {
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        margin-bottom: 0.5rem;
        color: #ffffff !important;
        line-height: 1.2 !important;
    }
    
    .view-all-link {
        font-size: 0.8rem !important;
        color: #ff9800 !important;
        text-decoration: none !important;
        font-weight: normal !important;
    }
    
    .stat-value {
        font-size: 0.95rem !important;
        font-weight: 600 !important;
        margin-bottom: 0.2rem;
        line-height: 1.2 !important;
    }
    
    .stat-label {
        font-size: 0.75rem !important;
        color: rgba(255,255,255,0.7) !important;
        font-weight: normal !important;
        line-height: 1.2 !important;
    }
    
    /* Light theme mobile text styling */
    [data-theme="light"] .section-header {
        color: #000000 !important;
    }
    
    [data-theme="light"] .view-all-link {
        color: #036674 !important;
    }
    
    [data-theme="light"] .stat-label {
        color: rgba(0, 0, 0, 0.7) !important;
    }
    
    /* Override template background colors */
    .mobile-only,
    .mobile-only *,
    .mobile-only .card,
    .mobile-only .card-body,
    .mobile-only .card-header {
        background-color: transparent !important;
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
    
    /* Override any template font styles */
    .transaction-item * {
        font-family: inherit !important;
    }
    
    /* Ensure no bold text from template */
    .transaction-item strong,
    .transaction-item b,
    .transaction-item .fw-bold {
        font-weight: inherit !important;
    }
}

/* Load more button */
.load-more-btn {
    background: #ff9800 !important;
    border: none !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
    padding: 0.75rem 2rem !important;
}

.load-more-btn:hover {
    background: #ff7300 !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255,152,0,0.3) !important;
}

/* Light theme load more button */
[data-theme="light"] .load-more-btn {
    background: linear-gradient(135deg, #036674 0%, #0d8a9c 100%) !important;
    border: none !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
    padding: 0.75rem 2rem !important;
}

[data-theme="light"] .load-more-btn:hover {
    background: linear-gradient(135deg, #0d8a9c 0%, #036674 100%) !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(3, 102, 116, 0.3) !important;
}

.load-more-btn.loading {
    pointer-events: none;
    opacity: 0.7;
}

/* Modal styling */
.modal-content {
    border: none !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5) !important;
    background: rgba(0, 0, 0, 0.9) !important;
}

.modal-backdrop {
    background-color: rgba(0, 0, 0, 0.9) !important;
}

.modal-header {
    border-bottom: 1px solid rgba(255,255,255,0.1) !important;
}

.modal-footer {
    border-top: 1px solid rgba(255,255,255,0.1) !important;
}

.btn-close-white {
    filter: invert(1) grayscale(100%) brightness(200%);
}

/* Light theme modal styling */
[data-theme="light"] .modal-content {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 15px !important;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2) !important;
}

[data-theme="light"] .modal-backdrop {
    background-color: rgba(0, 0, 0, 0.5) !important;
}

[data-theme="light"] .modal-header {
    border-bottom: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .modal-footer {
    border-top: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .btn-close-white {
    filter: none;
}

/* Text color overrides for light theme */
[data-theme="light"] .text-theme-1 {
    color: #000000 !important;
}

[data-theme="light"] .text-muted {
    color: rgba(0, 0, 0, 0.6) !important;
}

/* Breadcrumb styling for light theme */
[data-theme="light"] .breadcrumb {
    background: transparent !important;
}

[data-theme="light"] .breadcrumb-item a {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .breadcrumb-item.active {
    color: #000000 !important;
}

/* Font sizes and weights matching other pages */
.page-title {
    font-size: 0.95rem !important;
    font-weight: 600 !important;
    color: var(--text-primary) !important;
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
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Transaction modal functionality
    const transactionModal = document.getElementById('transactionModal');
    const transactionDetails = document.getElementById('transactionDetails');
    
    if (transactionModal) {
        transactionModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const transactionData = JSON.parse(button.getAttribute('data-transaction'));
            
            // Format the transaction details
            const detailsHTML = `
                <div class="transaction-details">
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong class="text-muted">Description:</strong>
                        </div>
                        <div class="col-6">
                            <span class="text-theme-1">${transactionData.description}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong class="text-muted">Type:</strong>
                        </div>
                        <div class="col-6">
                            <span class="badge ${transactionData.type === 'credit' ? 'bg-success' : 'bg-danger'}">${transactionData.type_label}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong class="text-muted">Amount:</strong>
                        </div>
                        <div class="col-6">
                            <span class="fw-bold ${transactionData.type === 'credit' ? 'text-success' : 'text-danger'}">${transactionData.formatted_amount}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong class="text-muted">Balance After:</strong>
                        </div>
                        <div class="col-6">
                            <span class="text-theme-1">₦${parseFloat(transactionData.balance_after).toLocaleString('en-NG', {minimumFractionDigits: 2})}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong class="text-muted">Status:</strong>
                        </div>
                        <div class="col-6">
                            <span class="badge ${getStatusBadgeClass(transactionData.status)}">${transactionData.status.charAt(0).toUpperCase() + transactionData.status.slice(1)}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong class="text-muted">Date:</strong>
                        </div>
                        <div class="col-6">
                            <span class="text-theme-1">${new Date(transactionData.created_at).toLocaleDateString('en-US', {year: 'numeric', month: 'long', day: 'numeric'})}</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong class="text-muted">Time:</strong>
                        </div>
                        <div class="col-6">
                            <span class="text-theme-1">${new Date(transactionData.created_at).toLocaleTimeString('en-US', {hour: '2-digit', minute: '2-digit'})}</span>
                        </div>
                    </div>
                    ${transactionData.reference_type ? `
                    <div class="row mb-3">
                        <div class="col-6">
                            <strong class="text-muted">Reference:</strong>
                        </div>
                        <div class="col-6">
                            <span class="text-theme-1">${transactionData.reference_type.charAt(0).toUpperCase() + transactionData.reference_type.slice(1)} #${transactionData.reference_id}</span>
                        </div>
                    </div>
                    ` : ''}
                </div>
            `;
            
            transactionDetails.innerHTML = detailsHTML;
        });
    }
    
    // Load more functionality
    const loadMoreBtn = document.querySelector('.load-more-btn');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const currentPage = parseInt(this.getAttribute('data-page'));
            const btn = this;
            
            // Show loading state
            btn.classList.add('loading');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
            
            // Fetch more transactions
            fetch(`{{ route('wallet.transactions') }}?page=${currentPage}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.html) {
                    // Append new transactions
                    const transactionList = document.getElementById('transactionList');
                    transactionList.insertAdjacentHTML('beforeend', data.html);
                    
                    // Update page number
                    btn.setAttribute('data-page', currentPage + 1);
                    
                    // Hide load more button if no more pages
                    if (!data.hasMorePages) {
                        btn.style.display = 'none';
                    }
                    
                    // Debug: Log the loaded HTML to see what's being returned
                    console.log('Loaded HTML:', data.html);
                    
                    // Ensure mobile styles are applied to new content
                    if (window.innerWidth <= 768) {
                        const newItems = transactionList.querySelectorAll('.transaction-item:not(.mobile-styled)');
                        console.log('Found new items:', newItems.length);
                        newItems.forEach(item => {
                            item.classList.add('mobile-styled');
                            // Force apply mobile styles
                            item.style.display = 'flex';
                            item.style.alignItems = 'center';
                            item.style.padding = '0.6rem';
                            item.style.borderBottom = '1px solid rgba(255,255,255,0.1)';
                            item.style.textDecoration = 'none';
                            item.style.color = 'inherit';
                            item.style.cursor = 'pointer';
                            item.style.transition = 'all 0.3s ease';
                        });
                    }
                }
            })
            .catch(error => {
                console.error('Error loading more transactions:', error);
            })
            .finally(() => {
                // Reset button state
                btn.classList.remove('loading');
                btn.innerHTML = '<i class="fas fa-spinner me-2"></i>Load More';
            });
        });
    }
    
    // Helper function to get status badge class
    function getStatusBadgeClass(status) {
        switch(status) {
            case 'completed': return 'bg-success';
            case 'pending': return 'bg-warning';
            case 'failed': return 'bg-danger';
            default: return 'bg-secondary';
        }
    }
});
</script>

<div class="container">
    <!-- Mobile Layout -->
    <div class="mobile-only d-md-none">
        <!-- Compact Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-1">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none"><i class="bi bi-house-door"></i></a></li>
                <li class="breadcrumb-item"><a href="{{ route('wallet.index') }}" class="text-decoration-none">Wallet</a></li>
                <li class="breadcrumb-item active">Transactions</li>
            </ol>
        </nav>
        
        <!-- Compact Summary Card -->
        <div class="card mb-3">
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="stat-value text-success">₦{{ number_format($wallet->transactions()->credits()->sum('amount'), 0) }}</div>
                        <div class="stat-label">Credits</div>
                    </div>
                    <div class="col-4">
                        <div class="stat-value text-danger">₦{{ number_format($wallet->transactions()->debits()->sum('amount'), 0) }}</div>
                        <div class="stat-label">Debits</div>
                    </div>
                    <div class="col-4">
                        <div class="stat-value text-primary">{{ $wallet->transactions()->count() }}</div>
                        <div class="stat-label">Total</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Transactions List -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0 section-header"><i class="bi bi-clock-history me-1"></i>All Transactions</h6>
                <a href="{{ route('wallet.index') }}" class="view-all-link">Back</a>
            </div>
            <div class="card-body p-0">
                @if($transactions->count() > 0)
                    <div class="transaction-list" id="transactionList">
                        @foreach($transactions as $transaction)
                        <div class="transaction-item" 
                             data-bs-toggle="modal" 
                             data-bs-target="#transactionModal"
                             data-transaction="{{ json_encode($transaction) }}">
                            <div class="transaction-icon {{ $transaction->type === 'credit' ? 'bg-success' : 'bg-danger' }}">
                                <i class="bi {{ $transaction->type === 'credit' ? 'bi-arrow-up' : 'bi-arrow-down' }} text-white"></i>
                            </div>
                            <div class="transaction-details">
                                <div class="transaction-time">{{ $transaction->created_at->format('g:i A') }}</div>
                                <div class="transaction-date">{{ $transaction->created_at->format('M d') }}</div>
                                <span class="transaction-status {{ $transaction->status_badge_class }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </div>
                            <div class="transaction-amount {{ $transaction->type === 'credit' ? 'text-success' : 'text-danger' }}">
                                {{ $transaction->formatted_amount }}
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <!-- Mobile Load More Button -->
                    @if($transactions->hasMorePages())
                    <div class="text-center p-3">
                        <button class="btn btn-primary load-more-btn" data-page="2">
                            <i class="fas fa-spinner me-2"></i>Load More
                        </button>
                    </div>
                    @endif
                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox mb-3" style="font-size: 3rem; color: rgba(255,255,255,0.5);"></i>
                        <h6 class="transaction-title">No transactions found</h6>
                        <p class="transaction-description small">You haven't made any transactions yet.</p>
                        <a href="{{ route('wallet.add-funds') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-plus me-1"></i>Add Funds
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Desktop Layout -->
    <div class="desktop-only d-none d-md-block">
        <div class="row">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="page-title"><i class="fas fa-history me-2"></i>Transaction History</h1>
                    <a href="{{ route('wallet.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Wallet
                    </a>
                </div>

                <!-- Wallet Summary -->
                <div class="card summary-card mb-4">
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3 mb-3">
                                <h4 class="text-success">₦{{ number_format($wallet->transactions()->credits()->sum('amount'), 2) }}</h4>
                                <small class="text-muted">Total Credits</small>
                            </div>
                            <div class="col-md-3 mb-3">
                                <h4 class="text-danger">₦{{ number_format($wallet->transactions()->debits()->sum('amount'), 2) }}</h4>
                                <small class="text-muted">Total Debits</small>
                            </div>
                            <div class="col-md-3 mb-3">
                                <h4 class="text-primary">{{ $wallet->transactions()->count() }}</h4>
                                <small class="text-muted">Total Transactions</small>
                            </div>
                            <div class="col-md-3 mb-3">
                                <h4 class="text-info">{{ $wallet->formatted_balance }}</h4>
                                <small class="text-muted">Current Balance</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transactions List -->
                <div class="card transaction-card">
                    <div class="card-header" style="background: linear-gradient(135deg,rgba(16,17,19,0.44) 0%,rgb(0,0,0) 100%) !important; border-bottom: 1px solid rgba(255,255,255,0.1) !important;">
                        <h5 class="mb-0 transaction-title"><i class="fas fa-list me-2"></i>All Transactions</h5>
                    </div>
                    <div class="card-body">
                        @if($transactions->count() > 0)
                            <!-- Desktop Table View -->
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Date & Time</th>
                                            <th>Description</th>
                                            <th>Type</th>
                                            <th>Amount</th>
                                            <th>Balance After</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($transactions as $transaction)
                                        <tr>
                                            <td>
                                                <div class="transaction-title">{{ $transaction->created_at->format('M d, Y') }}</div>
                                                <small class="transaction-description">{{ $transaction->created_at->format('h:i A') }}</small>
                                            </td>
                                            <td>
                                                <div class="fw-bold transaction-title">{{ $transaction->description }}</div>
                                                @if($transaction->reference_type)
                                                    <small class="transaction-description">
                                                        {{ ucfirst($transaction->reference_type) }} #{{ $transaction->reference_id }}
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $transaction->type === 'credit' ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $transaction->type_label }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold {{ $transaction->type === 'credit' ? 'text-success' : 'text-danger' }}">
                                                    {{ $transaction->formatted_amount }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="fw-bold transaction-title">₦{{ number_format($transaction->balance_after, 2) }}</span>
                                            </td>
                                            <td>
                                                <span class="{{ $transaction->status_badge_class }}">
                                                    {{ ucfirst($transaction->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('wallet.transaction-details', $transaction->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye me-1"></i>Details
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <!-- Desktop Pagination -->
                            <div class="d-flex justify-content-center mt-4">
                                {{ $transactions->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <div class="empty-card p-5">
                                    <i class="fas fa-inbox mb-4" style="font-size: 4rem; color: #b0b0b0;"></i>
                                    <h4 class="mt-3 transaction-title">No transactions found</h4>
                                    <p class="transaction-description">You haven't made any transactions yet.</p>
                                    <a href="{{ route('wallet.add-funds') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Add Funds
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Details Modal -->
    <div class="modal fade" id="transactionModal" tabindex="-1" aria-labelledby="transactionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="background: rgba(0, 0, 0, 0.9) !important; border: none;">
                <div class="modal-header" style="background: rgba(0, 0, 0, 0.95) !important; border-bottom: 1px solid rgba(255,255,255,0.1) !important;">
                    <h5 class="modal-title transaction-title" id="transactionModalLabel">
                        <i class="fas fa-receipt me-2"></i>Transaction Details
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="transactionDetails">
                        <!-- Transaction details will be loaded here -->
                    </div>
                </div>
                <div class="modal-footer" style="border-top: 1px solid rgba(255,255,255,0.1) !important;">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
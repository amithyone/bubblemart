@extends('layouts.admin-mobile')

@section('title', 'Orders Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0 text-white">Orders Management</h1>
        <a href="{{ route('admin.orders.analytics') }}" class="mobile-btn mobile-btn-info">
            <i class="fas fa-chart-bar me-1"></i>Analytics
        </a>
    </div>

    <!-- Search and Filters Card -->
    <div class="mobile-search-card">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <input type="text" 
                   class="mobile-search-input" 
                   name="search" 
                   placeholder="Search orders, customers..." 
                   value="{{ request('search') }}">
            
            <div class="mobile-filter-row">
                <select name="status" class="mobile-filter-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ request('status') == 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                    <option value="delivered" {{ request('status') == 'delivered' ? 'selected' : '' }}>Delivered</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                
                <select name="payment_status" class="mobile-filter-select">
                    <option value="">All Payments</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                </select>
                
                <button class="mobile-btn mobile-btn-secondary" type="submit">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="mobile-stats-grid">
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="mobile-stat-number">{{ $orders->total() }}</div>
            <div class="mobile-stat-label">Total Orders</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="mobile-stat-number">₦{{ number_format($orders->sum('total'), 0) }}</div>
            <div class="mobile-stat-label">Total Revenue</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-clock"></i>
            </div>
            <div class="mobile-stat-number">{{ $orders->where('order_status', 'pending')->count() }}</div>
            <div class="mobile-stat-label">Pending</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="mobile-stat-number">{{ $orders->where('order_status', 'delivered')->count() }}</div>
            <div class="mobile-stat-label">Delivered</div>
        </div>
    </div>

    <!-- Orders Container -->
    <div class="mobile-content-container">

        @if($orders->count() > 0)
            @foreach($orders as $order)
                <div class="mobile-card">
                    <div class="mobile-card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mobile-card-title">Order #{{ $order->order_number }}</h6>
                                <div class="mobile-card-subtitle">
                                    <i class="fas fa-user me-1"></i>{{ $order->user->name }}
                                    <span class="ms-2">
                                        <i class="fas fa-envelope me-1"></i>{{ $order->user->email }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-end">
                                @php
                                    $statusColors = [
                                        'pending' => 'warning',
                                        'processing' => 'info',
                                        'shipped' => 'primary',
                                        'delivered' => 'success',
                                        'cancelled' => 'danger'
                                    ];
                                    $color = $statusColors[$order->order_status] ?? 'secondary';
                                @endphp
                                <span class="badge bg-{{ $color }} mb-1">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                                <br>
                                <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : 'warning' }}">
                                    {{ ucfirst($order->payment_status) }}
                                </span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mobile-card-body">
                        <div class="mobile-card-meta">
                            <div>
                                <strong class="text-success">₦{{ number_format($order->total, 2) }}</strong>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-credit-card me-1"></i>
                                    {{ ucfirst($order->payment_method) }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="mobile-card-meta">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $order->created_at->format('M d, Y') }}
                                </small>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    {{ $order->created_at->format('H:i') }}
                                </small>
                            </div>
                        </div>
                        
                        @if($order->items->count() > 0)
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-box me-1"></i>
                                    {{ $order->items->count() }} item(s)
                                </small>
                                <div class="mt-2">
                                    @foreach($order->items->take(2) as $item)
                                        <small class="text-muted d-block">
                                            • {{ $item->product->name ?? 'Product' }} 
                                            (Qty: {{ $item->quantity }})
                                        </small>
                                    @endforeach
                                    @if($order->items->count() > 2)
                                        <small class="text-muted">
                                            +{{ $order->items->count() - 2 }} more items
                                        </small>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        @if($order->tracking_number)
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-truck me-1"></i>
                                    Tracking: {{ $order->tracking_number }}
                                </small>
                            </div>
                        @endif
                        
                        <div class="mobile-card-actions">
                            <a href="{{ route('admin.orders.show', $order) }}" 
                               class="mobile-btn mobile-btn-info" 
                               title="View">
                                <i class="fas fa-eye"></i>
                                <span class="d-none d-sm-inline ms-1">View</span>
                            </a>
                            
                            <a href="{{ route('admin.orders.edit', $order) }}" 
                               class="mobile-btn mobile-btn-warning" 
                               title="Edit">
                                <i class="fas fa-edit"></i>
                                <span class="d-none d-sm-inline ms-1">Edit</span>
                            </a>
                            
                            @if($order->order_status !== 'delivered' && $order->order_status !== 'cancelled')
                                <form action="{{ route('admin.orders.cancel', $order) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      id="cancelOrderForm{{ $order->id }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="button" 
                                            class="mobile-btn mobile-btn-danger" 
                                            title="Cancel"
                                            onclick="showCancelConfirmation({{ $order->id }})">
                                        <i class="fas fa-times"></i>
                                        <span class="d-none d-sm-inline ms-1">Cancel</span>
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Infinite Scroll Trigger -->
            <div class="mobile-loading-trigger" style="height: 20px;"></div>
            
            <!-- Pagination -->
            @if($orders->hasPages())
                <div class="mobile-pagination">
                    @if($orders->onFirstPage())
                        <span class="mobile-page-link disabled">Previous</span>
                    @else
                        <a href="{{ $orders->previousPageUrl() }}" class="mobile-page-link">Previous</a>
                    @endif
                    
                    @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
                        @if($page == $orders->currentPage())
                            <span class="mobile-page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="mobile-page-link">{{ $page }}</a>
                        @endif
                    @endforeach
                    
                    @if($orders->hasMorePages())
                        <a href="{{ $orders->nextPageUrl() }}" class="mobile-page-link">Next</a>
                    @else
                        <span class="mobile-page-link disabled">Next</span>
                    @endif
                </div>
            @endif
        @else
            <div class="mobile-empty-state">
                <div class="mobile-empty-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <h5 class="text-muted">No orders found</h5>
                <p class="text-muted">Try adjusting your search criteria.</p>
            </div>
        @endif
    </div>
</div>
</div>
@endsection

@push('styles')
<style>
/* Status Badge Styling */
.badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.badge.bg-success {
    background-color: var(--success-color) !important;
    color: white;
}

.badge.bg-warning {
    background-color: var(--warning-color) !important;
    color: white;
}

.badge.bg-info {
    background-color: var(--info-color) !important;
    color: white;
}

.badge.bg-primary {
    background-color: var(--primary-color) !important;
    color: white;
}

.badge.bg-danger {
    background-color: var(--danger-color) !important;
    color: white;
}

.badge.bg-secondary {
    background-color: var(--secondary-color) !important;
    color: white;
}
</style>
@endpush

@push('scripts')
<script>
// Cancel order confirmation for index page
function showCancelConfirmation(orderId) {
    showCustomAlert(
        'Cancel Order',
        'Are you sure you want to cancel this order? This action cannot be undone.',
        'warning',
        function() {
            // Submit the form
            const form = document.getElementById('cancelOrderForm' + orderId);
            console.log('Submitting form:', form);
            console.log('Form action:', form.action);
            console.log('Form method:', form.method);
            form.submit();
        }
    );
}
</script>
@endpush 
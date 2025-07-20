@extends('layouts.admin-mobile')

@section('title', 'Orders Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0 text-white">Orders Management</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.analytics') }}" class="mobile-btn mobile-btn-info">
                <i class="fas fa-chart-bar me-1"></i>Analytics
            </a>
            <a href="{{ route('admin.orders.export') }}" class="mobile-btn mobile-btn-secondary">
                <i class="fas fa-download me-1"></i>Export
            </a>
        </div>
    </div>

    <!-- Search and Filters Card -->
    <div class="mobile-search-card">
        <form method="GET" action="{{ route('admin.orders.index') }}">
            <input type="text" 
                   class="mobile-search-input" 
                   name="search" 
                   placeholder="Search orders by ID, customer name, or email..." 
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
                    <option value="">All Payment Statuses</option>
                    <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="paid" {{ request('payment_status') == 'paid' ? 'selected' : '' }}>Paid</option>
                    <option value="failed" {{ request('payment_status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    <option value="refunded" {{ request('payment_status') == 'refunded' ? 'selected' : '' }}>Refunded</option>
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
                <i class="fas fa-clock"></i>
            </div>
            <div class="mobile-stat-number">{{ $orders->where('status', 'pending')->count() }}</div>
            <div class="mobile-stat-label">Pending</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-truck"></i>
            </div>
            <div class="mobile-stat-number">{{ $orders->whereIn('status', ['processing', 'shipped'])->count() }}</div>
            <div class="mobile-stat-label">In Transit</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="mobile-stat-number">{{ $orders->where('status', 'delivered')->count() }}</div>
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
                                <h6 class="mobile-card-title">
                                    <i class="fas fa-receipt me-2 text-primary"></i>
                                    Order #{{ $order->id }}
                                </h6>
                                <div class="mobile-card-subtitle">
                                    <i class="fas fa-user me-1"></i>{{ $order->user->name ?? 'Guest' }}
                                    <span class="ms-2">
                                        <i class="fas fa-envelope me-1"></i>{{ $order->user->email ?? $order->email }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="mb-1">
                                    @switch($order->status)
                                        @case('pending')
                                            <span class="badge bg-warning">Pending</span>
                                            @break
                                        @case('processing')
                                            <span class="badge bg-info">Processing</span>
                                            @break
                                        @case('shipped')
                                            <span class="badge bg-primary">Shipped</span>
                                            @break
                                        @case('delivered')
                                            <span class="badge bg-success">Delivered</span>
                                            @break
                                        @case('cancelled')
                                            <span class="badge bg-danger">Cancelled</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                                    @endswitch
                                </div>
                                <div>
                                    @switch($order->payment_status)
                                        @case('pending')
                                            <span class="badge bg-warning bg-opacity-75">Payment Pending</span>
                                            @break
                                        @case('paid')
                                            <span class="badge bg-success bg-opacity-75">Paid</span>
                                            @break
                                        @case('failed')
                                            <span class="badge bg-danger bg-opacity-75">Payment Failed</span>
                                            @break
                                        @case('refunded')
                                            <span class="badge bg-info bg-opacity-75">Refunded</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary bg-opacity-75">{{ ucfirst($order->payment_status) }}</span>
                                    @endswitch
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mobile-card-body">
                        <div class="mobile-card-meta">
                            <div>
                                <strong class="text-success">${{ number_format($order->total_amount, 2) }}</strong>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $order->created_at->format('M d, Y H:i') }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="mobile-card-meta">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-box me-1"></i>
                                    {{ $order->items->count() }} Items
                                </small>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $order->shipping_address->city ?? 'N/A' }}
                                </small>
                            </div>
                        </div>
                        
                        @if($order->items->count() > 0)
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-list me-1"></i>Items:
                                </small>
                                <div class="mt-1">
                                    @foreach($order->items->take(3) as $item)
                                        <span class="badge bg-secondary me-1">
                                            {{ $item->product->name ?? 'Unknown Product' }} (x{{ $item->quantity }})
                                        </span>
                                    @endforeach
                                    @if($order->items->count() > 3)
                                        <span class="badge bg-secondary">+{{ $order->items->count() - 3 }} more</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        @if($order->notes)
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-sticky-note me-1"></i>Notes:
                                </small>
                                <p class="text-muted small mb-0 mt-1">
                                    {{ Str::limit($order->notes, 100) }}
                                </p>
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
                            
                            @if($order->status !== 'delivered' && $order->status !== 'cancelled')
                                <form action="{{ route('admin.orders.update-status', $order) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="processing">
                                    <button type="submit" 
                                            class="mobile-btn mobile-btn-secondary" 
                                            title="Mark as Processing">
                                        <i class="fas fa-cog"></i>
                                        <span class="d-none d-sm-inline ms-1">Process</span>
                                    </button>
                                </form>
                            @endif
                            
                            @if($order->status === 'processing')
                                <form action="{{ route('admin.orders.update-status', $order) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="shipped">
                                    <button type="submit" 
                                            class="mobile-btn mobile-btn-primary" 
                                            title="Mark as Shipped">
                                        <i class="fas fa-truck"></i>
                                        <span class="d-none d-sm-inline ms-1">Ship</span>
                                    </button>
                                </form>
                            @endif
                            
                            @if($order->status === 'shipped')
                                <form action="{{ route('admin.orders.update-status', $order) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="delivered">
                                    <button type="submit" 
                                            class="mobile-btn mobile-btn-success" 
                                            title="Mark as Delivered">
                                        <i class="fas fa-check"></i>
                                        <span class="d-none d-sm-inline ms-1">Deliver</span>
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
                <p class="text-muted">Orders will appear here once customers start placing them.</p>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize infinite scroll
    let isLoading = false;
    let currentPage = {{ $orders->currentPage() }};
    let hasMorePages = {{ $orders->hasMorePages() ? 'true' : 'false' }};
    
    function loadMoreOrders() {
        if (isLoading || !hasMorePages) return;
        
        isLoading = true;
        currentPage++;
        
        // Show loading indicator
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'mobile-loading';
        loadingDiv.innerHTML = `
            <div class="mobile-loading-spinner"></div>
            <div>Loading more orders...</div>
        `;
        
        const container = document.querySelector('.mobile-content-container');
        container.appendChild(loadingDiv);
        
        // Fetch next page
        const url = new URL(window.location);
        url.searchParams.set('page', currentPage);
        
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newOrders = doc.querySelectorAll('.mobile-card');
                
                // Remove loading indicator
                loadingDiv.remove();
                
                // Add new orders
                newOrders.forEach(order => {
                    container.appendChild(order.cloneNode(true));
                });
                
                // Update pagination state
                hasMorePages = newOrders.length > 0;
                isLoading = false;
            })
            .catch(error => {
                console.error('Error loading more orders:', error);
                loadingDiv.remove();
                isLoading = false;
            });
    }
    
    // Intersection Observer for infinite scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !isLoading) {
                loadMoreOrders();
            }
        });
    });
    
    const loadingTrigger = document.querySelector('.mobile-loading-trigger');
    if (loadingTrigger) {
        observer.observe(loadingTrigger);
    }
});
</script>
@endpush 
@extends('layouts.template')

@section('content')

<style>
/* Consistent gradient backgrounds */
.header-card { background: linear-gradient(135deg,rgba(16,17,19,0.44) 0%,rgb(0,0,0) 100%) !important; }
.info-card { background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important; }

/* Custom button styling to match card gradients */
.btn-gradient {
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
    border: none !important;
    color: #ffffff !important; font-weight: 600;
    transition: all 0.3s ease;
}

.btn-gradient:hover {
    background: linear-gradient(135deg,rgba(16,17,19,0.44) 0%,rgb(0,0,0) 100%) !important;
    color: #ffffff !important; font-weight: 600;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,0,0,0.3) !important;
}

/* Order card styling */
.order-card {
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
    border: none !important;
    border-radius: 15px !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    transition: all 0.3s ease;
    color: #ffffff !important; font-weight: 600;
}

.order-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.2) !important;
    background: linear-gradient(135deg,rgba(16,17,19,0.44) 0%,rgb(0,0,0) 100%) !important;
}

/* Empty state card */
.empty-card {
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
    border: none !important;
    border-radius: 20px !important;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    color: #ffffff !important; font-weight: 600;
}

/* Text color fixes */
.text-theme-1 { color: #ffffff !important; font-weight: 600; }
.text-secondary { color: #b0b0b0 !important; }
.welcome-label { color: #b0b0b0 !important; }
.welcome-username { color: #ffffff !important; font-weight: 600; }

/* Status badge styling */
.badge-light {
    background: rgba(255,255,255,0.1) !important;
    color: #ffffff !important; font-weight: 600;
    border: 1px solid rgba(255,255,255,0.2) !important;
}

.theme-green {
    background: var(--accent-green) !important;
    color: #ffffff !important; font-weight: 600;
}


.theme-shipped:hover {
    background: var(--accent-orange) !important;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(252, 164, 136, 0.4);
    transition: all 0.3s ease;
    background: var(--accent-light-green) !important;
    color: #ffffff !important; font-weight: 600;
}

.theme-shipped {
    background: var(--accent-light-green) !important;
    color: #ffffff !important;
    font-weight: 600;
}

.theme-shipped:hover {
    background: var(--accent-orange) !important;
    color: #ffffff !important;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(252, 164, 136, 0.4);
    transition: all 0.3s ease;
}
.theme-grey {
    background: rgba(108,117,125,0.8) !important;
    color: #ffffff !important; font-weight: 600;
}

/* Modern Progress Bar */
.progress-container {
    padding: 10px 0;
}

.progress-track {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    max-width: 100%;
    margin: 0 auto;
    gap: 4px;
}

.progress-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    z-index: 2;
    flex: 1;
    min-width: 0;
}

.step-icon {
    width: 24px;
    height: 24px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    border: 2px solid rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 4px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.step-icon i {
    font-size: 10px;
    color: rgba(255,255,255,0.6);
    transition: all 0.3s ease;
}

.step-label {
    font-size: 8px;
    font-weight: 500;
    color: rgba(255,255,255,0.7);
    text-align: center;
    transition: all 0.3s ease;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 100%;
}

/* Completed Steps */
.progress-step.completed .step-icon {
    background: linear-gradient(135deg, var(--main-color) 0%, var(--dark-accent-hover) 100%);
    border-color: var(--main-color);
    box-shadow: 0 4px 12px rgba(0, 73, 83, 0.4);
    transform: scale(1.05);
}

.progress-step.completed .step-icon i {
    color: #ffffff;
}

.progress-step.completed .step-label {
    color: var(--main-color);
    font-weight: 600;
}

/* Current Step */
.progress-step.current .step-icon {
    background: linear-gradient(135deg, var(--accent-orange) 0%, #ff8a65 100%);
    border-color: var(--accent-orange);
    box-shadow: 0 3px 10px rgba(252, 164, 136, 0.3);
    animation: pulse 2s infinite;
}

.progress-step.current .step-icon i {
    color: #ffffff;
}

.progress-step.current .step-label {
    color: var(--accent-orange);
    font-weight: 600;
}

/* Progress Lines */
.progress-line {
    flex: 1;
    height: 2px;
    background: rgba(255,255,255,0.3);
    margin: 0 2px;
    border-radius: 1px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    min-width: 15px;
}

.progress-line.completed {
    background: linear-gradient(90deg, var(--main-color) 0%, var(--dark-accent-hover) 100%);
    box-shadow: 0 1px 4px rgba(0, 73, 83, 0.3);
}

.progress-line.completed::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    height: 100%;
    width: 100%;
    background: linear-gradient(90deg, transparent 0%, rgba(255,255,255,0.3) 50%, transparent 100%);
    animation: shimmer 2s infinite;
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Avatar styling */
.avatar-group .avatar {
    border: 2px solid rgba(255,255,255,0.2);
}

/* Mobile padding */
@media (max-width: 768px) {
    .container { padding: 0 15px; }
}

/* Load More Button Styling */
#load-more-btn {
    background: linear-gradient(135deg, var(--main-color) 0%, var(--dark-accent-hover) 100%) !important;
    border: none !important;
    color: #ffffff !important;
    font-weight: 600 !important;
    border-radius: 15px !important;
    transition: all 0.3s ease !important;
    min-height: 50px !important;
}

#load-more-btn:hover {
    background: linear-gradient(135deg, var(--dark-accent-hover) 0%, var(--main-color) 100%) !important;
    transform: translateY(-2px) !important;
    box-shadow: 0 4px 15px rgba(0, 73, 83, 0.4) !important;
}

#load-more-btn:disabled {
    opacity: 0.7 !important;
    transform: none !important;
    box-shadow: none !important;
}

/* Mobile-specific infinite scroll optimizations */
@media (max-width: 768px) {
    #load-more-container {
        padding: 20px 0;
    }
    
    #load-more-btn {
        width: 100% !important;
        max-width: 300px !important;
    }
    
    .order-card {
        margin-bottom: 15px !important;
    }
}

/* Light theme styling */
[data-theme="light"] .header-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 12px !important;
}

[data-theme="light"] .info-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 12px !important;
}

[data-theme="light"] .order-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 12px !important;
    color: #000000 !important;
}

[data-theme="light"] .order-card:hover {
    background: #f8f9fa !important;
    border-color: #036674 !important;
    box-shadow: 0 8px 25px rgba(3, 102, 116, 0.2) !important;
}

[data-theme="light"] .empty-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    border-radius: 12px !important;
    color: #000000 !important;
}

/* Light theme text colors */
[data-theme="light"] .text-theme-1 {
    color: #000000 !important;
}

[data-theme="light"] .text-secondary {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .welcome-label {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .welcome-username {
    color: #000000 !important;
}

[data-theme="light"] .text-theme-accent-1 {
    color: #036674 !important;
}

/* Light theme button styling */
[data-theme="light"] .btn-gradient {
    background: #036674 !important;
    border: none !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-gradient:hover {
    background: #025a66 !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(3, 102, 116, 0.3) !important;
}

/* Light theme load more button */
[data-theme="light"] #load-more-btn {
    background: #036674 !important;
    color: #ffffff !important;
}

[data-theme="light"] #load-more-btn:hover {
    background: #025a66 !important;
    box-shadow: 0 4px 15px rgba(3, 102, 116, 0.4) !important;
}

/* Light theme progress steps */
[data-theme="light"] .step-icon {
    background: rgba(0, 0, 0, 0.1) !important;
    border: 2px solid rgba(0, 0, 0, 0.2) !important;
}

[data-theme="light"] .step-icon i {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .step-label {
    color: rgba(0, 0, 0, 0.7) !important;
}

[data-theme="light"] .progress-line {
    background: rgba(0, 0, 0, 0.3) !important;
}

/* Light theme completed steps */
[data-theme="light"] .progress-step.completed .step-icon {
    background: #036674 !important;
    border-color: #036674 !important;
}

[data-theme="light"] .progress-step.completed .step-icon i {
    color: #ffffff !important;
}

[data-theme="light"] .progress-step.completed .step-label {
    color: #036674 !important;
}

[data-theme="light"] .progress-line.completed {
    background: #036674 !important;
}

/* Light theme current step */
[data-theme="light"] .progress-step.current .step-icon {
    background: #ff8a65 !important;
    border-color: #ff8a65 !important;
}

[data-theme="light"] .progress-step.current .step-icon i {
    color: #ffffff !important;
}

[data-theme="light"] .progress-step.current .step-label {
    color: #ff8a65 !important;
}

/* Light theme badge styling */
[data-theme="light"] .badge-light {
    background: rgba(0, 0, 0, 0.1) !important;
    color: #000000 !important;
    border: 1px solid rgba(0, 0, 0, 0.2) !important;
}

[data-theme="light"] .theme-green {
    background: #28a745 !important;
    color: #ffffff !important;
}

[data-theme="light"] .theme-shipped {
    background: #17a2b8 !important;
    color: #ffffff !important;
}

[data-theme="light"] .theme-grey {
    background: #6c757d !important;
    color: #ffffff !important;
}
</style>

<!-- Welcome/User -->
<div class="d-flex align-items-center mb-3">
    <figure class="avatar avatar-30 rounded coverimg align-middle me-2">
        @auth
            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('template-assets/img/avatars/1.jpg') }}" alt="Profile" style="width: 30px; height: 30px; object-fit: cover;">
        @else
            <i class="bi bi-person-circle h2"></i>
        @endauth
    </figure>
    <div>
        <p class="small welcome-label text-truncated mb-0">Welcome,</p>
        <h6 class="fw-bold welcome-username mb-0">
            @auth
                {{ Auth::user()->name }}
            @else
                Guest
            @endauth
        </h6>
    </div>
</div>

<!-- Page Header -->
<div class="row gx-3 mb-3">
    <div class="col mb-3 mb-lg-4">
        <p class="small text-theme-1 text-truncated mb-0">My Orders,</p>
        <h6 class="fw-bold text-theme-accent-1 mb-0">{{ $orders->count() }} Order{{ $orders->count() !== 1 ? 's' : '' }}</h6>
    </div>
    <div class="col-auto mb-3 mb-lg-4">
        <a href="{{ route('products.index') }}" class="btn btn-gradient btn-sm">
            <i class="bi bi-plus me-1"></i>
            New Order
        </a>
    </div>
</div>

@if($orders->count() > 0)
    <!-- Orders List -->
    <div class="list-group mb-3 mb-lg-4" id="orders-container">
        @foreach($orders as $order)
        <a href="{{ route('orders.show', $order) }}" class="list-group-item list-group-action px-3 py-3 order-card mb-3">
            <!-- Order Status -->
            <div class="row gx-3 align-items-center mb-3">
                <div class="col">
                    <div class="d-flex align-items-center justify-content-between">
                        <span class="badge badge-light text-bg-theme-1 theme-{{ $order->order_status === 'delivered' ? 'green' : ($order->order_status === 'shipped' ? 'shipped' : 'grey') }}">
                            {{ ucfirst($order->order_status) }}
                        </span>
                        <div class="btn btn-sm btn-square btn-link"><i class="bi bi-arrow-right"></i></div>
                    </div>
                </div>
            </div>
            
            <!-- Modern Progress Steps -->
            <div class="progress-container mb-3">
                <div class="progress-track">
                    <div class="progress-step {{ in_array($order->order_status, ['pending', 'confirmed', 'shipped', 'delivered']) ? 'completed' : '' }}">
                        <div class="step-icon">
                            <i class="bi bi-cart-check"></i>
                        </div>
                        <div class="step-label">Ordered</div>
                    </div>
                    <div class="progress-line {{ in_array($order->order_status, ['confirmed', 'shipped', 'delivered']) ? 'completed' : '' }}"></div>
                    
                    <div class="progress-step {{ in_array($order->order_status, ['confirmed', 'shipped', 'delivered']) ? 'completed' : ($order->order_status === 'pending' ? 'current' : '') }}">
                        <div class="step-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <div class="step-label">Confirmed</div>
                    </div>
                    <div class="progress-line {{ in_array($order->order_status, ['shipped', 'delivered']) ? 'completed' : '' }}"></div>
                    
                    <div class="progress-step {{ in_array($order->order_status, ['shipped', 'delivered']) ? 'completed' : ($order->order_status === 'confirmed' ? 'current' : '') }}">
                        <div class="step-icon">
                            <i class="bi bi-truck"></i>
                        </div>
                        <div class="step-label">Shipped</div>
                    </div>
                    <div class="progress-line {{ $order->order_status === 'delivered' ? 'completed' : '' }}"></div>
                    
                    <div class="progress-step {{ $order->order_status === 'delivered' ? 'completed' : ($order->order_status === 'shipped' ? 'current' : '') }}">
                        <div class="step-icon">
                            <i class="bi bi-house-check"></i>
                        </div>
                        <div class="step-label">Delivered</div>
                    </div>
                </div>
            </div>
            
            <!-- Order Details -->
            <div class="row gx-3 align-items-center">
                <div class="col">
                    <h6 class="mb-0 text-theme-1">₦{{ number_format($order->total) }}</h6>
                    <p class="small text-secondary">#{{ $order->order_number }}</p>
                </div>
                <div class="col">
                    <p class="mb-0 text-theme-1">{{ $order->created_at->format('M d, Y') }}</p>
                    <p class="small text-secondary">{{ $order->orderItems->count() }} Item{{ $order->orderItems->count() !== 1 ? 's' : '' }}</p>
                </div>
                <div class="col-auto avatar-group">
                    @foreach($order->orderItems->take(3) as $item)
                    <figure class="avatar avatar-40 coverimg rounded" data-bs-toggle="tooltip" title="{{ $item->product->name }}">
                        @if($item->product->image)
                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                        @else
                            <img src="{{ asset('template-assets/img/ecommerce/image-6.jpg') }}" alt="Product">
                        @endif
                    </figure>
                    @endforeach
                    @if($order->orderItems->count() > 3)
                    <div class="avatar avatar-40 bg-theme-accent-1 rounded" data-bs-toggle="tooltip" data-bs-html="true" title="+{{ $order->orderItems->count() - 3 }} more items">
                        <p>+{{ $order->orderItems->count() - 3 }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </a>
        @endforeach
    </div>
    
    <!-- Load More Button -->
    @if($orders->hasMorePages())
    <div class="d-flex justify-content-center mb-3" id="load-more-container">
        <button type="button" class="btn btn-gradient btn-lg px-5" id="load-more-btn" data-page="2">
            <i class="bi bi-arrow-down me-2"></i>
            Load More Orders
        </button>
    </div>
    @endif

@else
    <!-- Empty State -->
    <div class="row justify-content-center mb-3">
        <div class="col-12">
            <div class="card empty-card text-center p-5">
                <div class="mb-4">
                    <div class="avatar avatar-80 rounded-circle bg-theme-1 mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-box-seam h1 text-white"></i>
                    </div>
                    <h4 class="fw-bold mb-2 text-theme-1">No Orders Yet</h4>
                    <p class="text-secondary mb-0">You haven't placed any orders yet. Start shopping to see your orders here!</p>
                </div>
                <a href="{{ route('products.index') }}" class="btn btn-gradient btn-lg px-5" style="border-radius: 15px;">
                    <i class="bi bi-shop me-2"></i>
                    Start Shopping
                </a>
            </div>
        </div>
    </div>
@endif

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const loadMoreBtn = document.getElementById('load-more-btn');
    const ordersContainer = document.getElementById('orders-container');
    const loadMoreContainer = document.getElementById('load-more-container');
    
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            const currentPage = parseInt(this.getAttribute('data-page'));
            const btn = this;
            
            // Show loading state
            btn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Loading...';
            btn.disabled = true;
            
            // Make AJAX request
            fetch(`{{ route('orders.load-more') }}?page=${currentPage}`, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.orders && data.orders.length > 0) {
                    // Append new orders to container
                    data.orders.forEach(order => {
                        const orderHtml = createOrderHtml(order);
                        ordersContainer.insertAdjacentHTML('beforeend', orderHtml);
                    });
                    
                    // Update page number
                    btn.setAttribute('data-page', data.nextPage);
                    
                    // Hide load more button if no more orders
                    if (!data.hasMore) {
                        loadMoreContainer.style.display = 'none';
                    }
                } else {
                    // No more orders
                    loadMoreContainer.style.display = 'none';
                }
                
                // Update the total orders count in the header
                const orderCountElement = document.querySelector('.fw-bold.text-theme-accent-1');
                if (orderCountElement) {
                    const currentCount = parseInt(orderCountElement.textContent.match(/\d+/)[0]);
                    const newCount = currentCount + data.orders.length;
                    orderCountElement.textContent = `${newCount} Order${newCount !== 1 ? 's' : ''}`;
                }
            })
            .catch(error => {
                console.error('Error loading more orders:', error);
                btn.innerHTML = '<i class="bi bi-exclamation-triangle me-2"></i>Error loading orders';
            })
            .finally(() => {
                // Reset button state
                btn.innerHTML = '<i class="bi bi-arrow-down me-2"></i>Load More Orders';
                btn.disabled = false;
            });
        });
    }
    
    function createOrderHtml(order) {
        const statusClass = order.order_status === 'delivered' ? 'green' : 
                           (order.order_status === 'shipped' ? 'shipped' : 'grey');
        
        const progressSteps = getProgressSteps(order.order_status);
        
        return `
            <a href="/orders/${order.id}" class="list-group-item list-group-action px-3 py-3 order-card mb-3">
                <!-- Order Status -->
                <div class="row gx-3 align-items-center mb-3">
                    <div class="col">
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="badge badge-light text-bg-theme-1 theme-${statusClass}">
                                ${order.order_status.charAt(0).toUpperCase() + order.order_status.slice(1)}
                            </span>
                            <div class="btn btn-sm btn-square btn-link"><i class="bi bi-arrow-right"></i></div>
                        </div>
                    </div>
                </div>
                
                <!-- Modern Progress Steps -->
                <div class="progress-container mb-3">
                    <div class="progress-track">
                        ${progressSteps}
                    </div>
                </div>
                
                <!-- Order Details -->
                <div class="row gx-3 align-items-center">
                    <div class="col">
                        <h6 class="mb-0 text-theme-1">₦${Number(order.total).toLocaleString()}</h6>
                        <p class="small text-secondary">#${order.order_number}</p>
                    </div>
                    <div class="col">
                        <p class="mb-0 text-theme-1">${new Date(order.created_at).toLocaleDateString('en-US', { month: 'short', day: 'numeric', year: 'numeric' })}</p>
                        <p class="small text-secondary">${order.order_items_count || 0} Item${(order.order_items_count || 0) !== 1 ? 's' : ''}</p>
                    </div>
                    <div class="col-auto avatar-group">
                        <figure class="avatar avatar-40 coverimg rounded">
                            <img src="/template-assets/img/ecommerce/image-6.jpg" alt="Product">
                        </figure>
                    </div>
                </div>
            </a>
        `;
    }
    
    function getProgressSteps(orderStatus) {
        const steps = [
            { status: 'ordered', icon: 'bi-cart-check', label: 'Ordered' },
            { status: 'confirmed', icon: 'bi-check-circle', label: 'Confirmed' },
            { status: 'shipped', icon: 'bi-truck', label: 'Shipped' },
            { status: 'delivered', icon: 'bi-house-check', label: 'Delivered' }
        ];
        
        let html = '';
        const statusOrder = ['pending', 'confirmed', 'shipped', 'delivered'];
        const currentIndex = statusOrder.indexOf(orderStatus);
        
        steps.forEach((step, index) => {
            const stepIndex = statusOrder.indexOf(step.status);
            const isCompleted = stepIndex <= currentIndex;
            const isCurrent = stepIndex === currentIndex;
            
            let stepClass = '';
            if (isCompleted) stepClass = 'completed';
            else if (isCurrent) stepClass = 'current';
            
            html += `
                <div class="progress-step ${stepClass}">
                    <div class="step-icon">
                        <i class="${step.icon}"></i>
                    </div>
                    <div class="step-label">${step.label}</div>
                </div>
            `;
            
            if (index < steps.length - 1) {
                const lineClass = stepIndex < currentIndex ? 'completed' : '';
                html += `<div class="progress-line ${lineClass}"></div>`;
            }
        });
        
        return html;
    }
});
</script>
@endpush 
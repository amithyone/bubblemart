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

/* Tracking result card styling */
.tracking-result-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
}

.tracking-result-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Info cards */
.info-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
}

.info-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Order item cards */
.order-item-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
}

.order-item-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Text color fixes */
.text-theme-1 { color: #ffffff !important; }
.text-secondary { color: #b0b0b0 !important; }
.welcome-label { color: #b0b0b0 !important; }
.welcome-username { color: #ffffff !important; }

/* Button styling */
.btn-theme {
    background: #004953 !important;
    border: none !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
}

.btn-theme:hover {
    background: #005a66 !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0,73,83,0.3) !important;
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

/* Badge styling */
.badge {
    font-weight: 500;
    padding: 0.5em 0.75em;
}

.bg-success {
    background: rgba(40,167,69,0.8) !important;
    color: #ffffff !important;
}

.bg-info {
    background: rgba(0,123,255,0.8) !important;
    color: #ffffff !important;
}

.bg-secondary {
    background: rgba(108,117,125,0.8) !important;
    color: #ffffff !important;
}

.bg-warning {
    background: rgba(255,193,7,0.8) !important;
    color: #000000 !important;
}

/* Progress steps styling */
.progress-stepbar {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: space-between;
    position: relative;
}

.progress-stepbar::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 2px;
    background: rgba(255,255,255,0.2);
    transform: translateY(-50%);
    z-index: 1;
}

.progress-stepbar li {
    position: relative;
    z-index: 2;
    background: rgba(16,16,19,0.8);
    border-radius: 50%;
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 10px;
    color: #b0b0b0;
}

.progress-stepbar li.completed {
    background: #ff6b35;
    color: #ffffff;
}

.progress-stepbar li.stop {
    background: rgba(255,255,255,0.3);
    color: #ffffff;
}

.progress-stepbar li span {
    position: absolute;
    top: 25px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 10px;
    white-space: nowrap;
    color: #b0b0b0;
}

.progress-stepbar li.completed span {
    color: #ff6b35;
}

/* Mobile padding */
@media (max-width: 768px) {
    .container { padding: 0 15px; }
}
</style>

<!-- Welcome/User & Location -->
<div class="d-flex align-items-center justify-content-between mb-3">
    <div class="d-flex align-items-center">
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
    <div class="input-group input-group-sm w-auto location-select">
        <span class="input-group-text bg-none location-icon"><i class="bi bi-geo-alt"></i></span>
        <select class="form-select form-select-sm bg-none">
            <option>Lagos</option>
            <option>Abuja</option>
            <option>Port Harcourt</option>
            <option>Kano</option>
            <option>Ibadan</option>
        </select>
    </div>
</div>

<!-- Order Tracking Result -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card tracking-result-card">
            <div class="card-body p-4">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="avatar avatar-60 rounded-circle bg-theme-1 mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-box-seam h2 text-white"></i>
                    </div>
                    <h4 class="fw-bold mb-2 text-theme-1">Order #{{ $order->order_number }}</h4>
                    <p class="text-secondary mb-0">Tracked on {{ now()->format('M d, Y \a\t g:i A') }}</p>
                </div>

                <!-- Order Status Progress -->
                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold mb-0 text-theme-1">Order Status</h6>
                        <span class="badge bg-{{ $order->order_status === 'delivered' ? 'success' : ($order->order_status === 'shipped' ? 'info' : 'secondary') }} px-3 py-2">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>
                    
                    <!-- Progress Steps -->
                    <ul class="progress-stepbar mb-0">
                        <li class="{{ in_array($order->order_status, ['pending', 'confirmed', 'shipped', 'delivered']) ? 'completed' : '' }}">
                            <span>Ordered</span>
                        </li>
                        <li class="{{ in_array($order->order_status, ['confirmed', 'shipped', 'delivered']) ? 'completed' : ($order->order_status === 'pending' ? 'stop' : '') }}">
                            <span>Confirmed</span>
                        </li>
                        <li class="{{ in_array($order->order_status, ['shipped', 'delivered']) ? 'completed' : ($order->order_status === 'confirmed' ? 'stop' : '') }}">
                            <span>Shipped</span>
                        </li>
                        <li class="{{ $order->order_status === 'delivered' ? 'completed' : ($order->order_status === 'shipped' ? 'stop' : '') }}">
                            <span>Delivered</span>
                        </li>
                    </ul>
                </div>

                <!-- Order Details -->
                <div class="row gx-3 mb-4">
                    <div class="col-md-6">
                        <div class="card info-card border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-theme-1">
                                    <i class="bi bi-info-circle me-2 text-theme-1"></i>
                                    Order Information
                                </h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary">Order Date:</span>
                                    <span class="fw-medium text-theme-1">{{ $order->created_at->format('M d, Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary">Total Amount:</span>
                                    <span class="fw-bold text-theme-1">₦{{ number_format($order->total) }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary">Payment Status:</span>
                                    <span class="badge bg-{{ $order->payment_status === 'paid' ? 'success' : 'warning' }}">
                                        {{ ucfirst($order->payment_status) }}
                                    </span>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <span class="text-secondary">Items:</span>
                                    <span class="fw-medium text-theme-1">{{ $order->orderItems->count() }} items</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card info-card border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-theme-1">
                                    <i class="bi bi-geo-alt me-2 text-theme-1"></i>
                                    Delivery Information
                                </h6>
                                @foreach($order->orderItems as $item)
                                <div class="mb-2">
                                    <div class="fw-medium mb-1 text-theme-1">{{ $item->receiver_name }}</div>
                                    <div class="small text-secondary mb-1">{{ $item->receiver_phone }}</div>
                                    <div class="small text-secondary">{{ $item->receiver_address }}</div>
                                    @if($item->receiver_note)
                                    <div class="small text-secondary mt-1">
                                        <i class="bi bi-chat-quote me-1"></i>
                                        {{ $item->receiver_note }}
                                    </div>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3 text-theme-1">
                        <i class="bi bi-box me-2 text-theme-1"></i>
                        Order Items
                    </h6>
                    @foreach($order->orderItems as $item)
                    <div class="card order-item-card border-0 mb-2">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar avatar-50 rounded coverimg">
                                        @if($item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                                        @else
                                            <img src="{{ asset('template-assets/img/ecommerce/image-6.jpg') }}" alt="Product">
                                        @endif
                                    </div>
                                </div>
                                <div class="col">
                                    <h6 class="mb-1 text-theme-1">{{ $item->product->name }}</h6>
                                    <p class="small text-secondary mb-0">Quantity: {{ $item->quantity }}</p>
                                </div>
                                <div class="col-auto text-end">
                                    <span class="fw-bold text-theme-1">₦{{ number_format($item->total) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Action Buttons -->
                <div class="text-center">
                    <a href="{{ route('track') }}" class="btn btn-theme me-2" style="border-radius: 15px;">
                        <i class="bi bi-search me-2"></i>
                        Track Another Order
                    </a>
                    @auth
                    <a href="{{ route('orders.show', $order) }}" class="btn btn-outline-primary" style="border-radius: 15px;">
                        <i class="bi bi-eye me-2"></i>
                        View Full Details
                    </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</div>

@endsection 
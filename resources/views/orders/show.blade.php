@extends('layouts.template')

@section('content')

<style>
.adminuiux-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
}
.adminuiux-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}
.card { border: none !important; }
.tracking-result-card, .summary-card, .info-card, .order-item-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
}
.tracking-result-card:hover, .summary-card:hover, .info-card:hover, .order-item-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}
.text-theme-1 { color: #ffffff !important; }
.text-secondary { color: #b0b0b0 !important; }
.welcome-label { color: #b0b0b0 !important; }
.welcome-username { color: #ffffff !important; }
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
.btn-outline-primary {
    background: linear-gradient(135deg, rgba(255,152,0,0.1) 0%, rgba(255,152,0,0.2) 100%) !important;
    border: 2px solid #ff9800 !important;
    color: #ffffff !important;
    transition: all 0.3s ease;
    border-radius: 20px !important;
    backdrop-filter: blur(10px) !important;
}
.btn-outline-primary:hover {
    background: linear-gradient(135deg, #ff9800 0%, #ff7300 100%) !important;
    border-color: #ff9800 !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255,152,0,0.3) !important;
}
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
/* Modern Progress Bar */
.progress-container {
    padding: 15px 0;
}

.progress-track {
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: relative;
    max-width: 100%;
    margin: 0 auto;
    gap: 8px;
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
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    border: 2px solid rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 8px;
    transition: all 0.3s ease;
    backdrop-filter: blur(10px);
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}

.step-icon i {
    font-size: 16px;
    color: rgba(255,255,255,0.6);
    transition: all 0.3s ease;
}

.step-label {
    font-size: 10px;
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
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-color: #28a745;
    box-shadow: 0 4px 12px rgba(40,167,69,0.4);
    transform: scale(1.05);
}

.progress-step.completed .step-icon i {
    color: #ffffff;
}

.progress-step.completed .step-label {
    color: #28a745;
    font-weight: 600;
}

/* Current Step */
.progress-step.current .step-icon {
    background: linear-gradient(135deg, rgba(255,107,53,0.8) 0%, rgba(255,152,0,0.8) 100%);
    border-color: #ff6b35;
    box-shadow: 0 3px 10px rgba(255,107,53,0.3);
    animation: pulse 2s infinite;
}

.progress-step.current .step-icon i {
    color: #ffffff;
}

.progress-step.current .step-label {
    color: #ff6b35;
    font-weight: 600;
}

/* Progress Lines */
.progress-line {
    flex: 1;
    height: 2px;
    background: rgba(255,255,255,0.3);
    margin: 0 4px;
    border-radius: 1px;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    min-width: 20px;
}

.progress-line.completed {
    background: linear-gradient(90deg, #28a745 0%, #20c997 100%);
    box-shadow: 0 1px 4px rgba(40,167,69,0.3);
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

/* Animations */
@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.02); }
}

@keyframes shimmer {
    0% { transform: translateX(-100%); }
    100% { transform: translateX(100%); }
}

/* Mobile Responsive */
@media (max-width: 768px) {
    .progress-container {
        padding: 10px 0;
    }
    
    .progress-track {
        gap: 4px;
    }
    
    .step-icon {
        width: 32px;
        height: 32px;
        margin-bottom: 6px;
    }
    
    .step-icon i {
        font-size: 14px;
    }
    
    .step-label {
        font-size: 9px;
        line-height: 1.2;
    }
    
    .progress-line {
        height: 2px;
        margin: 0 2px;
        min-width: 15px;
    }
}

/* Delivery Stage Text */
.delivery-stage-text {
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    padding: 20px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
}

.stage-item {
    display: flex;
    align-items: center;
    padding: 12px;
    border-radius: 8px;
    transition: all 0.3s ease;
    background: rgba(255,255,255,0.02);
    border: 1px solid rgba(255,255,255,0.05);
}

.stage-item.completed {
    background: rgba(40,167,69,0.1);
    border-color: rgba(40,167,69,0.2);
}

.stage-icon {
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,0.1);
    border: 2px solid rgba(255,255,255,0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    transition: all 0.3s ease;
}

.stage-item.completed .stage-icon {
    background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    border-color: #28a745;
    box-shadow: 0 2px 8px rgba(40,167,69,0.3);
}

.stage-icon i {
    font-size: 16px;
    color: rgba(255,255,255,0.6);
    transition: all 0.3s ease;
}

.stage-item.completed .stage-icon i {
    color: #ffffff;
}

.stage-content {
    flex: 1;
    min-width: 0;
}

.stage-title {
    font-size: 13px;
    font-weight: 600;
    color: rgba(255,255,255,0.9);
    margin-bottom: 2px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.stage-time {
    font-size: 11px;
    color: rgba(255,255,255,0.6);
    font-weight: 500;
}

.stage-item.completed .stage-title {
    color: #28a745;
}

.stage-item.completed .stage-time {
    color: rgba(40,167,69,0.8);
}

@media (max-width: 480px) {
    .step-icon {
        width: 28px;
        height: 28px;
    }
    
    .step-icon i {
        font-size: 12px;
    }
    
    .step-label {
        font-size: 8px;
    }
    
    .progress-line {
        min-width: 10px;
    }
    
    .delivery-stage-text {
        padding: 15px;
    }
    
    .stage-item {
        padding: 8px;
        margin-bottom: 8px;
    }
    
    .stage-icon {
        width: 32px;
        height: 32px;
        margin-right: 10px;
    }
    
    .stage-icon i {
        font-size: 14px;
    }
    
    .stage-title {
        font-size: 12px;
    }
    
    .stage-time {
        font-size: 10px;
    }
}
@media (max-width: 768px) {
    .container { padding: 0 15px; }
}

/* Light theme styling for order details page */
[data-theme="light"] .tracking-result-card,
[data-theme="light"] .summary-card,
[data-theme="light"] .info-card,
[data-theme="light"] .order-item-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .tracking-result-card:hover,
[data-theme="light"] .summary-card:hover,
[data-theme="light"] .info-card:hover,
[data-theme="light"] .order-item-card:hover {
    background: #f8f9fa !important;
    border-color: #036674 !important;
    box-shadow: 0 8px 25px rgba(3, 102, 116, 0.2) !important;
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

/* Light theme button styling */
[data-theme="light"] .btn-theme {
    background: #036674 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(3, 102, 116, 0.2) !important;
}

[data-theme="light"] .btn-theme:hover {
    background: #025a66 !important;
    color: #ffffff !important;
    box-shadow: 0 8px 25px rgba(3, 102, 116, 0.3) !important;
}

[data-theme="light"] .btn-outline-primary {
    background: transparent !important;
    border: 2px solid #036674 !important;
    color: #036674 !important;
}

[data-theme="light"] .btn-outline-primary:hover {
    background: #036674 !important;
    border-color: #036674 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(3, 102, 116, 0.3) !important;
}

/* Light theme badge styling */
[data-theme="light"] .bg-success {
    background: #28a745 !important;
    color: #ffffff !important;
}

[data-theme="light"] .bg-info {
    background: #17a2b8 !important;
    color: #ffffff !important;
}

[data-theme="light"] .bg-secondary {
    background: #6c757d !important;
    color: #ffffff !important;
}

[data-theme="light"] .bg-warning {
    background: #ffc107 !important;
    color: #000000 !important;
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

/* Light theme delivery stage text */
[data-theme="light"] .delivery-stage-text {
    background: rgba(0, 0, 0, 0.05) !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .stage-item {
    background: rgba(0, 0, 0, 0.02) !important;
    border: 1px solid rgba(0, 0, 0, 0.05) !important;
}

[data-theme="light"] .stage-item.completed {
    background: rgba(3, 102, 116, 0.1) !important;
    border-color: rgba(3, 102, 116, 0.2) !important;
}

[data-theme="light"] .stage-icon {
    background: rgba(0, 0, 0, 0.1) !important;
    border: 2px solid rgba(0, 0, 0, 0.2) !important;
}

[data-theme="light"] .stage-item.completed .stage-icon {
    background: #036674 !important;
    border-color: #036674 !important;
}

[data-theme="light"] .stage-icon i {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .stage-item.completed .stage-icon i {
    color: #ffffff !important;
}

[data-theme="light"] .stage-title {
    color: rgba(0, 0, 0, 0.9) !important;
}

[data-theme="light"] .stage-time {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .stage-item.completed .stage-title {
    color: #036674 !important;
}

[data-theme="light"] .stage-item.completed .stage-time {
    color: rgba(3, 102, 116, 0.8) !important;
}

/* Light theme form elements */
[data-theme="light"] .form-select {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #000000 !important;
}

[data-theme="light"] .input-group-text {
    background: #f8f9fa !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: rgba(0, 0, 0, 0.7) !important;
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
</div>

<!-- Order Details -->
<div class="row mb-3">
    <div class="col-12">
        <div class="card tracking-result-card">
            <div class="card-body p-4">
                <!-- Header -->
                <div class="text-center mb-4">
                    <div class="avatar avatar-60 rounded-circle bg-theme-1 mx-auto mb-3 d-flex align-items-center justify-content-center">
                        <i class="bi bi-receipt h2 text-white"></i>
                    </div>
                    <h4 class="fw-bold mb-2 text-theme-1">Order #{{ $order->order_number }}</h4>
                    <p class="text-secondary mb-0">Placed on {{ $order->created_at->format('M d, Y \a\t g:i A') }}</p>
                </div>

                @if(session('success'))
                    <div class="alert alert-success mb-4" style="border-radius: 15px;">
                        <i class="bi bi-check-circle me-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Order Status Progress -->
                <div class="mb-4">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h6 class="fw-bold mb-0 text-theme-1">Order Status</h6>
                        <span class="badge bg-{{ $order->order_status === 'delivered' ? 'success' : ($order->order_status === 'shipped' ? 'info' : 'secondary') }} px-3 py-2">
                            {{ ucfirst($order->order_status) }}
                        </span>
                    </div>
                    
                    <!-- Modern Progress Steps -->
                    <div class="progress-container">
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
                    
                    <!-- Delivery Stage Text -->
                    <div class="delivery-stage-text mt-3">
                        <div class="row gx-3">
                            <div class="col-6 col-md-3">
                                <div class="stage-item {{ in_array($order->order_status, ['pending', 'confirmed', 'shipped', 'delivered']) ? 'completed' : '' }}">
                                    <div class="stage-icon">
                                        <i class="bi bi-cart-check"></i>
                                    </div>
                                    <div class="stage-content">
                                        <div class="stage-title">Order Placed</div>
                                        <div class="stage-time">{{ $order->created_at->format('M d, g:i A') }}</div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6 col-md-3">
                                <div class="stage-item {{ in_array($order->order_status, ['confirmed', 'shipped', 'delivered']) ? 'completed' : '' }}">
                                    <div class="stage-icon">
                                        <i class="bi bi-check-circle"></i>
                                    </div>
                                    <div class="stage-content">
                                        <div class="stage-title">Order Confirmed</div>
                                        <div class="stage-time">
                                            @if(in_array($order->order_status, ['confirmed', 'shipped', 'delivered']))
                                                {{ $order->updated_at->format('M d, g:i A') }}
                                            @else
                                                Pending
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6 col-md-3">
                                <div class="stage-item {{ in_array($order->order_status, ['shipped', 'delivered']) ? 'completed' : '' }}">
                                    <div class="stage-icon">
                                        <i class="bi bi-truck"></i>
                                    </div>
                                    <div class="stage-content">
                                        <div class="stage-title">Out for Delivery</div>
                                        <div class="stage-time">
                                            @if(in_array($order->order_status, ['shipped', 'delivered']))
                                                {{ $order->updated_at->format('M d, g:i A') }}
                                            @else
                                                Pending
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-6 col-md-3">
                                <div class="stage-item {{ $order->order_status === 'delivered' ? 'completed' : '' }}">
                                    <div class="stage-icon">
                                        <i class="bi bi-house-check"></i>
                                    </div>
                                    <div class="stage-content">
                                        <div class="stage-title">Delivered</div>
                                        <div class="stage-time">
                                            @if($order->order_status === 'delivered')
                                                {{ $order->updated_at->format('M d, g:i A') }}
                                            @else
                                                Pending
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Information -->
                <div class="row gx-3 mb-4">
                    <div class="col-md-6">
                        <div class="card info-card border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-theme-1">
                                    <i class="bi bi-info-circle me-2 text-theme-1"></i>
                                    Order Information
                                </h6>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary">Order Number:</span>
                                    <span class="fw-medium text-theme-1">#{{ $order->order_number }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary">Order Date:</span>
                                    <span class="fw-medium text-theme-1">{{ $order->created_at->format('M d, Y H:i') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-secondary">Payment Method:</span>
                                    <span class="fw-medium text-theme-1">{{ ucfirst($order->payment_method) }}</span>
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
                                @if($order->tracking_number)
                                <div class="d-flex justify-content-between mt-2">
                                    <span class="text-secondary">Tracking Number:</span>
                                    <span class="fw-medium text-theme-1">{{ $order->tracking_number }}</span>
                                </div>
                                @endif
                                @if($order->delivery_note)
                                <div class="d-flex justify-content-between mt-2">
                                    <span class="text-secondary">Delivery Note:</span>
                                    <span class="fw-medium text-theme-1">{{ $order->delivery_note }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="card info-card border-0">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3 text-theme-1">
                                    <i class="bi bi-geo-alt me-2 text-theme-1"></i>
                                    Complete Delivery Information
                                </h6>
                                @foreach($order->orderItems as $item)
                                <div class="mb-3">
                                    <div class="fw-medium mb-2 text-theme-1">{{ $item->product->name }}</div>
                                    
                                    @if($item->customization)
                                    <!-- Complete address from customization -->
                                    <div class="small text-secondary mb-1">
                                        <strong>Receiver Name:</strong> {{ $item->customization->receiver_name }}
                                    </div>
                                    <div class="small text-secondary mb-1">
                                        <strong>Receiver Phone:</strong> {{ $item->customization->receiver_phone }}
                                    </div>
                                    @if($item->customization->receiver_gender)
                                    <div class="small text-secondary mb-1">
                                        <strong>Receiver Gender:</strong> {{ ucfirst($item->customization->receiver_gender) }}
                                    </div>
                                    @endif
                                    @if($item->customization->sender_name)
                                    <div class="small text-secondary mb-1">
                                        <strong>Sender Name:</strong> {{ $item->customization->sender_name }}
                                    </div>
                                    @endif
                                    
                                    <!-- Complete Address Breakdown -->
                                    <div class="small text-secondary mb-1">
                                        <strong>Complete Delivery Address:</strong>
                                    </div>
                                    <div class="small text-secondary mb-1 ps-2">
                                        @if($item->customization->receiver_house_number){{ $item->customization->receiver_house_number }}, @endif
                                        @if($item->customization->receiver_street){{ $item->customization->receiver_street }}, @endif
                                        @if($item->customization->receiver_city){{ $item->customization->receiver_city }}, @endif
                                        @if($item->customization->receiver_state){{ $item->customization->receiver_state }}, @endif
                                        @if($item->customization->receiver_zip){{ $item->customization->receiver_zip }}, @endif
                                        @if($item->customization->receiver_country){{ $item->customization->receiver_country }}@endif
                                    </div>
                                    
                                    <!-- Address Fields Breakdown -->
                                    <div class="small text-secondary mb-1">
                                        <strong>Address Details:</strong>
                                    </div>
                                    <div class="small text-secondary mb-1 ps-2">
                                        @if($item->customization->receiver_house_number)
                                            <div>House/Unit Number: {{ $item->customization->receiver_house_number }}</div>
                                        @endif
                                        @if($item->customization->receiver_street)
                                            <div>Street: {{ $item->customization->receiver_street }}</div>
                                        @endif
                                        @if($item->customization->receiver_city)
                                            <div>City: {{ $item->customization->receiver_city }}</div>
                                        @endif
                                        @if($item->customization->receiver_state)
                                            <div>State/Province: {{ $item->customization->receiver_state }}</div>
                                        @endif
                                        @if($item->customization->receiver_zip)
                                            <div>ZIP/Postal Code: {{ $item->customization->receiver_zip }}</div>
                                        @endif
                                        @if($item->customization->receiver_country)
                                            <div>Country: {{ $item->customization->receiver_country }}</div>
                                        @endif
                                    </div>
                                    
                                    @if($item->customization->receiver_note)
                                    <div class="small text-secondary mb-1">
                                        <strong>Delivery Note:</strong> {{ $item->customization->receiver_note }}
                                    </div>
                                    @endif
                                    @if($item->customization->delivery_method)
                                    <div class="small text-secondary mb-1">
                                        <strong>Delivery Method:</strong> {{ ucfirst(str_replace('_', ' ', $item->customization->delivery_method)) }}
                                    </div>
                                    @endif
                                    @else
                                    <!-- Fallback to order item fields -->
                                    <div class="small text-secondary mb-1">
                                        <strong>Receiver Name:</strong> {{ $item->receiver_name }}
                                    </div>
                                    <div class="small text-secondary mb-1">
                                        <strong>Receiver Phone:</strong> {{ $item->receiver_phone }}
                                    </div>
                                    <div class="small text-secondary mb-1">
                                        <strong>Delivery Address:</strong> {{ $item->receiver_address }}
                                    </div>
                                    @if($item->receiver_note)
                                    <div class="small text-secondary mb-1">
                                        <strong>Delivery Note:</strong> {{ $item->receiver_note }}
                                    </div>
                                    @endif
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Items with Customization Details -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3 text-theme-1">
                        <i class="bi bi-box me-2 text-theme-1"></i>
                        Order Items & Customization Details
                    </h6>
                    @foreach($order->orderItems as $item)
                    <div class="card order-item-card border-0 mb-3">
                        <div class="card-body p-4">
                            <!-- Product Info -->
                            <div class="row align-items-center mb-3">
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
                                    <p class="small text-secondary mb-1">Quantity: {{ $item->quantity }}</p>
                                    @if($item->variationOptions->count() > 0)
                                        <div class="small text-secondary">
                                            <strong>Product Variations:</strong>
                                        </div>
                                        <div class="small text-secondary ps-2">
                                            @foreach($item->variationOptions as $variation)
                                                <div class="mb-1">
                                                    <span class="text-theme-1">{{ ucfirst($variation->variation_name) }}:</span>
                                                    <span class="text-secondary">{{ $variation->option_label }}</span>
                                                    @if($variation->price_adjustment > 0)
                                                        <span class="text-success">(+₦{{ number_format($variation->price_adjustment) }})</span>
                                                    @elseif($variation->price_adjustment < 0)
                                                        <span class="text-danger">(₦{{ number_format(abs($variation->price_adjustment)) }})</span>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                <div class="col-auto text-end">
                                    <span class="fw-bold text-theme-1">₦{{ number_format($item->total) }}</span>
                                </div>
                            </div>

                            <!-- Customization Details -->
                            @if($item->customization || $item->variationOptions->count() > 0)
                            <div class="customization-details">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="fw-bold text-theme-1 mb-0">
                                        <i class="bi bi-palette me-2"></i>
                                        Customization Details
                                    </h6>
                                    @if($order->order_status === 'pending' && $item->customization)
                                    <button class="btn btn-sm btn-outline-primary" onclick="editCustomization({{ $item->id }})">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </button>
                                    @endif
                                </div>

                                <div class="row gx-3">
                                    <!-- Basic Customization -->
                                    <div class="col-md-6 mb-3">
                                        <div class="card info-card border-0">
                                            <div class="card-body">
                                                <h6 class="fw-bold mb-3 text-theme-1">
                                                    <i class="bi bi-chat-quote me-2"></i>
                                                    Customization Summary
                                                </h6>
                                                
                                                <!-- Customization Type and Status -->
                                                @if($item->customization)
                                                @if($item->customization->type)
                                                <div class="mb-2">
                                                    <span class="text-secondary small">Type:</span>
                                                    <span class="badge bg-info">{{ ucfirst($item->customization->type) }}</span>
                                                </div>
                                                @endif
                                                @if($item->customization->status)
                                                <div class="mb-2">
                                                    <span class="text-secondary small">Status:</span>
                                                    <span class="badge bg-{{ $item->customization->status === 'completed' ? 'success' : ($item->customization->status === 'pending' ? 'warning' : 'info') }}">
                                                        {{ ucfirst($item->customization->status) }}
                                                    </span>
                                                </div>
                                                @endif
                                                @if($item->customization->additional_cost > 0)
                                                <div class="mb-2">
                                                    <span class="text-secondary small">Additional Cost:</span>
                                                    <span class="text-success fw-bold">₦{{ number_format($item->customization->additional_cost) }}</span>
                                                </div>
                                                @endif
                                                @endif
                                                
                                                @if($item->customization->message)
                                                <div class="mb-2">
                                                    <span class="text-secondary small">Message:</span>
                                                    <p class="mb-0 text-theme-1">{{ $item->customization->message }}</p>
                                                </div>
                                                @endif
                                                @if($item->customization->special_request)
                                                <div class="mb-2">
                                                    <span class="text-secondary small">Special Request:</span>
                                                    <p class="mb-0 text-theme-1">{{ $item->customization->special_request }}</p>
                                                </div>
                                                @endif
                                                @if($item->customization_details)
                                                <div class="mb-2">
                                                    <span class="text-secondary small">Additional Details:</span>
                                                    <p class="mb-0 text-theme-1">{{ $item->customization_details }}</p>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product-Specific Details -->
                                    <div class="col-md-6 mb-3">
                                        <div class="card info-card border-0">
                                            <div class="card-body">
                                                <h6 class="fw-bold mb-3 text-theme-1">
                                                    <i class="bi bi-gear me-2"></i>
                                                    Specifications & Details
                                                </h6>
                                                
                                                <!-- Product Variations -->
                                                @if($item->variationOptions->count() > 0)
                                                <div class="mb-3">
                                                    <span class="text-secondary small fw-bold">Product Variations:</span>
                                                    @foreach($item->variationOptions as $variation)
                                                    <div class="mb-1">
                                                        <span class="text-secondary small">{{ ucfirst($variation->variation_name) }}:</span>
                                                        <span class="text-theme-1 fw-medium">{{ $variation->option_label }}</span>
                                                        @if($variation->price_adjustment > 0)
                                                            <span class="text-success small">(+₦{{ number_format($variation->price_adjustment) }})</span>
                                                        @elseif($variation->price_adjustment < 0)
                                                            <span class="text-danger small">(₦{{ number_format(abs($variation->price_adjustment)) }})</span>
                                                        @endif
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                                
                                                <!-- Customization Specifications -->
                                                @if($item->customization && ($item->customization->ring_size || $item->customization->bracelet_size || $item->customization->necklace_length || $item->customization->apparel_size || $item->customization->frame_size || $item->customization->cup_type || $item->customization->card_type || $item->customization->pillow_size || $item->customization->blanket_size || $item->customization->material))
                                                <div class="mb-3">
                                                    <span class="text-secondary small fw-bold">Customization Specs:</span>
                                                    @if($item->customization->ring_size)
                                                    <div class="mb-1">
                                                        <span class="text-secondary small">Ring Size:</span>
                                                        <span class="text-theme-1">{{ $item->customization->ring_size }}</span>
                                                    </div>
                                                    @endif
                                                    @if($item->customization->bracelet_size)
                                                    <div class="mb-1">
                                                        <span class="text-secondary small">Bracelet Size:</span>
                                                        <span class="text-theme-1">{{ $item->customization->bracelet_size }}</span>
                                                    </div>
                                                    @endif
                                                    @if($item->customization->necklace_length)
                                                    <div class="mb-1">
                                                        <span class="text-secondary small">Necklace Length:</span>
                                                        <span class="text-theme-1">{{ $item->customization->necklace_length }}</span>
                                                    </div>
                                                    @endif
                                                    @if($item->customization->apparel_size)
                                                    <div class="mb-1">
                                                        <span class="text-secondary small">Apparel Size:</span>
                                                        <span class="text-theme-1">{{ $item->customization->apparel_size }}</span>
                                                    </div>
                                                    @endif
                                                    @if($item->customization->frame_size)
                                                    <div class="mb-1">
                                                        <span class="text-secondary small">Frame Size:</span>
                                                        <span class="text-theme-1">{{ ucfirst($item->customization->frame_size) }}</span>
                                                    </div>
                                                    @endif
                                                    @if($item->customization->cup_type)
                                                    <div class="mb-1">
                                                        <span class="text-secondary small">Cup Type:</span>
                                                        <span class="text-theme-1">{{ ucfirst(str_replace('_', ' ', $item->customization->cup_type)) }}</span>
                                                    </div>
                                                    @endif
                                                    @if($item->customization->card_type)
                                                    <div class="mb-1">
                                                        <span class="text-secondary small">Card Type:</span>
                                                        <span class="text-theme-1">{{ ucfirst(str_replace('_', ' ', $item->customization->card_type)) }}</span>
                                                    </div>
                                                    @endif
                                                    @if($item->customization->pillow_size)
                                                    <div class="mb-1">
                                                        <span class="text-secondary small">Pillow Size:</span>
                                                        <span class="text-theme-1">{{ ucfirst(str_replace('_', ' ', $item->customization->pillow_size)) }}</span>
                                                    </div>
                                                    @endif
                                                    @if($item->customization->blanket_size)
                                                    <div class="mb-1">
                                                        <span class="text-secondary small">Blanket Size:</span>
                                                        <span class="text-theme-1">{{ ucfirst($item->customization->blanket_size) }}</span>
                                                    </div>
                                                    @endif
                                                    @if($item->customization->material)
                                                    <div class="mb-1">
                                                        <span class="text-secondary small">Material:</span>
                                                        <span class="text-theme-1">{{ $item->customization->material }}</span>
                                                    </div>
                                                    @endif
                                                </div>
                                                @endif
                                                
                                                <!-- Show message if no specifications -->
                                                @if($item->variationOptions->count() == 0 && (!$item->customization || !($item->customization->ring_size || $item->customization->bracelet_size || $item->customization->necklace_length || $item->customization->apparel_size || $item->customization->frame_size || $item->customization->cup_type || $item->customization->card_type || $item->customization->pillow_size || $item->customization->blanket_size || $item->customization->material)))
                                                <div class="text-center py-2">
                                                    <span class="text-secondary small">No specifications available</span>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Delivery Information -->
                                    <div class="col-12 mb-3">
                                        <div class="card info-card border-0">
                                            <div class="card-body">
                                                <h6 class="fw-bold mb-3 text-theme-1">
                                                    <i class="bi bi-truck me-2"></i>
                                                    Complete Delivery Information
                                                </h6>
                                                <div class="row gx-3">
                                                    @if($item->customization)
                                                    <!-- Customization-based delivery info -->
                                                    <div class="col-md-6 mb-2">
                                                        <span class="text-secondary small">Receiver Name:</span>
                                                        <div class="text-theme-1 fw-medium">{{ $item->customization->receiver_name }}</div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <span class="text-secondary small">Receiver Phone:</span>
                                                        <div class="text-theme-1 fw-medium">{{ $item->customization->receiver_phone }}</div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <span class="text-secondary small">Receiver Gender:</span>
                                                        <div class="text-theme-1 fw-medium">{{ ucfirst($item->customization->receiver_gender) }}</div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <span class="text-secondary small">Delivery Method:</span>
                                                        <div class="text-theme-1 fw-medium">{{ ucfirst(str_replace('_', ' ', $item->customization->delivery_method)) }}</div>
                                                    </div>
                                                    
                                                    <!-- Complete Address Breakdown -->
                                                    <div class="col-12 mb-2">
                                                        <span class="text-secondary small">Complete Delivery Address:</span>
                                                        <div class="text-theme-1 fw-medium">
                                                            @if($item->customization->receiver_house_number){{ $item->customization->receiver_house_number }}, @endif
                                                            @if($item->customization->receiver_street){{ $item->customization->receiver_street }}, @endif
                                                            @if($item->customization->receiver_city){{ $item->customization->receiver_city }}, @endif
                                                            @if($item->customization->receiver_state){{ $item->customization->receiver_state }} @endif
                                                            @if($item->customization->receiver_zip){{ $item->customization->receiver_zip }}@endif
                                                        </div>
                                                    </div>
                                                    
                                                    <!-- Address Fields Breakdown -->
                                                    <div class="col-12 mb-2">
                                                        <span class="text-secondary small">Address Details:</span>
                                                        <div class="row gx-2 mt-1">
                                                            @if($item->customization->receiver_house_number)
                                                            <div class="col-md-6 mb-1">
                                                                <span class="text-secondary small">House/Unit Number:</span>
                                                                <div class="text-theme-1">{{ $item->customization->receiver_house_number }}</div>
                                                            </div>
                                                            @endif
                                                            @if($item->customization->receiver_street)
                                                            <div class="col-md-6 mb-1">
                                                                <span class="text-secondary small">Street:</span>
                                                                <div class="text-theme-1">{{ $item->customization->receiver_street }}</div>
                                                            </div>
                                                            @endif
                                                            @if($item->customization->receiver_city)
                                                            <div class="col-md-6 mb-1">
                                                                <span class="text-secondary small">City:</span>
                                                                <div class="text-theme-1">{{ $item->customization->receiver_city }}</div>
                                                            </div>
                                                            @endif
                                                            @if($item->customization->receiver_state)
                                                            <div class="col-md-6 mb-1">
                                                                <span class="text-secondary small">State/Province:</span>
                                                                <div class="text-theme-1">{{ $item->customization->receiver_state }}</div>
                                                            </div>
                                                            @endif
                                                            @if($item->customization->receiver_zip)
                                                            <div class="col-md-6 mb-1">
                                                                <span class="text-secondary small">ZIP/Postal Code:</span>
                                                                <div class="text-theme-1">{{ $item->customization->receiver_zip }}</div>
                                                            </div>
                                                            @endif
                                                            @if($item->customization->receiver_country)
                                                            <div class="col-md-6 mb-1">
                                                                <span class="text-secondary small">Country:</span>
                                                                <div class="text-theme-1">{{ $item->customization->receiver_country }}</div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    
                                                    @if($item->customization->receiver_note)
                                                    <div class="col-12 mb-2">
                                                        <span class="text-secondary small">Delivery Note:</span>
                                                        <div class="text-theme-1 fw-medium">{{ $item->customization->receiver_note }}</div>
                                                    </div>
                                                    @endif
                                                    @else
                                                    <!-- OrderItem-based delivery info (fallback) -->
                                                    <div class="col-md-6 mb-2">
                                                        <span class="text-secondary small">Receiver Name:</span>
                                                        <div class="text-theme-1 fw-medium">{{ $item->receiver_name }}</div>
                                                    </div>
                                                    <div class="col-md-6 mb-2">
                                                        <span class="text-secondary small">Receiver Phone:</span>
                                                        <div class="text-theme-1 fw-medium">{{ $item->receiver_phone }}</div>
                                                    </div>
                                                    <div class="col-12 mb-2">
                                                        <span class="text-secondary small">Delivery Address:</span>
                                                        <div class="text-theme-1 fw-medium">{{ $item->receiver_address }}</div>
                                                    </div>
                                                    @if($item->receiver_note)
                                                    <div class="col-12 mb-2">
                                                        <span class="text-secondary small">Delivery Note:</span>
                                                        <div class="text-theme-1 fw-medium">{{ $item->receiver_note }}</div>
                                                    </div>
                                                    @endif
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Sender Information (if available) -->
                                    @if($item->customization && $item->customization->sender_name)
                                    <div class="col-12 mb-3">
                                        <div class="card info-card border-0">
                                            <div class="card-body">
                                                <h6 class="fw-bold mb-3 text-theme-1">
                                                    <i class="bi bi-person me-2"></i>
                                                    Sender Information
                                                </h6>
                                                <div class="row gx-3">
                                                    <div class="col-md-6 mb-2">
                                                        <span class="text-secondary small">Sender Name:</span>
                                                        <div class="text-theme-1 fw-medium">{{ $item->customization->sender_name }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif

                                    <!-- Customization Image -->
                                    @if($item->customization && $item->customization->media_path)
                                    <div class="col-12 mb-3">
                                        <div class="card info-card border-0">
                                            <div class="card-body">
                                                <h6 class="fw-bold mb-3 text-theme-1">
                                                    <i class="bi bi-image me-2"></i>
                                                    Customization Image
                                                </h6>
                                                <div class="text-center">
                                                    <img src="{{ asset('storage/' . $item->customization->media_path) }}" 
                                                         alt="Customization" 
                                                         class="img-fluid rounded" 
                                                         style="max-height: 200px; object-fit: cover;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @else
                            <div class="text-center py-3">
                                <i class="bi bi-info-circle text-secondary" style="font-size: 2rem;"></i>
                                <p class="text-secondary mt-2">No customization or variation details available for this item.</p>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                <!-- Order Summary -->
                <div class="mb-4">
                    <h6 class="fw-bold mb-3 text-theme-1">
                        <i class="bi bi-calculator me-2 text-theme-1"></i>
                        Order Summary
                    </h6>
                    <div class="card summary-card border-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Subtotal:</span>
                                        <span class="fw-medium text-theme-1">{{ $order->formatted_subtotal }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Tax (8%):</span>
                                        <span class="fw-medium text-theme-1">{{ $order->formatted_tax }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <span class="text-secondary">Shipping:</span>
                                        <span class="fw-medium text-theme-1">{{ $order->formatted_shipping }}</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Total:</span>
                                        <span class="fw-bold text-theme-1">{{ $order->formatted_total }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="text-center">
                    <a href="{{ route('orders.index') }}" class="btn btn-theme me-2" style="border-radius: 15px;">
                        <i class="bi bi-arrow-left me-2"></i>
                        Back to Orders
                    </a>
                    <a href="{{ route('track') }}" class="btn btn-outline-primary" style="border-radius: 15px;">
                        <i class="bi bi-search me-2"></i>
                        Track Another Order
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Edit Customization Modal -->
<div class="modal fade" id="editCustomizationModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" style="background: rgba(0,0,0,0.9) !important; border: none;">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-pencil me-2"></i>Edit Customization Details
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form id="editCustomizationForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" name="order_item_id" id="editOrderItemId">
                    
                    <!-- Message & Details -->
                    <div class="mb-3">
                        <label for="editMessage" class="form-label text-white">Custom Message</label>
                        <textarea class="form-control" id="editMessage" name="message" rows="3" placeholder="Enter your custom message..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="editSpecialRequest" class="form-label text-white">Special Request</label>
                        <textarea class="form-control" id="editSpecialRequest" name="special_request" rows="2" placeholder="Any special requests or instructions..."></textarea>
                    </div>

                    <!-- Product-Specific Fields -->
                    <div class="row gx-3">
                        <div class="col-md-6 mb-3">
                            <label for="editRingSize" class="form-label text-white">Ring Size</label>
                            <select class="form-select" id="editRingSize" name="ring_size">
                                <option value="">Select Ring Size</option>
                                <option value="3">3</option>
                                <option value="3.5">3.5</option>
                                <option value="4">4</option>
                                <option value="4.5">4.5</option>
                                <option value="5">5</option>
                                <option value="5.5">5.5</option>
                                <option value="6">6</option>
                                <option value="6.5">6.5</option>
                                <option value="7">7</option>
                                <option value="7.5">7.5</option>
                                <option value="8">8</option>
                                <option value="8.5">8.5</option>
                                <option value="9">9</option>
                                <option value="9.5">9.5</option>
                                <option value="10">10</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="editApparelSize" class="form-label text-white">Apparel Size</label>
                            <select class="form-select" id="editApparelSize" name="apparel_size">
                                <option value="">Select Size</option>
                                <option value="XS">XS</option>
                                <option value="S">S</option>
                                <option value="M">M</option>
                                <option value="L">L</option>
                                <option value="XL">XL</option>
                                <option value="XXL">XXL</option>
                                <option value="3XL">3XL</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="editFrameSize" class="form-label text-white">Frame Size</label>
                            <select class="form-select" id="editFrameSize" name="frame_size">
                                <option value="">Select Frame Size</option>
                                <option value="small">Small</option>
                                <option value="medium">Medium</option>
                                <option value="large">Large</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="editCupType" class="form-label text-white">Cup Type</label>
                            <select class="form-select" id="editCupType" name="cup_type">
                                <option value="">Select Cup Type</option>
                                <option value="regular">Regular</option>
                                <option value="travel">Travel</option>
                                <option value="insulated">Insulated</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="editCardType" class="form-label text-white">Card Type</label>
                            <select class="form-select" id="editCardType" name="card_type">
                                <option value="">Select Card Type</option>
                                <option value="birthday">Birthday</option>
                                <option value="anniversary">Anniversary</option>
                                <option value="wedding">Wedding</option>
                                <option value="graduation">Graduation</option>
                                <option value="thank_you">Thank You</option>
                                <option value="sympathy">Sympathy</option>
                                <option value="congratulations">Congratulations</option>
                                <option value="get_well">Get Well</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="editPillowSize" class="form-label text-white">Pillow Size</label>
                            <select class="form-select" id="editPillowSize" name="pillow_size">
                                <option value="">Select Pillow Size</option>
                                <option value="standard">Standard</option>
                                <option value="queen">Queen</option>
                                <option value="king">King</option>
                                <option value="body">Body</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="editBlanketSize" class="form-label text-white">Blanket Size</label>
                            <select class="form-select" id="editBlanketSize" name="blanket_size">
                                <option value="">Select Blanket Size</option>
                                <option value="throw">Throw</option>
                                <option value="twin">Twin</option>
                                <option value="full">Full</option>
                                <option value="queen">Queen</option>
                                <option value="king">King</option>
                            </select>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="editMaterial" class="form-label text-white">Material</label>
                            <input type="text" class="form-control" id="editMaterial" name="material" placeholder="Enter material preference">
                        </div>
                    </div>

                    <!-- Delivery Information -->
                    <div class="card border-0" style="background: rgba(0,0,0,0.9) !important;">
                        <div class="card-body">
                            <h6 class="fw-bold mb-3 text-white">Delivery Information</h6>
                            <div class="row gx-3">
                                <div class="col-md-6 mb-3">
                                    <label for="editReceiverName" class="form-label text-white">Receiver Name *</label>
                                    <input type="text" class="form-control" id="editReceiverName" name="receiver_name" required>
                                </div>
                                
                                <div class="col-md-6 mb-3">
                                    <label for="editReceiverPhone" class="form-label text-white">Receiver Phone *</label>
                                    <input type="text" class="form-control" id="editReceiverPhone" name="receiver_phone" required>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label for="editReceiverAddress" class="form-label text-white">Delivery Address *</label>
                                    <textarea class="form-control" id="editReceiverAddress" name="receiver_address" rows="2" required></textarea>
                                </div>
                                
                                <div class="col-12 mb-3">
                                    <label for="editReceiverNote" class="form-label text-white">Delivery Note</label>
                                    <textarea class="form-control" id="editReceiverNote" name="receiver_note" rows="2" placeholder="Any special delivery instructions..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x me-2"></i>Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-check me-2"></i>Update Customization
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Edit customization function
function editCustomization(orderItemId) {
    // Get the order item data
    const orderItem = @json($order->orderItems);
    const item = orderItem.find(item => item.id === orderItemId);
    
    if (!item || !item.customization) {
        alert('Customization data not found');
        return;
    }
    
    const customization = item.customization;
    
    // Populate the form fields
    document.getElementById('editOrderItemId').value = orderItemId;
    document.getElementById('editMessage').value = customization.message || '';
    document.getElementById('editSpecialRequest').value = customization.special_request || '';
    document.getElementById('editRingSize').value = customization.ring_size || '';
    document.getElementById('editApparelSize').value = customization.apparel_size || '';
    document.getElementById('editFrameSize').value = customization.frame_size || '';
    document.getElementById('editCupType').value = customization.cup_type || '';
    document.getElementById('editCardType').value = customization.card_type || '';
    document.getElementById('editPillowSize').value = customization.pillow_size || '';
    document.getElementById('editBlanketSize').value = customization.blanket_size || '';
    document.getElementById('editMaterial').value = customization.material || '';
    document.getElementById('editReceiverName').value = customization.receiver_name || '';
    document.getElementById('editReceiverPhone').value = customization.receiver_phone || '';
    document.getElementById('editReceiverAddress').value = customization.receiver_address || '';
    document.getElementById('editReceiverNote').value = customization.receiver_note || '';
    
    // Set the form action
    document.getElementById('editCustomizationForm').action = '{{ route("orders.update-customization", $order) }}';
    
    // Show the modal
    const modal = new bootstrap.Modal(document.getElementById('editCustomizationModal'));
    modal.show();
}

// Form submission handler
document.getElementById('editCustomizationForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    const submitBtn = this.querySelector('button[type="submit"]');
    const originalText = submitBtn.innerHTML;
    
    submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Updating...';
    submitBtn.disabled = true;
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message and reload page
            alert('Customization updated successfully!');
            window.location.reload();
        } else {
            alert('Error: ' + (data.message || 'Failed to update customization'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error updating customization. Please try again.');
    })
    .finally(() => {
        submitBtn.innerHTML = originalText;
        submitBtn.disabled = false;
    });
});
</script>

@endsection 
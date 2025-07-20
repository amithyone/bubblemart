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

/* Track card styling */
.track-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
}

.track-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Quick action cards */
.quick-action-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
}

.quick-action-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Recent order cards */
.recent-order-card {
    border: none !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3) !important;
    transition: all 0.3s ease;
    overflow: hidden;
    background: linear-gradient(135deg,rgba(16,16,19,0.22) 0%,rgb(0,0,0) 100%) !important;
}

.recent-order-card:hover {
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4) !important;
    transform: translateY(-2px);
}

/* Text color fixes */
.text-theme-1 { color: #ffffff !important; }
.text-secondary { color: #b0b0b0 !important; }
.welcome-label { color: #b0b0b0 !important; }
.welcome-username { color: #ffffff !important; }

/* Form styling */
.form-control {
    background: rgba(255,255,255,0.1) !important;
    border: 1px solid rgba(255,255,255,0.2) !important;
    color: #ffffff !important;
}

.form-control:focus {
    background: rgba(255,255,255,0.15) !important;
    border-color: #ff9800 !important;
    color: #ffffff !important;
    box-shadow: 0 0 0 0.2rem rgba(255,152,0,0.25) !important;
}

.form-control::placeholder {
    color: #b0b0b0 !important;
}

.input-group-text {
    background: rgba(255,255,255,0.1) !important;
    border: 1px solid rgba(255,255,255,0.2) !important;
    color: #b0b0b0 !important;
}

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

/* Alert styling */
.alert-danger {
    background: rgba(220,53,69,0.2) !important;
    border: 1px solid rgba(220,53,69,0.3) !important;
    color: #ffffff !important;
}

/* Mobile padding */
@media (max-width: 768px) {
    .container { padding: 0 15px; }
}

/* Light theme styling for track page */
[data-theme="light"] .track-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .track-card:hover {
    background: #f8f9fa !important;
    border-color: #036674 !important;
    box-shadow: 0 8px 25px rgba(3, 102, 116, 0.2) !important;
}

[data-theme="light"] .quick-action-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .quick-action-card:hover {
    background: #f8f9fa !important;
    border-color: #036674 !important;
    box-shadow: 0 8px 25px rgba(3, 102, 116, 0.2) !important;
}

[data-theme="light"] .recent-order-card {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1) !important;
}

[data-theme="light"] .recent-order-card:hover {
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

/* Light theme form styling */
[data-theme="light"] .form-control {
    background: #ffffff !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: #000000 !important;
}

[data-theme="light"] .form-control:focus {
    background: #ffffff !important;
    border-color: #036674 !important;
    color: #000000 !important;
    box-shadow: 0 0 0 0.2rem rgba(3, 102, 116, 0.25) !important;
}

[data-theme="light"] .form-control::placeholder {
    color: rgba(0, 0, 0, 0.6) !important;
}

[data-theme="light"] .input-group-text {
    background: #f8f9fa !important;
    border: 1px solid rgba(0, 0, 0, 0.1) !important;
    color: rgba(0, 0, 0, 0.7) !important;
}

/* Light theme button styling */
[data-theme="light"] .btn-theme {
    background: #036674 !important;
    color: #ffffff !important;
}

[data-theme="light"] .btn-theme:hover {
    background: #025a66 !important;
    color: #ffffff !important;
    box-shadow: 0 4px 15px rgba(3, 102, 116, 0.3) !important;
}

[data-theme="light"] .btn-outline-primary {
    border: 1px solid #036674 !important;
    color: #036674 !important;
}

[data-theme="light"] .btn-outline-primary:hover {
    background: #036674 !important;
    border-color: #036674 !important;
    color: #ffffff !important;
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

/* Light theme alert styling */
[data-theme="light"] .alert-danger {
    background: #f8d7da !important;
    border: 1px solid #f5c6cb !important;
    color: #721c24 !important;
}

/* Light theme avatar styling */
[data-theme="light"] .bg-theme-1 {
    background: #036674 !important;
}

[data-theme="light"] .text-white {
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

<!-- Track Your Gift Section -->
<div class="row justify-content-center mb-3">
    <div class="col-12">
        <div class="card track-card text-center p-4">
            <div class="mb-4">
                <div class="avatar avatar-80 rounded-circle bg-theme-1 mx-auto mb-3 d-flex align-items-center justify-content-center">
                    <i class="bi bi-truck h1 text-white"></i>
                </div>
                <h4 class="fw-bold mb-2 text-theme-1">Track Your Gift</h4>
                <p class="text-secondary mb-0">Enter your order number or receiver's phone number to track your gift delivery</p>
            </div>
            
            @if(session('error'))
                <div class="alert alert-danger mb-4" style="border-radius: 15px;">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    {{ session('error') }}
                </div>
            @endif
            
            <form action="{{ route('track.order') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <div class="input-group input-group-lg" style="border-radius: 15px; overflow: hidden;">
                        <span class="input-group-text bg-none border-0">
                            <i class="bi bi-search text-secondary"></i>
                        </span>
                        <input type="text" 
                               class="form-control border-0 bg-none" 
                               name="tracking_input" 
                               placeholder="Order number or phone number" 
                               required
                               style="font-size: 1.1rem;">
                    </div>
                </div>
                <button type="submit" class="btn btn-theme btn-lg px-5" style="border-radius: 15px;">
                    <i class="bi bi-search me-2"></i>
                    Track Gift
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row gx-2 mb-3">
    <div class="col-6">
        <div class="card quick-action-card p-3 text-center">
            <div class="avatar avatar-50 rounded-circle bg-theme-1 mx-auto mb-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-box-seam text-white"></i>
            </div>
            <h6 class="mb-1 text-theme-1">My Orders</h6>
            <p class="small text-secondary mb-0">View all orders</p>
        </div>
    </div>
    <div class="col-6">
        <div class="card quick-action-card p-3 text-center">
            <div class="avatar avatar-50 rounded-circle bg-theme-1 mx-auto mb-2 d-flex align-items-center justify-content-center">
                <i class="bi bi-headset text-white"></i>
            </div>
            <h6 class="mb-1 text-theme-1">Support</h6>
            <p class="small text-secondary mb-0">Get help</p>
        </div>
    </div>
</div>

<!-- Recent Orders Preview -->
@auth
<div class="mb-3">
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="fw-bold mb-0 text-theme-1">Recent Orders</h6>
        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="list-group">
        @foreach(auth()->user()->orders()->latest()->take(3)->get() as $order)
        <div class="list-group-item recent-order-card border-0 mb-2">
            <div class="d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="mb-1 text-theme-1">#{{ $order->order_number }}</h6>
                    <p class="small text-secondary mb-0">{{ $order->created_at->format('M d, Y') }}</p>
                </div>
                <div class="text-end">
                    <span class="badge bg-{{ $order->order_status === 'delivered' ? 'success' : ($order->order_status === 'shipped' ? 'info' : 'secondary') }} mb-1">
                        {{ ucfirst($order->order_status) }}
                    </span>
                    <p class="small mb-0 text-theme-1">₦{{ number_format($order->total) }}</p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endauth

@endsection 
@extends('layouts.admin-mobile')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0 text-white">Dashboard</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.orders.analytics') }}" class="mobile-btn mobile-btn-info">
                <i class="fas fa-chart-bar me-1"></i>Analytics
            </a>
            <a href="{{ route('admin.orders.export') }}" class="mobile-btn mobile-btn-secondary">
                <i class="fas fa-download me-1"></i>Export
            </a>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="mobile-stats-grid">
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="mobile-stat-number">{{ $totalOrders }}</div>
            <div class="mobile-stat-label">Total Orders</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="mobile-stat-number">${{ number_format($totalRevenue, 2) }}</div>
            <div class="mobile-stat-label">Total Revenue</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="mobile-stat-number">{{ $totalUsers }}</div>
            <div class="mobile-stat-label">Total Users</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="mobile-stat-number">{{ $totalProducts }}</div>
            <div class="mobile-stat-label">Total Products</div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="mobile-card mb-4">
        <div class="mobile-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mobile-card-title mb-0">
                    <i class="fas fa-clock me-2"></i>Recent Orders
                </h6>
                <a href="{{ route('admin.orders.index') }}" class="mobile-btn mobile-btn-primary btn-sm">
                    View All
                </a>
            </div>
        </div>
        <div class="mobile-card-body">
            @if($recentOrders->count() > 0)
                @foreach($recentOrders as $order)
                    <div class="d-flex justify-content-between align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: var(--dark-border) !important;">
                        <div>
                            <div class="fw-bold">Order #{{ $order->id }}</div>
                            <small class="text-muted">
                                {{ $order->user->name ?? 'Guest' }} • {{ $order->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <div class="text-end">
                            <div class="fw-bold text-success">${{ number_format($order->total_amount, 2) }}</div>
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
                                @default
                                    <span class="badge bg-secondary">{{ ucfirst($order->status) }}</span>
                            @endswitch
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-3">
                    <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">No recent orders</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Recent Users -->
    <div class="mobile-card mb-4">
        <div class="mobile-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h6 class="mobile-card-title mb-0">
                    <i class="fas fa-user-plus me-2"></i>Recent Users
                </h6>
                <a href="{{ route('admin.users.index') }}" class="mobile-btn mobile-btn-primary btn-sm">
                    View All
                </a>
            </div>
        </div>
        <div class="mobile-card-body">
            @if($recentUsers->count() > 0)
                @foreach($recentUsers as $user)
                    <div class="d-flex align-items-center py-2 {{ !$loop->last ? 'border-bottom' : '' }}" style="border-color: var(--dark-border) !important;">
                        <div class="me-3">
                            @if($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" 
                                     alt="{{ $user->name }}" 
                                     class="rounded-circle" 
                                     style="width: 40px; height: 40px; object-fit: cover;"
                                     onerror="this.src='{{ asset('template-assets/img/avatars/1.jpg') }}'">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            @endif
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold">{{ $user->name }}</div>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                        <div class="text-end">
                            <small class="text-muted">{{ $user->created_at->diffForHumans() }}</small>
                            @if($user->is_admin)
                                <div><span class="badge bg-warning">Admin</span></div>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                <div class="text-center py-3">
                    <i class="fas fa-users fa-2x text-muted mb-2"></i>
                    <p class="text-muted mb-0">No recent users</p>
                </div>
            @endif
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="mobile-card mb-4">
        <div class="mobile-card-header">
            <h6 class="mobile-card-title mb-0">
                <i class="fas fa-bolt me-2"></i>Quick Actions
            </h6>
        </div>
        <div class="mobile-card-body">
            <div class="row g-3">
                <div class="col-6">
                    <a href="{{ route('admin.products.create') }}" class="mobile-btn mobile-btn-primary w-100">
                        <i class="fas fa-plus me-2"></i>Add Product
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('admin.categories.create') }}" class="mobile-btn mobile-btn-secondary w-100">
                        <i class="fas fa-tag me-2"></i>Add Category
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('admin.stores.create') }}" class="mobile-btn mobile-btn-info w-100">
                        <i class="fas fa-store me-2"></i>Add Store
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('admin.users.create') }}" class="mobile-btn mobile-btn-warning w-100">
                        <i class="fas fa-user-plus me-2"></i>Add User
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- System Status -->
    <div class="mobile-card">
        <div class="mobile-card-header">
            <h6 class="mobile-card-title mb-0">
                <i class="fas fa-server me-2"></i>System Status
            </h6>
        </div>
        <div class="mobile-card-body">
            <div class="row g-3">
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="fas fa-circle text-success"></i>
                        </div>
                        <div>
                            <small class="text-muted">Database</small>
                            <div class="fw-bold">Online</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="fas fa-circle text-success"></i>
                        </div>
                        <div>
                            <small class="text-muted">Storage</small>
                            <div class="fw-bold">Available</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="fas fa-circle text-success"></i>
                        </div>
                        <div>
                            <small class="text-muted">Email</small>
                            <div class="fw-bold">Configured</div>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="d-flex align-items-center">
                        <div class="me-2">
                            <i class="fas fa-circle text-success"></i>
                        </div>
                        <div>
                            <small class="text-muted">Payments</small>
                            <div class="fw-bold">Active</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-refresh dashboard data every 30 seconds
    setInterval(function() {
        // You can add AJAX calls here to refresh dashboard data
        console.log('Dashboard data refresh interval');
    }, 30000);
});
</script>
@endpush 
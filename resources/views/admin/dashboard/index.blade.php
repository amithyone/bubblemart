@extends('layouts.admin-mobile')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0 text-white">Dashboard</h1>
    </div>

    <!-- Stats Cards -->
    <div class="mobile-stats-grid">
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="mobile-stat-number">{{ number_format($stats['total_users']) }}</div>
            <div class="mobile-stat-label">Total Users</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-dollar-sign"></i>
            </div>
            <div class="mobile-stat-number">₦{{ number_format($stats['total_revenue'], 0) }}</div>
            <div class="mobile-stat-label">Total Revenue</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="mobile-stat-number">{{ number_format($stats['total_orders']) }}</div>
            <div class="mobile-stat-label">Total Orders</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="mobile-stat-number">{{ number_format($stats['total_products']) }}</div>
            <div class="mobile-stat-label">Total Products</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="mobile-stat-number">{{ number_format($stats['total_categories']) }}</div>
            <div class="mobile-stat-label">Categories</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-store"></i>
            </div>
            <div class="mobile-stat-number">{{ number_format($stats['total_stores']) }}</div>
            <div class="mobile-stat-label">Stores</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-wallet"></i>
            </div>
            <div class="mobile-stat-number">₦{{ number_format($stats['total_wallet_balance'], 0) }}</div>
            <div class="mobile-stat-label">Wallet Balance</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-exchange-alt"></i>
            </div>
            <div class="mobile-stat-number">{{ number_format($stats['total_transactions']) }}</div>
            <div class="mobile-stat-label">Transactions</div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Monthly Revenue Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="mobile-card">
                <div class="mobile-card-header">
                    <h6 class="mobile-card-title">Monthly Revenue</h6>
                </div>
                <div class="mobile-card-body">
                    <div class="chart-area">
                        <canvas id="revenueChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Users -->
        <div class="col-xl-4 col-lg-5">
            <div class="mobile-card">
                <div class="mobile-card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="mobile-card-title">Recent Users</h6>
                        <a href="{{ route('admin.users.index') }}" class="mobile-btn mobile-btn-primary">
                            <i class="fas fa-eye me-1"></i>View All
                        </a>
                    </div>
                </div>
                <div class="mobile-card-body">
                    @if($recentUsers->count() > 0)
                        @foreach($recentUsers as $user)
                        <div class="d-flex align-items-center mb-3">
                            <div class="flex-shrink-0">
                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <span class="text-white font-weight-bold">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                <small class="text-muted">{{ $user->email }}</small>
                                <br>
                                <small class="text-muted">Joined {{ $user->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted">No recent users</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="mobile-card">
                <div class="mobile-card-header">
                    <h6 class="mobile-card-title">Quick Actions</h6>
                </div>
                <div class="mobile-card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.products.create') }}" class="mobile-btn mobile-btn-primary w-100">
                                <i class="fas fa-plus me-2"></i>Add Product
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.orders.index') }}" class="mobile-btn mobile-btn-success w-100">
                                <i class="fas fa-shopping-cart me-2"></i>View Orders
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.users.index') }}" class="mobile-btn mobile-btn-info w-100">
                                <i class="fas fa-users me-2"></i>Manage Users
                            </a>
                        </div>
                        <div class="col-md-3 mb-3">
                            <a href="{{ route('admin.categories.index') }}" class="mobile-btn mobile-btn-warning w-100">
                                <i class="fas fa-tags me-2"></i>Manage Categories
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Monthly Revenue Chart
const ctx = document.getElementById('revenueChart').getContext('2d');
const revenueChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($monthlyRevenue->pluck('month')) !!},
        datasets: [{
            label: 'Revenue (₦)',
            data: {!! json_encode($monthlyRevenue->pluck('revenue')) !!},
            borderColor: '#2563eb',
            backgroundColor: 'rgba(37, 99, 235, 0.1)',
            borderWidth: 2,
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    callback: function(value) {
                        return '₦' + value.toLocaleString();
                    }
                }
            }
        }
    }
});
</script>
@endpush
@endsection 
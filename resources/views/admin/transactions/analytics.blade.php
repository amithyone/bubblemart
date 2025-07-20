@extends('layouts.admin-mobile')

@section('title', 'Transaction Analytics')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Transaction Analytics
                </h4>
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Back to Transactions
                </a>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-3">
        <div class="col-6 col-md-3 mb-2">
            <div class="card bg-primary text-white">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Total Transactions</h6>
                            <h4 class="mb-0">{{ number_format($stats['total_transactions']) }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exchange-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <div class="card bg-success text-white">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Total Credits</h6>
                            <h4 class="mb-0">₦{{ number_format($stats['total_credits'], 2) }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-plus-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <div class="card bg-warning text-dark">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Total Debits</h6>
                            <h4 class="mb-0">₦{{ number_format($stats['total_debits'], 2) }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-minus-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-2">
            <div class="card bg-info text-white">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="mb-1">Total Refunds</h6>
                            <h4 class="mb-0">₦{{ number_format($stats['total_refunds'], 2) }}</h4>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-undo fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Monthly Chart -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0"><i class="fas fa-chart-line me-2"></i>Monthly Transaction Trends</h6>
                </div>
                <div class="card-body p-3">
                    <canvas id="monthlyChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Type Distribution -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Transaction Type Distribution</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        @foreach($typeDistribution as $type)
                            <div class="col-md-4 mb-3">
                                <div class="d-flex justify-content-between align-items-center p-2 bg-light rounded">
                                    <div>
                                        <strong>{{ ucfirst($type->type) }}</strong>
                                        <br>
                                        <small class="text-muted">{{ $type->count }} transactions</small>
                                    </div>
                                    <div class="text-end">
                                        <strong class="text-primary">₦{{ number_format($type->total_amount, 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Users -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0"><i class="fas fa-users me-2"></i>Top Users by Transaction Volume</h6>
                </div>
                <div class="card-body p-3">
                    @if($topUsers->count() > 0)
                        @foreach($topUsers as $user)
                            <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                                <div>
                                    <strong>{{ $user->wallet->user->name ?? 'Unknown User' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $user->wallet->user->email ?? 'N/A' }}</small>
                                </div>
                                <div class="text-end">
                                    <strong class="text-primary">₦{{ number_format($user->total_amount, 2) }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $user->transaction_count }} transactions</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">No user data available.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Refunds -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0"><i class="fas fa-undo me-2"></i>Recent Refunds</h6>
                </div>
                <div class="card-body p-3">
                    @if($recentRefunds->count() > 0)
                        @foreach($recentRefunds as $refund)
                            <div class="d-flex justify-content-between align-items-center p-2 border-bottom">
                                <div>
                                    <strong>{{ $refund->wallet->user->name ?? 'Unknown User' }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $refund->description }}</small>
                                </div>
                                <div class="text-end">
                                    <strong class="text-success">₦{{ number_format($refund->amount, 2) }}</strong>
                                    <br>
                                    <small class="text-muted">{{ $refund->created_at->format('M j, Y') }}</small>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <p class="text-muted text-center">No recent refunds.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Monthly Chart
    const monthlyData = @json($monthlyTransactions);
    const months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
    
    const monthlyChart = new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: {
            labels: monthlyData.map(item => months[item.month - 1]),
            datasets: [
                {
                    label: 'Credits',
                    data: monthlyData.map(item => item.credits),
                    borderColor: '#28a745',
                    backgroundColor: 'rgba(40, 167, 69, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Debits',
                    data: monthlyData.map(item => item.debits),
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    tension: 0.4
                },
                {
                    label: 'Refunds',
                    data: monthlyData.map(item => item.refunds),
                    borderColor: '#17a2b8',
                    backgroundColor: 'rgba(23, 162, 184, 0.1)',
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'top',
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
});
</script>
@endpush
@endsection 
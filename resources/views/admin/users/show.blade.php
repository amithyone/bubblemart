@extends('layouts.admin-mobile')

@section('title', 'User Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-white">
                    <i class="fas fa-user me-2"></i>User Details
                </h1>
                <div>
                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit User
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Users
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4">
            <!-- User Profile Card -->
            <div class="card adminuiux-card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-user-circle me-2"></i>Profile Information
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        @if($user->avatar)
                            <img src="{{ asset('storage/' . $user->avatar) }}" alt="User Avatar" class="rounded-circle" width="100" height="100">
                        @else
                            <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 100px; height: 100px;">
                                <i class="fas fa-user fa-3x text-white"></i>
                            </div>
                        @endif
                    </div>
                    
                    <h5 class="text-white mb-1">{{ $user->name }}</h5>
                    <p class="text-muted mb-3">{{ $user->email }}</p>
                    
                    <div class="badge {{ $user->is_admin ? 'bg-success' : 'bg-secondary' }} mb-3">
                        {{ $user->is_admin ? 'Admin User' : 'Regular User' }}
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="text-white h5">{{ $user->orders->count() }}</div>
                            <div class="text-muted small">Orders</div>
                        </div>
                        <div class="col-6">
                            <div class="text-white h5">₦{{ number_format($user->wallet->balance ?? 0, 2) }}</div>
                            <div class="text-muted small">Balance</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="card adminuiux-card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-address-card me-2"></i>Contact Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <small class="text-muted">Phone Number</small><br>
                        <span class="text-white">{{ $user->phone ?? 'Not provided' }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Email Address</small><br>
                        <span class="text-white">{{ $user->email }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Member Since</small><br>
                        <span class="text-white">{{ $user->created_at->format('M j, Y') }}</span>
                    </div>
                    
                    <div class="mb-3">
                        <small class="text-muted">Last Updated</small><br>
                        <span class="text-white">{{ $user->updated_at->format('M j, Y g:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <!-- Recent Orders -->
            <div class="card adminuiux-card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-shopping-bag me-2"></i>Recent Orders
                    </h6>
                    <a href="{{ route('admin.users.orders', $user) }}" class="btn btn-sm btn-primary">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @if($user->orders->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Order #</th>
                                        <th>Status</th>
                                        <th>Total</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->orders->take(5) as $order)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-primary">
                                                {{ $order->order_number }}
                                            </a>
                                        </td>
                                        <td>
                                            <span class="badge bg-{{ $order->order_status === 'delivered' ? 'success' : ($order->order_status === 'shipped' ? 'info' : ($order->order_status === 'processing' ? 'warning' : 'secondary')) }}">
                                                {{ ucfirst($order->order_status) }}
                                            </span>
                                        </td>
                                        <td>₦{{ number_format($order->total, 2) }}</td>
                                        <td>{{ $order->created_at->format('M j, Y') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-shopping-bag fa-3x text-muted mb-3"></i>
                            <h6 class="text-white">No orders yet</h6>
                            <p class="text-muted">This user hasn't placed any orders.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Wallet Transactions -->
            <div class="card adminuiux-card shadow">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-wallet me-2"></i>Recent Wallet Transactions
                    </h6>
                    <a href="{{ route('admin.users.wallet-transactions', $user) }}" class="btn btn-sm btn-primary">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @if($user->wallet && $user->wallet->transactions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($user->wallet->transactions->take(5) as $transaction)
                                    <tr>
                                        <td>
                                            <span class="badge bg-{{ $transaction->type === 'credit' ? 'success' : 'danger' }}">
                                                {{ ucfirst($transaction->type) }}
                                            </span>
                                        </td>
                                        <td class="text-{{ $transaction->type === 'credit' ? 'success' : 'danger' }}">
                                            {{ $transaction->type === 'credit' ? '+' : '-' }}₦{{ number_format($transaction->amount, 2) }}
                                        </td>
                                        <td>{{ $transaction->description }}</td>
                                        <td>{{ $transaction->created_at->format('M j, Y g:i A') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-wallet fa-3x text-muted mb-3"></i>
                            <h6 class="text-white">No transactions yet</h6>
                            <p class="text-muted">This user hasn't made any wallet transactions.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
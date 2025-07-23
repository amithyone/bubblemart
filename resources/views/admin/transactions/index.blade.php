@extends('layouts.admin-mobile')

@section('title', 'Wallet Transactions')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-wallet me-2"></i>Wallet Transactions
                </h4>
                <div class="d-flex gap-2">
                    <a href="{{ route('admin.transactions.analytics') }}" class="btn btn-outline-info btn-sm">
                        <i class="fas fa-chart-bar me-1"></i>Analytics
                    </a>
                    <a href="{{ route('admin.transactions.export') }}" class="btn btn-outline-success btn-sm">
                        <i class="fas fa-download me-1"></i>Export
                    </a>
                </div>
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

    <!-- Filters -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3">
                    <form method="GET" action="{{ route('admin.transactions.index') }}" class="row g-2">
                        <div class="col-md-3">
                            <input type="text" name="search" class="form-control form-control-sm" 
                                   placeholder="Search transactions..." 
                                   value="{{ request('search') }}">
                        </div>
                        <div class="col-md-2">
                            <select name="type" class="form-select form-select-sm">
                                <option value="">All Types</option>
                                <option value="credit" {{ request('type') == 'credit' ? 'selected' : '' }}>Credit</option>
                                <option value="debit" {{ request('type') == 'debit' ? 'selected' : '' }}>Debit</option>
                                <option value="refund" {{ request('type') == 'refund' ? 'selected' : '' }}>Refund</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="status" class="form-select form-select-sm">
                                <option value="">All Status</option>
                                <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <select name="user_id" class="form-select form-select-sm">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-search me-1"></i>Filter
                                </button>
                                <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-times me-1"></i>Clear
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Transactions List -->
    <div class="row">
        <div class="col-12">
            @if($transactions->count() > 0)
                @foreach($transactions as $transaction)
                    <div class="card mb-3">
                        <div class="card-header bg-light py-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-0">
                                        <i class="fas fa-exchange-alt me-2"></i>
                                        Transaction #{{ $transaction->id }}
                                    </h6>
                                </div>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="badge bg-{{ $transaction->type == 'credit' ? 'success' : ($transaction->type == 'debit' ? 'warning' : 'info') }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                    <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <small class="text-muted">User</small>
                                        <p class="mb-1">
                                            <strong>{{ $transaction->wallet->user->name ?? 'N/A' }}</strong>
                                            <br>
                                            <small class="text-muted">{{ $transaction->wallet->user->email ?? 'N/A' }}</small>
                                        </p>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Description</small>
                                        <p class="mb-1"><strong>{{ $transaction->description }}</strong></p>
                                    </div>
                                    @if($transaction->reference_type && $transaction->reference_id)
                                        <div class="mb-2">
                                            <small class="text-muted">Reference</small>
                                            <p class="mb-1">
                                                <strong>{{ ucfirst($transaction->reference_type) }} #{{ $transaction->reference_id }}</strong>
                                            </p>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div class="row">
                                        <div class="col-6">
                                            <small class="text-muted">Amount</small>
                                            <p class="mb-1">
                                                <strong class="text-{{ $transaction->type == 'credit' ? 'success' : ($transaction->type == 'debit' ? 'warning' : 'info') }}">
                                                    {{ $transaction->formatted_amount }}
                                                </strong>
                                            </p>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Balance After</small>
                                            <p class="mb-1">
                                                <strong>₦{{ number_format($transaction->balance_after, 2) }}</strong>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <small class="text-muted">Date</small>
                                        <p class="mb-1">
                                            <strong>{{ $transaction->created_at->format('M j, Y g:i A') }}</strong>
                                        </p>
                                    </div>
                                    @if($transaction->metadata)
                                        <div class="mb-2">
                                            <small class="text-muted">Additional Info</small>
                                            <div class="bg-light p-2 rounded">
                                                @foreach($transaction->metadata as $key => $value)
                                                    <small class="d-block">
                                                        <strong>{{ ucfirst(str_replace('_', ' ', $key)) }}:</strong> 
                                                        {{ $transaction->getFormattedMetadataValue($value) }}
                                                    </small>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('admin.transactions.show', $transaction) }}" 
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-eye me-1"></i>View Details
                                    </a>
                                    
                                    @if($transaction->reference_type == 'order' && $transaction->type == 'debit')
                                        @php
                                            $order = \App\Models\Order::find($transaction->reference_id);
                                        @endphp
                                        @if($order && $order->order_status == 'cancelled' && !$order->refunded_at)
                                            <form action="{{ route('admin.transactions.process-refund', $order) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Process refund for this cancelled order?')">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-undo me-1"></i>Process Refund
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <!-- Pagination -->
                <div class="d-flex justify-content-center">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-wallet fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">No transactions found</h5>
                        <p class="text-muted">Try adjusting your search criteria.</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection 
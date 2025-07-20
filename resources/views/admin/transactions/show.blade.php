@extends('layouts.admin-mobile')

@section('title', 'Transaction Details')

@section('content')
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-exchange-alt me-2"></i>Transaction #{{ $transaction->id }}
                </h4>
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Back to Transactions
                </a>
            </div>
        </div>
    </div>

    <!-- Transaction Status Card -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-{{ $transaction->type == 'credit' ? 'success' : ($transaction->type == 'debit' ? 'warning' : 'info') }} me-2">
                                    {{ ucfirst($transaction->type) }}
                                </span>
                                <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }} me-2">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                                <small class="text-muted">{{ $transaction->created_at->format('M j, Y g:i A') }}</small>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="mb-0 text-{{ $transaction->type == 'credit' ? 'success' : ($transaction->type == 'debit' ? 'warning' : 'info') }}">
                                {{ $transaction->formatted_amount }}
                            </h5>
                            <small class="text-muted">Final Balance: ₦{{ number_format($transaction->balance_after, 2) }}</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Transaction Details -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Transaction Details</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted">Transaction ID</small>
                                <p class="mb-1"><strong>#{{ $transaction->id }}</strong></p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Type</small>
                                <p class="mb-1">
                                    <span class="badge bg-{{ $transaction->type == 'credit' ? 'success' : ($transaction->type == 'debit' ? 'warning' : 'info') }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Status</small>
                                <p class="mb-1">
                                    <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Description</small>
                                <p class="mb-1"><strong>{{ $transaction->description }}</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <small class="text-muted">Amount</small>
                                <p class="mb-1">
                                    <strong class="text-{{ $transaction->type == 'credit' ? 'success' : ($transaction->type == 'debit' ? 'warning' : 'info') }}">
                                        {{ $transaction->formatted_amount }}
                                    </strong>
                                </p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Balance Before</small>
                                <p class="mb-1"><strong>₦{{ number_format($transaction->balance_before, 2) }}</strong></p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Balance After</small>
                                <p class="mb-1"><strong>₦{{ number_format($transaction->balance_after, 2) }}</strong></p>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted">Created At</small>
                                <p class="mb-1"><strong>{{ $transaction->created_at->format('M j, Y g:i A') }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>User Information</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <small class="text-muted">Name</small>
                                <p class="mb-1"><strong>{{ $transaction->wallet->user->name ?? 'N/A' }}</strong></p>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Email</small>
                                <p class="mb-1"><strong>{{ $transaction->wallet->user->email ?? 'N/A' }}</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">
                                <small class="text-muted">Wallet ID</small>
                                <p class="mb-1"><strong>#{{ $transaction->wallet_id }}</strong></p>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Current Balance</small>
                                <p class="mb-1"><strong>₦{{ number_format($transaction->wallet->balance, 2) }}</strong></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reference Information -->
    @if($transaction->reference_type && $transaction->reference_id)
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0"><i class="fas fa-link me-2"></i>Reference Information</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-2">
                                <small class="text-muted">Reference Type</small>
                                <p class="mb-1"><strong>{{ ucfirst($transaction->reference_type) }}</strong></p>
                            </div>
                            <div class="mb-2">
                                <small class="text-muted">Reference ID</small>
                                <p class="mb-1"><strong>#{{ $transaction->reference_id }}</strong></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            @if($relatedOrder)
                                <div class="mb-2">
                                    <small class="text-muted">Order Number</small>
                                    <p class="mb-1"><strong>{{ $relatedOrder->order_number }}</strong></p>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">Order Status</small>
                                    <p class="mb-1">
                                        <span class="badge bg-{{ $relatedOrder->order_status == 'delivered' ? 'success' : ($relatedOrder->order_status == 'cancelled' ? 'danger' : 'info') }}">
                                            {{ ucfirst($relatedOrder->order_status) }}
                                        </span>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($relatedOrder)
                        <div class="mt-3">
                            <a href="{{ route('admin.orders.show', $relatedOrder) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>View Related Order
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Metadata Information -->
    @if($transaction->metadata && count($transaction->metadata) > 0)
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0"><i class="fas fa-database me-2"></i>Additional Information</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        @foreach($transaction->metadata as $key => $value)
                            <div class="col-md-6 mb-2">
                                <small class="text-muted">{{ ucfirst(str_replace('_', ' ', $key)) }}</small>
                                <p class="mb-1"><strong>{{ $value }}</strong></p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-grid gap-2">
                @if($transaction->reference_type == 'order' && $transaction->type == 'debit')
                    @php
                        $order = \App\Models\Order::find($transaction->reference_id);
                    @endphp
                    @if($order && $order->order_status == 'cancelled' && !$order->refunded_at)
                        <form action="{{ route('admin.transactions.process-refund', $order) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success w-100" onclick="return confirm('Process refund for this cancelled order?')">
                                <i class="fas fa-undo me-2"></i>Process Refund
                            </button>
                        </form>
                    @endif
                @endif
                
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Transactions
                </a>
            </div>
        </div>
    </div>
</div>
@endsection 
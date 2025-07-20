<div class="transaction-item" 
     data-bs-toggle="modal" 
     data-bs-target="#transactionModal"
     data-transaction="{{ json_encode($transaction) }}">
    <div class="transaction-icon {{ $transaction->type === 'credit' ? 'bg-success' : 'bg-danger' }}">
        <i class="bi {{ $transaction->type === 'credit' ? 'bi-arrow-up' : 'bi-arrow-down' }} text-white"></i>
    </div>
    <div class="transaction-details">
        <div class="transaction-time">{{ $transaction->created_at->format('g:i A') }}</div>
        <div class="transaction-date">{{ $transaction->created_at->format('M d') }}</div>
        <span class="transaction-status {{ $transaction->status_badge_class }}">
            {{ ucfirst($transaction->status) }}
        </span>
    </div>
    <div class="transaction-amount {{ $transaction->type === 'credit' ? 'text-success' : 'text-danger' }}">
        {{ $transaction->formatted_amount }}
    </div>
</div> 
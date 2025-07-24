@extends('layouts.admin-mobile')

@section('title', 'Order Details')

@section('content')
<div class="container-fluid">
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Order #{{ $order->order_number }}</h4>
                <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i>Back
                </a>
            </div>
        </div>
    </div>

    <!-- Order Status Card -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="d-flex align-items-center">
                                <span class="badge bg-{{ $order->order_status == 'delivered' ? 'success' : ($order->order_status == 'cancelled' ? 'danger' : 'info') }} me-2">
                                    {{ ucfirst($order->order_status) }}
                                </span>
                                <small class="text-muted">{{ $order->created_at->format('M j, Y g:i A') }}</small>
                            </div>
                        </div>
                        <div class="col-6 text-end">
                            <h5 class="mb-0 text-primary">₦{{ number_format($order->total, 2) }}</h5>
                            <small class="text-muted">{{ ucfirst($order->payment_method) }} ({{ ucfirst($order->payment_status) }})</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Detailed Order Information -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2"></i>Order Details</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Order Number</small>
                            <strong>{{ $order->order_number }}</strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Order Date</small>
                            <strong>{{ $order->created_at->format('M j, Y g:i A') }}</strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Payment Method</small>
                            <strong class="text-primary">{{ ucfirst($order->payment_method) }}</strong>
                        </div>
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Payment Status</small>
                            <span class="badge bg-{{ $order->payment_status == 'paid' ? 'success' : ($order->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                        </div>
                        @if($order->tracking_number)
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Tracking Number</small>
                            <strong class="text-info">{{ $order->tracking_number }}</strong>
                        </div>
                        @endif
                        @if($order->paid_at)
                        <div class="col-6 mb-2">
                            <small class="text-muted d-block">Paid At</small>
                            <strong>{{ $order->paid_at->format('M j, Y g:i A') }}</strong>
                        </div>
                        @endif
                    </div>
                    
                    <!-- Order Totals -->
                    <div class="border-top pt-3 mt-3">
                        <h6 class="text-primary mb-2"><i class="fas fa-calculator me-2"></i>Order Totals</h6>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <small class="text-muted d-block">Subtotal</small>
                                <strong>₦{{ number_format($order->subtotal ?? 0, 2) }}</strong>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="text-muted d-block">Tax</small>
                                <strong>₦{{ number_format($order->tax ?? 0, 2) }}</strong>
                            </div>
                            <div class="col-6 mb-2">
                                <small class="text-muted d-block">Shipping</small>
                                <strong>₦{{ number_format($order->shipping ?? 0, 2) }}</strong>
                            </div>
                            @php
                                $totalVariationCost = 0;
                                foreach($order->items as $item) {
                                    if($item->variationOptions) {
                                        $totalVariationCost += $item->variationOptions->sum('price_adjustment');
                                    }
                                }
                            @endphp
                            @if($totalVariationCost != 0)
                            <div class="col-6 mb-2">
                                <small class="text-muted d-block">Variations</small>
                                <strong class="text-{{ $totalVariationCost > 0 ? 'success' : 'danger' }}">{{ $totalVariationCost > 0 ? '+' : '' }}₦{{ number_format($totalVariationCost, 2) }}</strong>
                            </div>
                            @endif
                            <div class="col-6 mb-2">
                                <small class="text-muted d-block">Total</small>
                                <strong class="text-primary fs-5">₦{{ number_format($order->total, 2) }}</strong>
                            </div>
                        </div>
                    </div>

                    <!-- Refund Information -->
                    @if($order->refunded_at)
                        <div class="border-top pt-3 mt-3">
                            <h6 class="text-success mb-2"><i class="fas fa-undo me-2"></i>Refund Information</h6>
                            <div class="row">
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">Refund Amount</small>
                                    <strong class="text-success">₦{{ number_format($order->refund_amount, 2) }}</strong>
                                </div>
                                <div class="col-6 mb-2">
                                    <small class="text-muted d-block">Refund Date</small>
                                    <strong>{{ $order->refunded_at->format('M j, Y g:i A') }}</strong>
                                </div>
                                @if($order->refund_reason)
                                    <div class="col-12 mb-2">
                                        <small class="text-muted d-block">Refund Reason</small>
                                        <strong>{{ $order->refund_reason }}</strong>
                                    </div>
                                @endif
                                @if($order->refund_transaction_id)
                                    <div class="col-12 mb-2">
                                        <small class="text-muted d-block">Transaction ID</small>
                                        <a href="{{ route('admin.transactions.show', $order->refund_transaction_id) }}" class="text-primary">
                                            #{{ $order->refund_transaction_id }}
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @elseif($order->order_status == 'cancelled' && $order->payment_method == 'wallet')
                        <div class="border-top pt-3 mt-3">
                            <div class="alert alert-warning mb-0">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        <strong>Order Cancelled - Refund Pending</strong>
                                        <br>
                                        <small>This order was cancelled and requires a refund to the customer's wallet.</small>
                                    </div>
                                    <form action="{{ route('admin.transactions.process-refund', $order) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" onclick="return confirm('Process refund for this cancelled order?')">
                                            <i class="fas fa-undo me-1"></i>Process Refund
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Customer Info Card -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light py-2">
                    <h6 class="mb-0"><i class="fas fa-user me-2"></i>Customer</h6>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-6">
                            <p class="mb-1"><strong>{{ $order->user->name }}</strong></p>
                            <small class="text-muted">{{ $order->user->email }}</small>
                        </div>
                        <div class="col-6 text-end">
                            @if($order->user->phone)
                                <p class="mb-1"><strong>{{ $order->user->phone }}</strong></p>
                            @endif
                            @if($order->address)
                                <small class="text-muted">{{ $order->address->city }}, {{ $order->address->state }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delivery Information Cards -->
    @if($order->items->whereNotNull('receiver_name')->count() > 0)
    <div class="row mb-3">
        <div class="col-12">
            <h6 class="mb-2"><i class="fas fa-truck me-2"></i>Complete Delivery Information</h6>
            @foreach($order->items as $item)
                @if($item->receiver_name || $item->customization)
                    <div class="card mb-2">
                        <div class="card-header bg-light py-2">
                            <h6 class="mb-0 text-primary">{{ $item->product->name ?? 'Product' }}</h6>
                        </div>
                        <div class="card-body p-3">
                            @if($item->customization)
                                <!-- Complete delivery info from customization object -->
                                <div class="row mb-2">
                                    @if($item->customization->receiver_name)
                                        <div class="col-6">
                                            <small class="text-muted">Receiver Name</small>
                                            <p class="mb-1"><strong>{{ $item->customization->receiver_name }}</strong></p>
                                        </div>
                                    @endif
                                    @if($item->customization->receiver_phone)
                                        <div class="col-6">
                                            <small class="text-muted">Receiver Phone</small>
                                            <p class="mb-1"><strong>{{ $item->customization->receiver_phone }}</strong></p>
                                        </div>
                                    @endif
                                    @if($item->customization->receiver_gender)
                                        <div class="col-6">
                                            <small class="text-muted">Receiver Gender</small>
                                            <p class="mb-1"><strong>{{ ucfirst($item->customization->receiver_gender) }}</strong></p>
                                        </div>
                                    @endif
                                    @if($item->customization->sender_name)
                                        <div class="col-6">
                                            <small class="text-muted">Sender Name</small>
                                            <p class="mb-1"><strong>{{ $item->customization->sender_name }}</strong></p>
                                        </div>
                                    @endif
                                </div>
                                
                                <!-- Complete Address Information -->
                                @if($item->customization->receiver_address || $item->customization->receiver_street || $item->customization->receiver_city || $item->customization->receiver_house_number)
                                    <div class="mb-2">
                                        <small class="text-muted">Complete Delivery Address</small>
                                        <div class="bg-light p-2 rounded">
                                            @if($item->customization->receiver_house_number){{ $item->customization->receiver_house_number }}, @endif
                                            @if($item->customization->receiver_street){{ $item->customization->receiver_street }}, @endif
                                            @if($item->customization->receiver_city){{ $item->customization->receiver_city }}, @endif
                                            @if($item->customization->receiver_state){{ $item->customization->receiver_state }}, @endif
                                            @if($item->customization->receiver_zip){{ $item->customization->receiver_zip }}, @endif
                                            @if($item->customization->receiver_country){{ $item->customization->receiver_country }}@endif
                                        </div>
                                    </div>
                                    
                                    <!-- Detailed Address Breakdown -->
                                    <div class="mb-2">
                                        <small class="text-muted">Address Details Breakdown</small>
                                        <div class="bg-light p-2 rounded">
                                            @if($item->customization->receiver_house_number)
                                                <div class="mb-1"><strong>House/Unit Number:</strong> {{ $item->customization->receiver_house_number }}</div>
                                            @endif
                                            @if($item->customization->receiver_street)
                                                <div class="mb-1"><strong>Street:</strong> {{ $item->customization->receiver_street }}</div>
                                            @endif
                                            @if($item->customization->receiver_city)
                                                <div class="mb-1"><strong>City:</strong> {{ $item->customization->receiver_city }}</div>
                                            @endif
                                            @if($item->customization->receiver_state)
                                                <div class="mb-1"><strong>State/Province:</strong> {{ $item->customization->receiver_state }}</div>
                                            @endif
                                            @if($item->customization->receiver_zip)
                                                <div class="mb-1"><strong>ZIP/Postal Code:</strong> {{ $item->customization->receiver_zip }}</div>
                                            @endif
                                            @if($item->customization->receiver_country)
                                                <div class="mb-1"><strong>Country:</strong> {{ $item->customization->receiver_country }}</div>
                                            @endif
                                        </div>
                                    </div>
                                @elseif($item->customization->receiver_address)
                                    <div class="mb-2">
                                        <small class="text-muted">Delivery Address</small>
                                        <div class="bg-light p-2 rounded">
                                            {{ $item->customization->receiver_address }}
                                        </div>
                                    </div>
                                @endif
                                
                                @if($item->customization->receiver_note)
                                    <div class="mb-2">
                                        <small class="text-muted">Delivery Note</small>
                                        <div class="bg-light p-2 rounded">
                                            {{ $item->customization->receiver_note }}
                                        </div>
                                    </div>
                                @endif
                                
                                @if($item->customization->delivery_method)
                                    <div class="mb-2">
                                        <small class="text-muted">Delivery Method</small>
                                        <p class="mb-1"><strong>{{ ucwords(str_replace('_', ' ', $item->customization->delivery_method)) }}</strong></p>
                                    </div>
                                @endif
                                
                                <!-- Customization Details -->
                                @if($item->customization->type || $item->customization->message || $item->customization->special_request)
                                    <div class="mb-2">
                                        <small class="text-muted">Customization Details</small>
                                        <div class="bg-light p-2 rounded">
                                            @if($item->customization->type)
                                                <div class="mb-1">
                                                    <strong>Type:</strong> {{ ucfirst($item->customization->type) }}
                                                </div>
                                            @endif
                                            @if($item->customization->message)
                                                <div class="mb-1">
                                                    <strong>Message:</strong> {{ $item->customization->message }}
                                                </div>
                                            @endif
                                            @if($item->customization->special_request)
                                                <div class="mb-1">
                                                    <strong>Special Request:</strong> {{ $item->customization->special_request }}
                                                </div>
                                            @endif
                                            @if($item->customization->additional_cost > 0)
                                                <div class="mb-1">
                                                    <strong>Additional Cost:</strong> ₦{{ number_format($item->customization->additional_cost, 2) }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                                
                                @if($item->customization->media_path)
                                    <div class="mb-3">
                                        <h6 class="text-primary mb-2"><i class="fas fa-image me-2"></i>Custom Image</h6>
                                        <div class="text-center">
                                            <img src="{{ asset('storage/' . $item->customization->media_path) }}" 
                                                 alt="Custom Design" 
                                                 class="img-fluid rounded" 
                                                 style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                        </div>
                                    </div>
                                @endif
                            @else
                                <!-- Delivery info from order item fields -->
                                <div class="row mb-2">
                                    @if($item->receiver_name)
                                        <div class="col-6">
                                            <small class="text-muted">Receiver</small>
                                            <p class="mb-1"><strong>{{ $item->receiver_name }}</strong></p>
                                        </div>
                                    @endif
                                    @if($item->receiver_phone)
                                        <div class="col-6">
                                            <small class="text-muted">Phone</small>
                                            <p class="mb-1"><strong>{{ $item->receiver_phone }}</strong></p>
                                        </div>
                                    @endif
                                </div>
                                @if($item->receiver_address)
                                    <div class="mb-2">
                                        <small class="text-muted">Delivery Address</small>
                                        <div class="bg-light p-2 rounded">
                                            {{ $item->receiver_address }}
                                        </div>
                                    </div>
                                @endif
                                @if($item->receiver_note)
                                    <div class="mb-2">
                                        <small class="text-muted">Delivery Note</small>
                                        <div class="bg-light p-2 rounded">
                                            {{ $item->receiver_note }}
                                        </div>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    <!-- Order Items Cards -->
    <div class="row mb-3">
        <div class="col-12">
            <h6 class="mb-2"><i class="fas fa-shopping-bag me-2"></i>Order Items</h6>
            @foreach($order->items as $item)
                <div class="card mb-2">
                    <div class="card-body p-3">
                        <div class="row align-items-center">
                            <div class="col-8">
                                <h6 class="mb-1">{{ $item->product->name ?? 'N/A' }}</h6>
                                <small class="text-muted">{{ $item->product->store->name ?? 'N/A' }}</small>
                                @if($item->customization)
                                    @php
                                        $variations = [];
                                        if ($item->customization->ring_size) $variations[] = 'Ring Size: ' . $item->customization->ring_size;
                                        if ($item->customization->bracelet_size) $variations[] = 'Bracelet: ' . ucfirst($item->customization->bracelet_size);
                                        if ($item->customization->necklace_length) $variations[] = 'Necklace: ' . $item->customization->necklace_length . '"';
                                        if ($item->customization->apparel_size) $variations[] = 'Size: ' . strtoupper($item->customization->apparel_size);
                                        if ($item->customization->frame_size) $variations[] = 'Frame: ' . ucfirst($item->customization->frame_size);
                                        if ($item->customization->cup_type) $variations[] = 'Cup: ' . ucwords(str_replace('_', ' ', $item->customization->cup_type));
                                        if ($item->customization->card_type) $variations[] = 'Card: ' . ucwords(str_replace('_', ' ', $item->customization->card_type));
                                        if ($item->customization->pillow_size) $variations[] = 'Pillow: ' . ucwords(str_replace('_', ' ', $item->customization->pillow_size));
                                        if ($item->customization->blanket_size) $variations[] = 'Blanket: ' . ucfirst($item->customization->blanket_size);
                                        if ($item->customization->material) $variations[] = 'Material: ' . ucwords(str_replace('_', ' ', $item->customization->material));
                                    @endphp
                                    @if(!empty($variations))
                                        <br><small class="text-info">{{ implode(', ', $variations) }}</small>
                                    @endif
                                @endif
                                
                                @if($item->variationOptions && $item->variationOptions->count() > 0)
                                    <br><small class="text-info">
                                        <strong>Product Variations:</strong><br>
                                        @foreach($item->variationOptions as $variation)
                                            <span class="me-2">
                                                {{ ucfirst($variation->variation_name) }}: {{ $variation->option_label }}
                                                @if($variation->price_adjustment > 0)
                                                    <span class="text-success">(+₦{{ number_format($variation->price_adjustment, 2) }})</span>
                                                @elseif($variation->price_adjustment < 0)
                                                    <span class="text-danger">(₦{{ number_format(abs($variation->price_adjustment), 2) }})</span>
                                                @endif
                                            </span>
                                            @if(!$loop->last)<br>@endif
                                        @endforeach
                                    </small>
                                @elseif($item->variation_summary && $item->variation_summary !== 'No variations')
                                    <br><small class="text-info">{{ $item->variation_summary }}</small>
                                @endif
                                

                                <div class="mt-2">
                                    <small class="text-muted">Qty: {{ $item->quantity }} × ₦{{ number_format($item->price, 2) }}</small>
                                    @if($item->variationOptions && $item->variationOptions->count() > 0)
                                        @php
                                            $variationCost = $item->variationOptions->sum('price_adjustment');
                                        @endphp
                                        @if($variationCost != 0)
                                            <br><small class="text-{{ $variationCost > 0 ? 'success' : 'danger' }}">
                                                Variations: {{ $variationCost > 0 ? '+' : '' }}₦{{ number_format($variationCost, 2) }}
                                            </small>
                                        @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <h6 class="mb-1 text-primary">₦{{ number_format($item->total, 2) }}</h6>
                                @if($item->customization || $item->receiver_name || $item->customization_details || ($item->variationOptions && $item->variationOptions->count() > 0))
                                    <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="collapse" data-bs-target="#customization-{{ $item->id }}" aria-expanded="false">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Collapsible Customization Details -->
                        @if($item->customization || $item->receiver_name || $item->customization_details || ($item->variationOptions && $item->variationOptions->count() > 0))
                            <div class="collapse mt-3" id="customization-{{ $item->id }}">
                                <div class="border-top pt-3">
                                    @if($item->customization)
                                        <!-- Customization Summary -->
                                        <div class="mb-3">
                                            <h6 class="text-primary mb-2"><i class="fas fa-magic me-2"></i>Customization Summary</h6>
                                            <div class="row">
                                                <div class="col-6 mb-2">
                                                    <div class="bg-light p-2 rounded">
                                                        <small class="text-muted d-block">Type</small>
                                                        <strong class="text-primary">{{ ucfirst($item->customization->type) }}</strong>
                                                    </div>
                                                </div>
                                                @if($item->customization->additional_cost > 0)
                                                <div class="col-6 mb-2">
                                                    <div class="bg-success bg-opacity-10 p-2 rounded border border-success">
                                                        <small class="text-muted d-block">Additional Cost</small>
                                                        <strong class="text-success">₦{{ number_format($item->customization->additional_cost, 2) }}</strong>
                                                    </div>
                                                </div>
                                                @endif
                                                @if($item->customization->status)
                                                <div class="col-6 mb-2">
                                                    <div class="bg-info bg-opacity-10 p-2 rounded border border-info">
                                                        <small class="text-muted d-block">Status</small>
                                                        <span class="badge bg-{{ $item->customization->status === 'completed' ? 'success' : ($item->customization->status === 'pending' ? 'warning' : 'info') }}">
                                                            {{ ucfirst($item->customization->status) }}
                                                        </span>
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- Customization from Customization model -->
                                        @if($item->customization->sender_name)
                                            <div class="mb-2">
                                                <small class="text-muted">Sender</small>
                                                <p class="mb-1"><strong>{{ $item->customization->sender_name }}</strong></p>
                                            </div>
                                        @endif
                                        @if($item->customization->type)
                                            <div class="mb-2">
                                                <small class="text-muted">Customization Type</small>
                                                <p class="mb-1"><strong>{{ ucfirst($item->customization->type) }}</strong></p>
                                            </div>
                                        @endif
                                        @if($item->customization->message)
                                            <div class="mb-2">
                                                <small class="text-muted">Message</small>
                                                <div class="bg-light p-2 rounded">
                                                    {{ $item->customization->message }}
                                                </div>
                                            </div>
                                        @endif
                                        @if($item->customization->special_request)
                                            <div class="mb-2">
                                                <small class="text-muted">Special Request</small>
                                                <div class="bg-light p-2 rounded">
                                                    {{ $item->customization->special_request }}
                                                </div>
                                            </div>
                                        @endif
                                        @if($item->customization->additional_cost > 0)
                                            <div class="mb-2">
                                                <small class="text-muted">Additional Cost</small>
                                                <p class="mb-1"><strong class="text-success">₦{{ number_format($item->customization->additional_cost, 2) }}</strong></p>
                                            </div>
                                        @endif
                                        
                                        @if($item->customization->status)
                                            <div class="mb-2">
                                                <small class="text-muted">Customization Status</small>
                                                <span class="badge bg-{{ $item->customization->status === 'completed' ? 'success' : ($item->customization->status === 'pending' ? 'warning' : 'info') }}">
                                                    {{ ucfirst($item->customization->status) }}
                                                </span>
                                            </div>
                                        @endif
                                        <!-- Detailed Size and Specifications -->
                                        @if($item->customization->ring_size || $item->customization->bracelet_size || $item->customization->necklace_length || $item->customization->apparel_size || $item->customization->frame_size || $item->customization->cup_type || $item->customization->card_type || $item->customization->pillow_size || $item->customization->blanket_size || $item->customization->material)
                                            <div class="mb-3">
                                                <h6 class="text-primary mb-2"><i class="fas fa-ruler me-2"></i>Size & Specifications</h6>
                                                <div class="row">
                                                    @if($item->customization->ring_size)
                                                        <div class="col-6 mb-2">
                                                            <div class="bg-light p-2 rounded">
                                                                <small class="text-muted d-block">Ring Size</small>
                                                                <strong class="text-primary">{{ $item->customization->ring_size }}</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($item->customization->bracelet_size)
                                                        <div class="col-6 mb-2">
                                                            <div class="bg-light p-2 rounded">
                                                                <small class="text-muted d-block">Bracelet Size</small>
                                                                <strong class="text-primary">{{ ucfirst($item->customization->bracelet_size) }}</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($item->customization->necklace_length)
                                                        <div class="col-6 mb-2">
                                                            <div class="bg-light p-2 rounded">
                                                                <small class="text-muted d-block">Necklace Length</small>
                                                                <strong class="text-primary">{{ $item->customization->necklace_length }}"</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($item->customization->apparel_size)
                                                        <div class="col-6 mb-2">
                                                            <div class="bg-light p-2 rounded">
                                                                <small class="text-muted d-block">Apparel Size</small>
                                                                <strong class="text-primary">{{ strtoupper($item->customization->apparel_size) }}</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($item->customization->frame_size)
                                                        <div class="col-6 mb-2">
                                                            <div class="bg-light p-2 rounded">
                                                                <small class="text-muted d-block">Frame Size</small>
                                                                <strong class="text-primary">{{ ucfirst($item->customization->frame_size) }}</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($item->customization->cup_type)
                                                        <div class="col-6 mb-2">
                                                            <div class="bg-light p-2 rounded">
                                                                <small class="text-muted d-block">Cup Type</small>
                                                                <strong class="text-primary">{{ ucwords(str_replace('_', ' ', $item->customization->cup_type)) }}</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($item->customization->card_type)
                                                        <div class="col-6 mb-2">
                                                            <div class="bg-light p-2 rounded">
                                                                <small class="text-muted d-block">Card Type</small>
                                                                <strong class="text-primary">{{ ucwords(str_replace('_', ' ', $item->customization->card_type)) }}</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($item->customization->pillow_size)
                                                        <div class="col-6 mb-2">
                                                            <div class="bg-light p-2 rounded">
                                                                <small class="text-muted d-block">Pillow Size</small>
                                                                <strong class="text-primary">{{ ucwords(str_replace('_', ' ', $item->customization->pillow_size)) }}</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($item->customization->blanket_size)
                                                        <div class="col-6 mb-2">
                                                            <div class="bg-light p-2 rounded">
                                                                <small class="text-muted d-block">Blanket Size</small>
                                                                <strong class="text-primary">{{ ucfirst($item->customization->blanket_size) }}</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($item->customization->material)
                                                        <div class="col-12 mb-2">
                                                            <div class="bg-warning bg-opacity-10 p-2 rounded border border-warning">
                                                                <small class="text-muted d-block">Material</small>
                                                                <strong class="text-warning">{{ ucwords(str_replace('_', ' ', $item->customization->material)) }}</strong>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Variation Options -->
                                        @if($item->variationOptions && $item->variationOptions->count() > 0)
                                            <div class="mb-3">
                                                <h6 class="text-primary mb-2"><i class="fas fa-tags me-2"></i>Product Variations</h6>
                                                <div class="row">
                                                    @foreach($item->variationOptions as $variation)
                                                        <div class="col-6 mb-2">
                                                            <div class="bg-light p-2 rounded">
                                                                <small class="text-muted d-block">{{ ucwords(str_replace('_', ' ', $variation->variation_name)) }}</small>
                                                                <strong class="text-primary">{{ $variation->option_label }}</strong>
                                                                @if($variation->price_adjustment > 0)
                                                                    <br><small class="text-success">+₦{{ number_format($variation->price_adjustment, 2) }}</small>
                                                                @elseif($variation->price_adjustment < 0)
                                                                    <br><small class="text-danger">-₦{{ number_format(abs($variation->price_adjustment), 2) }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @else
                                        <!-- Customization from OrderItem fields -->
                                        @if($item->customization_details)
                                            <div class="mb-2">
                                                <small class="text-muted">Customization Details</small>
                                                <div class="bg-light p-2 rounded">
                                                    {{ $item->customization_details }}
                                                </div>
                                            </div>
                                        @endif
                                        
                                        <!-- Variation Options for non-customization items -->
                                        @if($item->variationOptions && $item->variationOptions->count() > 0)
                                            <div class="mb-3">
                                                <h6 class="text-primary mb-2"><i class="fas fa-tags me-2"></i>Product Variations</h6>
                                                <div class="row">
                                                    @foreach($item->variationOptions as $variation)
                                                        <div class="col-6 mb-2">
                                                            <div class="bg-light p-2 rounded">
                                                                <small class="text-muted d-block">{{ ucwords(str_replace('_', ' ', $variation->variation_name)) }}</small>
                                                                <strong class="text-primary">{{ $variation->option_label }}</strong>
                                                                @if($variation->price_adjustment > 0)
                                                                    <br><small class="text-success">+₦{{ number_format($variation->price_adjustment, 2) }}</small>
                                                                @elseif($variation->price_adjustment < 0)
                                                                    <br><small class="text-danger">-₦{{ number_format(abs($variation->price_adjustment), 2) }}</small>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Action Buttons -->
    <div class="row mb-3">
        <div class="col-12">
            <div class="d-grid gap-2">
                <a href="{{ route('admin.orders.edit', $order) }}" class="btn btn-primary">
                    <i class="fas fa-edit me-2"></i>Edit Order
                </a>
                @if($order->order_status !== 'delivered' && $order->order_status !== 'cancelled')
                    <form action="{{ route('admin.orders.cancel', $order) }}" method="POST" id="cancelOrderForm">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="_method" value="PATCH">
                        <button type="button" class="btn btn-danger w-100" onclick="showCancelConfirmation()">
                            <i class="fas fa-times me-2"></i>Cancel Order
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Custom Alert Modal -->
<div class="modal fade" id="customAlertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalTitle">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" id="alertModalHeader">
                <h5 class="modal-title" id="alertModalTitle">
                    <i class="fas fa-info-circle me-2"></i>Alert
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-question-circle text-primary" id="alertModalIcon" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center mb-0" id="alertModalMessage">Are you sure you want to proceed?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="alertModalCancel">
                    <i class="fas fa-times me-2"></i>Cancel
                </button>
                <button type="button" class="btn btn-primary" id="alertModalConfirm">
                    <i class="fas fa-check me-2"></i>Confirm
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1" role="dialog" aria-labelledby="successModalTitle">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="successModalTitle">
                    <i class="fas fa-check-circle me-2"></i>Success
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center mb-0" id="successModalMessage">Operation completed successfully!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">
                    <i class="fas fa-check me-2"></i>OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalTitle">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="errorModalTitle">
                    <i class="fas fa-exclamation-triangle me-2"></i>Error
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle text-danger" style="font-size: 3rem;"></i>
                </div>
                <p class="text-center mb-0" id="errorModalMessage">An error occurred. Please try again.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
                    <i class="fas fa-times me-2"></i>Close
                </button>
            </div>
        </div>
    </div>
</div>

<script>
// Global modal instances
let customAlertModalInstance = null;
let successModalInstance = null;
let errorModalInstance = null;

// Custom alert function
function showCustomAlert(title, message, type = 'info', confirmCallback = null) {
    const modal = document.getElementById('customAlertModal');
    const header = document.getElementById('alertModalHeader');
    const titleEl = document.getElementById('alertModalTitle');
    const icon = document.getElementById('alertModalIcon');
    const messageEl = document.getElementById('alertModalMessage');
    const confirmBtn = document.getElementById('alertModalConfirm');
    const cancelBtn = document.getElementById('alertModalCancel');
    
    // Set modal content based on type
    switch(type) {
        case 'warning':
            header.className = 'modal-header bg-warning text-dark';
            titleEl.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + title;
            icon.className = 'fas fa-exclamation-triangle text-warning';
            confirmBtn.className = 'btn btn-warning';
            break;
        case 'danger':
            header.className = 'modal-header bg-danger text-white';
            titleEl.innerHTML = '<i class="fas fa-times-circle me-2"></i>' + title;
            icon.className = 'fas fa-times-circle text-danger';
            confirmBtn.className = 'btn btn-danger';
            break;
        case 'success':
            header.className = 'modal-header bg-success text-white';
            titleEl.innerHTML = '<i class="fas fa-check-circle me-2"></i>' + title;
            icon.className = 'fas fa-check-circle text-success';
            confirmBtn.className = 'btn btn-success';
            break;
        default:
            header.className = 'modal-header bg-primary text-white';
            titleEl.innerHTML = '<i class="fas fa-info-circle me-2"></i>' + title;
            icon.className = 'fas fa-info-circle text-primary';
            confirmBtn.className = 'btn btn-primary';
    }
    
    messageEl.textContent = message;
    
    // Remove existing event listeners
    const newConfirmBtn = confirmBtn.cloneNode(true);
    confirmBtn.parentNode.replaceChild(newConfirmBtn, confirmBtn);
    
    // Set up confirm callback
    if (confirmCallback) {
        newConfirmBtn.onclick = function() {
            confirmCallback();
            if (customAlertModalInstance) {
                customAlertModalInstance.hide();
            }
        };
    } else {
        newConfirmBtn.onclick = function() {
            if (customAlertModalInstance) {
                customAlertModalInstance.hide();
            }
        };
    }
    
    // Create or reuse modal instance
    if (!customAlertModalInstance) {
        customAlertModalInstance = new bootstrap.Modal(modal, {
            backdrop: 'static',
            keyboard: false
        });
    }
    
    customAlertModalInstance.show();
}

// Show success modal
function showSuccessModal(message) {
    document.getElementById('successModalMessage').textContent = message;
    
    if (!successModalInstance) {
        successModalInstance = new bootstrap.Modal(document.getElementById('successModal'), {
            backdrop: 'static',
            keyboard: false
        });
    }
    
    successModalInstance.show();
}

// Show error modal
function showErrorModal(message) {
    document.getElementById('errorModalMessage').textContent = message;
    
    if (!errorModalInstance) {
        errorModalInstance = new bootstrap.Modal(document.getElementById('errorModal'), {
            backdrop: 'static',
            keyboard: false
        });
    }
    
    errorModalInstance.show();
}

// Cancel order confirmation
function showCancelConfirmation() {
    showCustomAlert(
        'Cancel Order',
        'Are you sure you want to cancel this order? This action cannot be undone.',
        'warning',
        function() {
            // Submit the form
            const form = document.getElementById('cancelOrderForm');
            console.log('Submitting form:', form);
            console.log('Form action:', form.action);
            console.log('Form method:', form.method);
            form.submit();
        }
    );
}

// Handle form submission with custom alerts
document.addEventListener('DOMContentLoaded', function() {
    // Check for success/error messages from server
    @if(session('success'))
        showSuccessModal('{{ session('success') }}');
    @endif
    
    @if(session('error'))
        showErrorModal('{{ session('error') }}');
    @endif
    
    @if($errors->any())
        showErrorModal('{{ $errors->first() }}');
    @endif
});

// Cleanup modal instances when page is unloaded
window.addEventListener('beforeunload', function() {
    if (customAlertModalInstance) {
        customAlertModalInstance.dispose();
        customAlertModalInstance = null;
    }
    if (successModalInstance) {
        successModalInstance.dispose();
        successModalInstance = null;
    }
    if (errorModalInstance) {
        errorModalInstance.dispose();
        errorModalInstance = null;
    }
});
</script>

@endsection 
@extends('layouts.admin-mobile')

@section('title', 'Edit Order')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3">Edit Order #{{ $order->order_number }}</h1>
            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-secondary btn-sm mb-3">
                <i class="fas fa-arrow-left me-1"></i>Back to Order
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">Update Order</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.orders.update', $order) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="order_status" class="form-label">Order Status</label>
                            <select class="form-select" id="order_status" name="order_status">
                                <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>Processing</option>
                                <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>Shipped</option>
                                <option value="delivered" {{ $order->order_status == 'delivered' ? 'selected' : '' }}>Delivered</option>
                                <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tracking_number" class="form-label">Tracking Number</label>
                            <input type="text" class="form-control" id="tracking_number" name="tracking_number" value="{{ $order->tracking_number }}">
                        </div>
                        <div class="mb-3">
                            <label for="delivery_note" class="form-label">Delivery Note</label>
                            <textarea class="form-control" id="delivery_note" name="delivery_note" rows="3">{{ $order->delivery_note }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i>Update Order
                        </button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">Order Info</div>
                <div class="card-body">
                    <p><strong>Status:</strong> <span class="badge bg-{{ $order->order_status == 'delivered' ? 'success' : ($order->order_status == 'cancelled' ? 'danger' : 'info') }}">{{ ucfirst($order->order_status) }}</span></p>
                    <p><strong>Payment:</strong> {{ ucfirst($order->payment_method) }} ({{ ucfirst($order->payment_status) }})</p>
                    <p><strong>Total:</strong> ₦{{ number_format($order->total, 2) }}</p>
                    <p><strong>Created At:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                    @if($order->tracking_number)
                        <p><strong>Tracking #:</strong> {{ $order->tracking_number }}</p>
                    @endif
                    @if($order->delivery_note)
                        <p><strong>Delivery Note:</strong> {{ $order->delivery_note }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Customer Info Card -->
            <div class="card mb-4">
                <div class="card-header">Customer Info</div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $order->user->name }}</p>
                    <p><strong>Email:</strong> {{ $order->user->email }}</p>
                    @if($order->user->phone)
                        <p><strong>Phone:</strong> {{ $order->user->phone }}</p>
                    @endif
                    @if($order->address)
                        <p><strong>Address:</strong><br>
                            {{ $order->address->address_line_1 }}<br>
                            {{ $order->address->city }}, {{ $order->address->state }} {{ $order->address->postal_code }}<br>
                            {{ $order->address->country }}
                        </p>
                        <p><strong>Phone:</strong> {{ $order->address->phone }}</p>
                    @endif
                </div>
            </div>
            
            <!-- Order Items Summary -->
            <div class="card mb-4">
                <div class="card-header">Order Items</div>
                <div class="card-body">
                    @foreach($order->items as $item)
                        <div class="mb-3 pb-3 border-bottom">
                            <strong>{{ $item->product->name ?? 'N/A' }}</strong><br>
                            <small class="text-muted">Qty: {{ $item->quantity }} × ₦{{ number_format($item->price, 2) }}</small><br>
                            <small class="text-info">₦{{ number_format($item->total, 2) }}</small>
                            
                            @if($item->customization || $item->receiver_name || $item->customization_details)
                                <div class="mt-2">
                                    <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" data-bs-target="#edit-customization-{{ $item->id }}" aria-expanded="false">
                                        View Customization
                                    </button>
                                    <div class="collapse mt-2" id="edit-customization-{{ $item->id }}">
                                        <div class="card card-body">
                                            @if($item->customization)
                                                @if($item->customization->receiver_name)
                                                    <p><strong>Receiver:</strong> {{ $item->customization->receiver_name }}</p>
                                                @endif
                                                @if($item->customization->receiver_phone)
                                                    <p><strong>Phone:</strong> {{ $item->customization->receiver_phone }}</p>
                                                @endif
                                                @if($item->customization->receiver_note)
                                                    <p><strong>Note:</strong> {{ $item->customization->receiver_note }}</p>
                                                @endif
                                                @if($item->customization->receiver_address || $item->customization->receiver_street || $item->customization->receiver_city)
                                                    <p><strong>Address:</strong><br>
                                                        @if($item->customization->receiver_house_number){{ $item->customization->receiver_house_number }}, @endif
                                                        @if($item->customization->receiver_street){{ $item->customization->receiver_street }}, @endif
                                                        @if($item->customization->receiver_city){{ $item->customization->receiver_city }}, @endif
                                                        @if($item->customization->receiver_state){{ $item->customization->receiver_state }}, @endif
                                                        @if($item->customization->receiver_zip){{ $item->customization->receiver_zip }}@endif
                                                    </p>
                                                @endif
                                            @else
                                                @if($item->receiver_name)
                                                    <p><strong>Receiver:</strong> {{ $item->receiver_name }}</p>
                                                @endif
                                                @if($item->receiver_phone)
                                                    <p><strong>Phone:</strong> {{ $item->receiver_phone }}</p>
                                                @endif
                                                @if($item->receiver_note)
                                                    <p><strong>Note:</strong> {{ $item->receiver_note }}</p>
                                                @endif
                                                @if($item->receiver_address)
                                                    <p><strong>Address:</strong> {{ $item->receiver_address }}</p>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
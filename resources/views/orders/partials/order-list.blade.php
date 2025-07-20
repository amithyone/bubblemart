@foreach($orders as $order)
<a href="{{ route('orders.show', $order) }}" class="list-group-item list-group-action px-3 py-3 order-card mb-3">
    <!-- Order Status -->
    <div class="row gx-3 align-items-center mb-3">
        <div class="col">
            <div class="d-flex align-items-center justify-content-between">
                <span class="badge badge-light text-bg-theme-1 theme-{{ $order->order_status === 'delivered' ? 'green' : ($order->order_status === 'shipped' ? 'shipped' : 'grey') }}">
                    {{ ucfirst($order->order_status) }}
                </span>
                <div class="btn btn-sm btn-square btn-link"><i class="bi bi-arrow-right"></i></div>
            </div>
        </div>
    </div>
    
    <!-- Modern Progress Steps -->
    <div class="progress-container mb-3">
        <div class="progress-track">
            <div class="progress-step {{ in_array($order->order_status, ['pending', 'confirmed', 'shipped', 'delivered']) ? 'completed' : '' }}">
                <div class="step-icon">
                    <i class="bi bi-cart-check"></i>
                </div>
                <div class="step-label">Ordered</div>
            </div>
            <div class="progress-line {{ in_array($order->order_status, ['confirmed', 'shipped', 'delivered']) ? 'completed' : '' }}"></div>
            
            <div class="progress-step {{ in_array($order->order_status, ['confirmed', 'shipped', 'delivered']) ? 'completed' : ($order->order_status === 'pending' ? 'current' : '') }}">
                <div class="step-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="step-label">Confirmed</div>
            </div>
            <div class="progress-line {{ in_array($order->order_status, ['shipped', 'delivered']) ? 'completed' : '' }}"></div>
            
            <div class="progress-step {{ in_array($order->order_status, ['shipped', 'delivered']) ? 'completed' : ($order->order_status === 'confirmed' ? 'current' : '') }}">
                <div class="step-icon">
                    <i class="bi bi-truck"></i>
                </div>
                <div class="step-label">Shipped</div>
            </div>
            <div class="progress-line {{ $order->order_status === 'delivered' ? 'completed' : '' }}"></div>
            
            <div class="progress-step {{ $order->order_status === 'delivered' ? 'completed' : ($order->order_status === 'shipped' ? 'current' : '') }}">
                <div class="step-icon">
                    <i class="bi bi-house-check"></i>
                </div>
                <div class="step-label">Delivered</div>
            </div>
        </div>
    </div>
    
    <!-- Order Details -->
    <div class="row gx-3 align-items-center">
        <div class="col">
            <h6 class="mb-0 text-theme-1">₦{{ number_format($order->total) }}</h6>
            <p class="small text-secondary">#{{ $order->order_number }}</p>
        </div>
        <div class="col">
            <p class="mb-0 text-theme-1">{{ $order->created_at->format('M d, Y') }}</p>
            <p class="small text-secondary">{{ $order->orderItems->count() }} Item{{ $order->orderItems->count() !== 1 ? 's' : '' }}</p>
        </div>
        <div class="col-auto avatar-group">
            @foreach($order->orderItems->take(3) as $item)
            <figure class="avatar avatar-40 coverimg rounded" data-bs-toggle="tooltip" title="{{ $item->product->name }}">
                @if($item->product->image)
                    <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}">
                @else
                    <img src="{{ asset('template-assets/img/ecommerce/image-6.jpg') }}" alt="Product">
                @endif
            </figure>
            @endforeach
            @if($order->orderItems->count() > 3)
            <div class="avatar avatar-40 bg-theme-accent-1 rounded" data-bs-toggle="tooltip" data-bs-html="true" title="+{{ $order->orderItems->count() - 3 }} more items">
                <p>+{{ $order->orderItems->count() - 3 }}</p>
            </div>
            @endif
        </div>
    </div>
</a>
@endforeach 
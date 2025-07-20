<footer class="adminuiux-mobile-footer hide-on-scrolldown style-1">
    <div class="container">
        <ul class="nav nav-pills nav-justified">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                    <i class="bi bi-house d-block mb-1" style="font-size: 1.25rem;"></i>
                    <span class="nav-text">Home</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('customize.*') ? 'active' : '' }}" href="{{ route('customize.index') }}">
                    <i class="bi bi-magic d-block mb-1" style="font-size: 1.25rem;"></i>
                    <span class="nav-text">Customize Gift</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('cart.*') ? 'active' : '' }} position-relative" href="{{ route('cart.index') }}">
                    <i class="bi bi-cart d-block mb-1" style="font-size: 1.25rem;"></i>
                    <span class="nav-text">Cart</span>
                    @php
                        $cartCount = 0;
                        if (session()->has('cart')) {
                            $cartCount = count(session('cart'));
                        }
                    @endphp
                    @if($cartCount > 0)
                        <span class="position-absolute top-0 end-0 badge rounded-pill bg-danger" style="font-size: 0.6rem; transform: translate(50%, -50%);">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ auth()->check() ? route('orders.index') : route('login') }}">
                    <i class="bi bi-bag-check d-block mb-1" style="font-size: 1.25rem;"></i>
                    <span class="nav-text">Orders</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('wallet.*') ? 'active' : '' }}" href="{{ auth()->check() ? route('wallet.index') : route('login') }}">
                    <i class="bi bi-wallet2 d-block mb-1" style="font-size: 1.25rem;"></i>
                    <span class="nav-text">Wallet</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('track*') ? 'active' : '' }}" href="{{ route('track') }}">
                    <i class="bi bi-truck d-block mb-1" style="font-size: 1.25rem;"></i>
                    <span class="nav-text">Track</span>
                </a>
            </li>
        </ul>
    </div>
</footer> 
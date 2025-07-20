<footer class="admin-bottom-nav">
    <div class="container-fluid">
        <ul class="nav nav-pills nav-justified">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt d-block mb-1"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                    <i class="fas fa-box d-block mb-1"></i>
                    <span class="nav-text">Products</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                    <i class="fas fa-shopping-cart d-block mb-1"></i>
                    <span class="nav-text">Orders</span>
                    @php
                        $pendingOrders = \App\Models\Order::where('order_status', 'pending')->count();
                    @endphp
                    @if($pendingOrders > 0)
                        <span class="position-absolute top-0 end-0 badge rounded-pill bg-warning" style="font-size: 0.6rem; transform: translate(50%, -50%);">
                            {{ $pendingOrders }}
                        </span>
                    @endif
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}" href="{{ route('admin.transactions.index') }}">
                    <i class="fas fa-wallet d-block mb-1"></i>
                    <span class="nav-text">Transactions</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="fas fa-users d-block mb-1"></i>
                    <span class="nav-text">Users</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <i class="fas fa-tags d-block mb-1"></i>
                    <span class="nav-text">Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                    <i class="fas fa-cog d-block mb-1"></i>
                    <span class="nav-text">Settings</span>
                </a>
            </li>
        </ul>
    </div>
</footer>

<style>
.admin-bottom-nav {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: var(--bg-primary);
    border-top: 1px solid var(--border-color);
    z-index: 1050;
    padding: 0.5rem 0;
    box-shadow: var(--shadow-lg);
}

.admin-bottom-nav .nav-link {
    color: var(--text-secondary);
    text-decoration: none;
    padding: 0.5rem 0.25rem;
    text-align: center;
    border-radius: 8px;
    transition: all 0.3s ease;
    position: relative;
    font-size: 0.75rem;
}

.admin-bottom-nav .nav-link:hover {
    color: var(--primary-color);
    background: var(--bg-secondary);
}

.admin-bottom-nav .nav-link.active {
    color: var(--primary-color);
    background: var(--bg-secondary);
}

.admin-bottom-nav .nav-link i {
    font-size: 1.1rem;
    margin-bottom: 0.25rem;
}

.admin-bottom-nav .nav-text {
    display: block;
    font-size: 0.7rem;
    font-weight: 500;
}

/* Adjust main content to account for bottom nav */
main {
    margin-bottom: 80px !important;
}

/* Responsive adjustments */
@media (max-width: 576px) {
    .admin-bottom-nav .nav-link {
        padding: 0.4rem 0.15rem;
        font-size: 0.7rem;
    }
    
    .admin-bottom-nav .nav-link i {
        font-size: 1rem;
    }
    
    .admin-bottom-nav .nav-text {
        font-size: 0.65rem;
    }
}
</style> 
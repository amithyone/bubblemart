<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Admin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Template Assets -->
    <script defer src="{{ asset('template-assets/js/app.js') }}"></script>
    <link href="{{ asset('template-assets/css/app.css') }}" rel="stylesheet">
    
    <!-- Custom Dark Theme CSS - Mobile Optimized -->
    <style>
        :root {
            /* Dark theme colors - using template's exact colors */
            --dark-bg: #212529; /* Template's bg-dark color */
            --dark-surface: #2c3034;
            --dark-card: #343a40;
            --dark-border: #495057;
            --dark-text: #ffffff;
            --dark-text-secondary: #adb5bd;
            --dark-accent: #dc3545; /* Red accent */
            --dark-accent-hover: #c82333;
            --dark-gradient: radial-gradient(circle at 30% 30%, #241c02 0, #001816 100%); /* Template's gradient-3 */
        }

        /* Mobile-first responsive design */
        body {
            background: var(--dark-gradient) !important;
            color: var(--dark-text) !important;
            min-height: 100vh;
            font-size: 14px;
        }

        /* Mobile Header */
        .mobile-admin-header {
            background: var(--dark-bg) !important;
            border-bottom: 1px solid var(--dark-border) !important;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1030;
            padding: 0.5rem 1rem;
        }

        .mobile-admin-header .navbar-brand {
            color: var(--dark-accent) !important;
            font-weight: 600;
            font-size: 1.1rem;
        }

        /* Mobile Menu Button */
        .mobile-menu-btn {
            background: var(--dark-accent) !important;
            border: none !important;
            color: var(--dark-text) !important;
            padding: 0.5rem 0.75rem;
            border-radius: 8px;
        }

        .mobile-menu-btn:hover {
            background: var(--dark-accent-hover) !important;
        }

        /* Mobile Sidebar */
        .mobile-sidebar {
            position: fixed;
            top: 0;
            left: -100%;
            width: 280px;
            height: 100vh;
            background: var(--dark-bg) !important;
            border-right: 1px solid var(--dark-border) !important;
            z-index: 1040;
            transition: left 0.3s ease;
            overflow-y: auto;
        }

        .mobile-sidebar.show {
            left: 0;
        }

        .mobile-sidebar-header {
            background: var(--dark-surface) !important;
            padding: 1rem;
            border-bottom: 1px solid var(--dark-border) !important;
        }

        .mobile-sidebar-close {
            background: none;
            border: none;
            color: var(--dark-text) !important;
            font-size: 1.5rem;
        }

        .mobile-sidebar-nav {
            padding: 1rem 0;
        }

        .mobile-sidebar-nav .nav-link {
            color: var(--dark-text-secondary) !important;
            padding: 0.75rem 1rem;
            border-radius: 0;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .mobile-sidebar-nav .nav-link:hover,
        .mobile-sidebar-nav .nav-link.active {
            background: var(--dark-surface) !important;
            color: var(--dark-accent) !important;
        }

        .mobile-sidebar-nav .nav-link i {
            width: 20px;
            text-align: center;
        }

        /* Mobile Content Area */
        .mobile-content {
            margin-top: 70px;
            padding: 1rem;
            min-height: calc(100vh - 70px);
        }

        /* Mobile Cards - Infinite Scroll Style */
        .mobile-card {
            background: var(--dark-card) !important;
            border: 1px solid var(--dark-border) !important;
            border-radius: 12px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .mobile-card:hover {
            border-color: var(--dark-accent) !important;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3) !important;
            transform: translateY(-2px);
        }

        .mobile-card-header {
            background: var(--dark-surface) !important;
            padding: 1rem;
            border-bottom: 1px solid var(--dark-border) !important;
        }

        .mobile-card-body {
            padding: 1rem;
        }

        .mobile-card-title {
            color: var(--dark-text) !important;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .mobile-card-subtitle {
            color: var(--dark-text-secondary) !important;
            font-size: 0.875rem;
            margin-bottom: 0.75rem;
        }

        /* Ensure all text is white by default */
        .mobile-card,
        .mobile-card * {
            color: var(--dark-text) !important;
        }

        .mobile-card .text-muted {
            color: var(--dark-text-secondary) !important;
        }

        .mobile-card .text-success {
            color: #28a745 !important;
        }

        .mobile-card .text-danger {
            color: #dc3545 !important;
        }

        .mobile-card .text-warning {
            color: #ffc107 !important;
        }

        .mobile-card .text-info {
            color: #17a2b8 !important;
        }

        .mobile-card .text-primary {
            color: var(--dark-accent) !important;
        }

        .mobile-card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
        }

        .mobile-card-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .mobile-btn {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
            border-radius: 6px;
            border: none;
            transition: all 0.3s ease;
        }

        .mobile-btn-primary {
            background: var(--dark-accent) !important;
            color: var(--dark-text) !important;
        }

        .mobile-btn-primary:hover {
            background: var(--dark-accent-hover) !important;
        }

        .mobile-btn-secondary {
            background: var(--dark-surface) !important;
            color: var(--dark-text) !important;
            border: 1px solid var(--dark-border) !important;
        }

        .mobile-btn-secondary:hover {
            background: var(--dark-border) !important;
        }

        .mobile-btn-danger {
            background: #dc3545 !important;
            color: var(--dark-text) !important;
        }

        .mobile-btn-danger:hover {
            background: #c82333 !important;
        }

        .mobile-btn-warning {
            background: #ffc107 !important;
            color: #000 !important;
        }

        .mobile-btn-warning:hover {
            background: #e0a800 !important;
        }

        .mobile-btn-info {
            background: #17a2b8 !important;
            color: var(--dark-text) !important;
        }

        .mobile-btn-info:hover {
            background: #138496 !important;
        }

        .mobile-btn-success {
            background: #28a745 !important;
            color: var(--dark-text) !important;
        }

        .mobile-btn-success:hover {
            background: #218838 !important;
        }

        /* Mobile Search and Filters */
        .mobile-search-card {
            background: var(--dark-card) !important;
            border: 1px solid var(--dark-border) !important;
            border-radius: 12px;
            margin-bottom: 1rem;
            padding: 1rem;
        }

        .mobile-search-input {
            background: var(--dark-surface) !important;
            border: 1px solid var(--dark-border) !important;
            color: var(--dark-text) !important;
            border-radius: 8px;
            padding: 0.75rem;
            width: 100%;
            margin-bottom: 0.75rem;
        }

        .mobile-search-input:focus {
            border-color: var(--dark-accent) !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .mobile-filter-row {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .mobile-filter-select {
            background: var(--dark-surface) !important;
            border: 1px solid var(--dark-border) !important;
            color: var(--dark-text) !important;
            border-radius: 6px;
            padding: 0.5rem;
            flex: 1;
            min-width: 120px;
        }

        /* Mobile Stats Cards */
        .mobile-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .mobile-stat-card {
            background: var(--dark-card) !important;
            border: 1px solid var(--dark-border) !important;
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
        }

        .mobile-stat-icon {
            font-size: 2rem;
            color: var(--dark-accent) !important;
            margin-bottom: 0.5rem;
        }

        .mobile-stat-number {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark-text) !important;
            margin-bottom: 0.25rem;
        }

        .mobile-stat-label {
            color: var(--dark-text-secondary) !important;
            font-size: 0.875rem;
        }

        /* Mobile Pagination */
        .mobile-pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 0.5rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .mobile-page-link {
            background: var(--dark-card) !important;
            border: 1px solid var(--dark-border) !important;
            color: var(--dark-text) !important;
            padding: 0.5rem 0.75rem;
            border-radius: 6px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .mobile-page-link:hover,
        .mobile-page-link.active {
            background: var(--dark-accent) !important;
            border-color: var(--dark-accent) !important;
        }

        /* Mobile Alerts */
        .mobile-alert {
            background: var(--dark-card) !important;
            border: 1px solid var(--dark-border) !important;
            border-radius: 8px;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .mobile-alert-success {
            border-left: 4px solid #28a745 !important;
        }

        .mobile-alert-danger {
            border-left: 4px solid #dc3545 !important;
        }

        .mobile-alert-warning {
            border-left: 4px solid #ffc107 !important;
        }

        /* Mobile Overlay */
        .mobile-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1035;
            display: none;
        }

        .mobile-overlay.show {
            display: block;
        }

        /* Mobile Loading */
        .mobile-loading {
            text-align: center;
            padding: 2rem;
            color: var(--dark-text-secondary) !important;
        }

        .mobile-loading-spinner {
            border: 2px solid var(--dark-border);
            border-top: 2px solid var(--dark-accent);
            border-radius: 50%;
            width: 30px;
            height: 30px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Mobile Empty State */
        .mobile-empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--dark-text-secondary) !important;
        }

        .mobile-empty-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        /* Responsive adjustments */
        @media (min-width: 768px) {
            .mobile-content {
                margin-left: 280px;
                margin-top: 0;
            }
            
            .mobile-sidebar {
                left: 0;
                width: 280px;
            }
            
            .mobile-admin-header {
                margin-left: 280px;
            }
        }

        /* Hide desktop elements on mobile */
        @media (max-width: 767px) {
            .desktop-only {
                display: none !important;
            }
        }

        /* Show mobile elements only on mobile */
        @media (min-width: 768px) {
            .mobile-only {
                display: none !important;
            }
        }

        /* Additional text color fixes */
        h1, h2, h3, h4, h5, h6 {
            color: var(--dark-text) !important;
        }

        p, span, div {
            color: var(--dark-text) !important;
        }

        .text-white {
            color: var(--dark-text) !important;
        }

        .text-dark {
            color: var(--dark-text) !important;
        }

        /* Form elements */
        .form-control, .form-select {
            background: var(--dark-surface) !important;
            border: 1px solid var(--dark-border) !important;
            color: var(--dark-text) !important;
        }

        .form-control:focus, .form-select:focus {
            background: var(--dark-surface) !important;
            border-color: var(--dark-accent) !important;
            color: var(--dark-text) !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .form-label {
            color: var(--dark-text) !important;
        }

        /* Tables */
        .table {
            color: var(--dark-text) !important;
        }

        .table th {
            background: var(--dark-surface) !important;
            border-color: var(--dark-border) !important;
            color: var(--dark-text) !important;
        }

        .table td {
            border-color: var(--dark-border) !important;
            color: var(--dark-text) !important;
        }

        /* Dropdowns */
        .dropdown-menu {
            background: var(--dark-card) !important;
            border: 1px solid var(--dark-border) !important;
        }

        .dropdown-item {
            color: var(--dark-text) !important;
        }

        .dropdown-item:hover {
            background: var(--dark-surface) !important;
            color: var(--dark-accent) !important;
        }

        /* Badges */
        .badge {
            color: var(--dark-text) !important;
        }

        /* Buttons */
        .btn {
            color: var(--dark-text) !important;
        }

        .btn-outline-light {
            color: var(--dark-text) !important;
            border-color: var(--dark-border) !important;
        }

        .btn-outline-light:hover {
            background: var(--dark-accent) !important;
            border-color: var(--dark-accent) !important;
        }
    </style>

    <!-- Scripts and Styles -->
    @if(app()->environment('local') && file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @elseif(file_exists(public_path('build/assets/app-NS0_ynA5.css')))
        <!-- Production Assets -->
        <link rel="stylesheet" href="{{ asset('build/assets/app-NS0_ynA5.css') }}">
        <script src="{{ asset('build/assets/app-BDAque31.js') }}" defer></script>
    @else
        <!-- Fallback to CDN (already have Bootstrap loaded above) -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" defer></script>
    @endif
</head>
<body class="font-sans antialiased">
    <div class="min-vh-100">
        <!-- Mobile Header -->
        <nav class="navbar navbar-dark mobile-admin-header">
            <div class="container-fluid">
                <button class="mobile-menu-btn mobile-only" type="button" onclick="toggleMobileSidebar()">
                    <i class="fas fa-bars"></i>
                </button>
                
                <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-crown me-2"></i>Admin Panel
                </a>

                <div class="d-flex align-items-center">
                    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light me-2" target="_blank">
                        <i class="fas fa-external-link-alt"></i>
                    </a>
                    
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-light dropdown-toggle" type="button" data-bs-toggle="dropdown">
                            <i class="fas fa-user"></i>
                        </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('home') }}" target="_blank">
                                <i class="fas fa-external-link-alt me-2"></i>View Main Site
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Mobile Overlay -->
        <div class="mobile-overlay" id="mobileOverlay" onclick="closeMobileSidebar()"></div>

        <!-- Mobile Sidebar -->
        <nav class="mobile-sidebar" id="mobileSidebar">
            <div class="mobile-sidebar-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h6 class="mb-0 text-white">Admin Menu</h6>
                    <button class="mobile-sidebar-close mobile-only" onclick="closeMobileSidebar()">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            
            <div class="mobile-sidebar-nav">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            <span>Dashboard</span>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-users"></i>
                            <span>Users</span>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                            <i class="fas fa-box"></i>
                            <span>Products</span>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Orders</span>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                            <i class="fas fa-tags"></i>
                            <span>Categories</span>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.stores.*') ? 'active' : '' }}" href="{{ route('admin.stores.index') }}">
                            <i class="fas fa-store"></i>
                            <span>Stores</span>
                                </a>
                            </li>
                            
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                            <i class="fas fa-cog"></i>
                            <span>Settings</span>
                        </a>
                    </li>
                    
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.shipping.*') ? 'active' : '' }}" href="{{ route('admin.shipping.index') }}">
                            <i class="fas fa-truck"></i>
                            <span>Shipping</span>
                        </a>
                    </li>
                </ul>

                <hr class="my-3" style="border-color: var(--dark-border);">

                <h6 class="px-3 mb-2 text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Quick Actions</h6>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}" target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                            <span>View Main Site</span>
                                </a>
                            </li>
                        </ul>

                <hr class="my-3" style="border-color: var(--dark-border);">

                <h6 class="px-3 mb-2 text-muted" style="font-size: 0.75rem; text-transform: uppercase;">Reports</h6>
                <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.orders.analytics') }}">
                            <i class="fas fa-chart-bar"></i>
                            <span>Order Analytics</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.orders.export') }}">
                            <i class="fas fa-download"></i>
                            <span>Export Orders</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

        <!-- Mobile Content -->
        <main class="mobile-content">
                        @if(session('success'))
                <div class="mobile-alert mobile-alert-success">
                                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            </div>
                        @endif

                        @if(session('error'))
                <div class="mobile-alert mobile-alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            </div>
                        @endif

                        @if($errors->any())
                <div class="mobile-alert mobile-alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>Please fix the following errors:
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @yield('content')
                </main>
    </div>

    <!-- Admin Bottom Navigation -->
    @include('components.admin-bottom-nav')

    <!-- Custom Alerts -->
    @include('admin.partials.custom-alerts')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Mobile Sidebar Script -->
    <script>
        function toggleMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('mobileOverlay');
            
            sidebar.classList.toggle('show');
            overlay.classList.toggle('show');
        }

        function closeMobileSidebar() {
            const sidebar = document.getElementById('mobileSidebar');
            const overlay = document.getElementById('mobileOverlay');
            
            sidebar.classList.remove('show');
            overlay.classList.remove('show');
        }

        // Close sidebar when clicking on a link (mobile only)
        document.addEventListener('DOMContentLoaded', function() {
            const mobileLinks = document.querySelectorAll('.mobile-sidebar .nav-link');
            mobileLinks.forEach(link => {
                link.addEventListener('click', function() {
                    if (window.innerWidth < 768) {
                        closeMobileSidebar();
                    }
                });
            });
        });

        // Infinite scroll functionality
        let isLoading = false;
        let currentPage = 1;
        let hasMorePages = true;

        function loadMoreContent() {
            if (isLoading || !hasMorePages) return;
            
            isLoading = true;
            currentPage++;
            
            // Show loading indicator
            const loadingDiv = document.createElement('div');
            loadingDiv.className = 'mobile-loading';
            loadingDiv.innerHTML = `
                <div class="mobile-loading-spinner"></div>
                <div>Loading more items...</div>
            `;
            
            const contentContainer = document.querySelector('.mobile-content-container');
            if (contentContainer) {
                contentContainer.appendChild(loadingDiv);
            }
            
            // Simulate loading (replace with actual AJAX call)
            setTimeout(() => {
                if (loadingDiv.parentNode) {
                    loadingDiv.remove();
                }
                isLoading = false;
                
                // Check if we've reached the end
                if (currentPage >= 5) { // Example limit
                    hasMorePages = false;
                }
            }, 1000);
        }

        // Intersection Observer for infinite scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    loadMoreContent();
                }
            });
        });

        // Observe the loading trigger element
        document.addEventListener('DOMContentLoaded', function() {
            const loadingTrigger = document.querySelector('.mobile-loading-trigger');
            if (loadingTrigger) {
                observer.observe(loadingTrigger);
            }
        });
    </script>



    @stack('scripts')
</body>
</html> 
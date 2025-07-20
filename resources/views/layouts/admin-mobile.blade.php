<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Bubblemart Admin</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-light: #3b82f6;
            --primary-dark: #1d4ed8;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #06b6d4;
            --secondary-color: #6b7280;
            
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --bg-card: #ffffff;
            --bg-overlay: #f8fafc;
            
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --text-light: #94a3b8;
            
            --border-color: #e2e8f0;
            --border-light: #f1f5f9;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-secondary);
            color: var(--text-primary);
            line-height: 1.6;
            font-size: 16px;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        /* Mobile Header */
        .mobile-header {
            background: var(--bg-primary);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
        }

        .mobile-header h1 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .mobile-header .btn {
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
        }

        .mobile-btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .mobile-btn-primary:hover {
            background: var(--primary-dark);
            color: white;
        }

        .mobile-btn-secondary {
            background: var(--bg-tertiary);
            color: var(--text-secondary);
        }

        .mobile-btn-secondary:hover {
            background: var(--border-color);
            color: var(--text-primary);
        }



        /* Container */
        .container-fluid {
            padding: 1rem;
            max-width: 100%;
        }

        /* Cards */
        .mobile-card {
            background: var(--bg-card);
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.2s ease;
        }

        .mobile-card:hover {
            box-shadow: var(--shadow-md);
        }

        .mobile-card-header {
            padding: 1rem;
            border-bottom: 1px solid var(--border-light);
            background: var(--bg-secondary);
        }

        .mobile-card-title {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary);
            margin: 0;
        }

        .mobile-card-subtitle {
            font-size: 0.875rem;
            color: var(--text-muted);
            margin-top: 0.25rem;
        }

        .mobile-card-body {
            padding: 1rem;
        }

        .mobile-card-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.75rem;
            font-size: 0.875rem;
        }

        .mobile-card-actions {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
            margin-top: 1rem;
        }

        /* Buttons */
        .mobile-btn {
            font-size: 0.875rem;
            font-weight: 500;
            padding: 0.625rem 1rem;
            border-radius: 8px;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.2s ease;
            cursor: pointer;
            white-space: nowrap;
        }

        .mobile-btn-primary {
            background: var(--primary-color);
            color: white;
        }

        .mobile-btn-primary:hover {
            background: var(--primary-dark);
            color: white;
        }

        .mobile-btn-secondary {
            background: var(--bg-tertiary);
            color: var(--text-secondary);
        }

        .mobile-btn-secondary:hover {
            background: var(--border-color);
            color: var(--text-primary);
        }

        .mobile-btn-success {
            background: var(--success-color);
            color: white;
        }

        .mobile-btn-warning {
            background: var(--warning-color);
            color: white;
        }

        .mobile-btn-danger {
            background: var(--danger-color);
            color: white;
        }

        .mobile-btn-info {
            background: var(--info-color);
            color: white;
        }

        /* Stats Grid */
        .mobile-stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .mobile-stat-card {
            background: var(--bg-card);
            border-radius: 12px;
            padding: 1rem;
            text-align: center;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
        }

        .mobile-stat-icon {
            font-size: 1.5rem;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .mobile-stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.25rem;
        }

        .mobile-stat-label {
            font-size: 0.875rem;
            color: var(--text-muted);
            font-weight: 500;
        }

        /* Search and Filters */
        .mobile-search-card {
            background: var(--bg-card);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
        }

        .mobile-search-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            background: var(--bg-primary);
            color: var(--text-primary);
            margin-bottom: 1rem;
        }

        .mobile-search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgb(37 99 235 / 0.1);
        }

        .mobile-filter-row {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .mobile-filter-select {
            flex: 1;
            min-width: 120px;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 0.875rem;
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        /* Pagination */
        .mobile-pagination {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
            margin-top: 2rem;
            flex-wrap: wrap;
        }

        .mobile-page-link {
            padding: 0.5rem 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .mobile-page-link:hover {
            background: var(--bg-tertiary);
            color: var(--text-primary);
        }

        .mobile-page-link.active {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .mobile-page-link.disabled {
            color: var(--text-light);
            cursor: not-allowed;
        }

        /* Empty State */
        .mobile-empty-state {
            text-align: center;
            padding: 3rem 1rem;
            color: var(--text-muted);
        }

        .mobile-empty-icon {
            font-size: 3rem;
            color: var(--text-light);
            margin-bottom: 1rem;
        }

        /* Badges */
        .badge {
            font-size: 0.75rem;
            font-weight: 500;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
        }

        /* Form Elements */
        .mobile-form-group {
            margin-bottom: 1.5rem;
        }

        .mobile-form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .mobile-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            font-size: 1rem;
            background: var(--bg-primary);
            color: var(--text-primary);
            transition: all 0.2s ease;
        }

        .mobile-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgb(37 99 235 / 0.1);
            background: var(--bg-primary);
            color: var(--text-primary);
        }

        .mobile-input::placeholder {
            color: var(--text-muted);
        }

        select.mobile-input {
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 0.5rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            padding-right: 2.5rem;
        }

        .mobile-checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .mobile-checkbox {
            width: 1.25rem;
            height: 1.25rem;
            accent-color: var(--primary-color);
        }

        .mobile-checkbox-label {
            font-size: 0.875rem;
            color: var(--text-primary);
            margin: 0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .container-fluid {
                padding: 0.75rem;
            }
            
            .mobile-stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .mobile-filter-row {
                flex-direction: column;
            }
            
            .mobile-filter-select {
                min-width: auto;
            }
        }

        @media (min-width: 769px) {
            .mobile-stats-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        /* Loading */
        .mobile-loading-trigger {
            text-align: center;
            padding: 2rem;
            color: var(--text-muted);
        }

        /* Alerts */
        .alert {
            border-radius: 8px;
            border: none;
            padding: 1rem;
            margin-bottom: 1rem;
            font-size: 0.875rem;
        }

        .alert-success {
            background: #ecfdf5;
            color: #065f46;
        }

        .alert-danger {
            background: #fef2f2;
            color: #991b1b;
        }

        .alert-warning {
            background: #fffbeb;
            color: #92400e;
        }

        .alert-info {
            background: #eff6ff;
            color: #1e40af;
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Mobile Header -->
    <div class="mobile-header">
        <div class="d-flex justify-content-between align-items-center">
            <h1>@yield('title')</h1>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.dashboard') }}" class="mobile-btn mobile-btn-secondary">
                    <i class="fas fa-home"></i>
                </a>
                <div class="dropdown">
                    <button class="mobile-btn mobile-btn-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="fas fa-bars"></i>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.products.index') }}">Products</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.categories.index') }}">Categories</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.orders.index') }}">Orders</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.users.index') }}">Users</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.stores.index') }}">Stores</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('admin.settings.index') }}">Settings</a></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>



    <!-- Main Content -->
    <main>
        @if(session('success'))
            <div class="container-fluid">
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="container-fluid">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="container-fluid">
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Admin Bottom Navigation -->
    @include('components.admin-bottom-nav')

    <!-- Custom Alerts -->
    @include('admin.partials.custom-alerts')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @stack('scripts')
</body>
</html> 
@extends('layouts.admin-mobile')

@section('title', 'Mobile Admin Test')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0 text-white">Mobile Admin Interface</h1>
        <a href="{{ route('admin.dashboard') }}" class="mobile-btn mobile-btn-primary">
            <i class="fas fa-arrow-left me-1"></i>Back to Desktop
        </a>
    </div>

    <!-- Info Card -->
    <div class="mobile-card mb-4">
        <div class="mobile-card-header">
            <h6 class="mobile-card-title mb-0">
                <i class="fas fa-info-circle me-2"></i>Mobile Admin Features
            </h6>
        </div>
        <div class="mobile-card-body">
            <div class="row g-3">
                <div class="col-12">
                    <h6 class="text-primary">✅ Features Implemented:</h6>
                    <ul class="text-muted small">
                        <li>Mobile-optimized responsive layout</li>
                        <li>Infinite scroll card list style</li>
                        <li>Comprehensive mobile dropdown menu</li>
                        <li>Touch-friendly buttons and interactions</li>
                        <li>Dark theme optimized for mobile</li>
                        <li>Mobile-specific search and filters</li>
                        <li>Card-based data presentation</li>
                        <li>Mobile pagination</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Navigation -->
    <div class="mobile-card mb-4">
        <div class="mobile-card-header">
            <h6 class="mobile-card-title mb-0">
                <i class="fas fa-compass me-2"></i>Quick Navigation
            </h6>
        </div>
        <div class="mobile-card-body">
            <div class="row g-3">
                <div class="col-6">
                    <a href="{{ route('admin.products.index', ['mobile' => 1]) }}" class="mobile-btn mobile-btn-primary w-100">
                        <i class="fas fa-box me-2"></i>Products
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('admin.orders.index', ['mobile' => 1]) }}" class="mobile-btn mobile-btn-info w-100">
                        <i class="fas fa-shopping-cart me-2"></i>Orders
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('admin.users.index', ['mobile' => 1]) }}" class="mobile-btn mobile-btn-warning w-100">
                        <i class="fas fa-users me-2"></i>Users
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('admin.categories.index', ['mobile' => 1]) }}" class="mobile-btn mobile-btn-secondary w-100">
                        <i class="fas fa-tags me-2"></i>Categories
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('admin.stores.index', ['mobile' => 1]) }}" class="mobile-btn mobile-btn-success w-100">
                        <i class="fas fa-store me-2"></i>Stores
                    </a>
                </div>
                <div class="col-6">
                    <a href="{{ route('admin.dashboard', ['mobile' => 1]) }}" class="mobile-btn mobile-btn-danger w-100">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Sample Data Cards -->
    <div class="mobile-card mb-4">
        <div class="mobile-card-header">
            <h6 class="mobile-card-title mb-0">
                <i class="fas fa-list me-2"></i>Sample Data Cards
            </h6>
        </div>
        <div class="mobile-card-body">
            <!-- Sample Product Card -->
            <div class="mobile-card mb-3">
                <div class="mobile-card-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mobile-card-title mb-1">
                                <i class="fas fa-box me-2 text-primary"></i>
                                Sample Product
                            </h6>
                            <div class="mobile-card-subtitle">
                                <i class="fas fa-hashtag me-1"></i>ID: 123
                                <span class="ms-2">
                                    <i class="fas fa-tag me-1"></i>Electronics
                                </span>
                            </div>
                        </div>
                        <div>
                            <span class="badge bg-success">Active</span>
                        </div>
                    </div>
                </div>
                <div class="mobile-card-body">
                    <div class="mobile-card-meta">
                        <div>
                            <strong class="text-success">$99.99</strong>
                        </div>
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                Created 2 days ago
                            </small>
                        </div>
                    </div>
                    <div class="mobile-card-actions">
                        <button class="mobile-btn mobile-btn-info">
                            <i class="fas fa-eye"></i>
                            <span class="d-none d-sm-inline ms-1">View</span>
                        </button>
                        <button class="mobile-btn mobile-btn-warning">
                            <i class="fas fa-edit"></i>
                            <span class="d-none d-sm-inline ms-1">Edit</span>
                        </button>
                        <button class="mobile-btn mobile-btn-danger">
                            <i class="fas fa-trash"></i>
                            <span class="d-none d-sm-inline ms-1">Delete</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sample Order Card -->
            <div class="mobile-card mb-3">
                <div class="mobile-card-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="mobile-card-title mb-1">
                                <i class="fas fa-receipt me-2 text-primary"></i>
                                Order #456
                            </h6>
                            <div class="mobile-card-subtitle">
                                <i class="fas fa-user me-1"></i>John Doe
                                <span class="ms-2">
                                    <i class="fas fa-envelope me-1"></i>john@example.com
                                </span>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="mb-1">
                                <span class="badge bg-warning">Pending</span>
                            </div>
                            <div>
                                <span class="badge bg-success bg-opacity-75">Paid</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mobile-card-body">
                    <div class="mobile-card-meta">
                        <div>
                            <strong class="text-success">$149.99</strong>
                        </div>
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                Placed 1 hour ago
                            </small>
                        </div>
                    </div>
                    <div class="mobile-card-actions">
                        <button class="mobile-btn mobile-btn-info">
                            <i class="fas fa-eye"></i>
                            <span class="d-none d-sm-inline ms-1">View</span>
                        </button>
                        <button class="mobile-btn mobile-btn-primary">
                            <i class="fas fa-truck"></i>
                            <span class="d-none d-sm-inline ms-1">Ship</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Sample User Card -->
            <div class="mobile-card">
                <div class="mobile-card-header">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                     style="width: 40px; height: 40px;">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                            </div>
                            <div>
                                <h6 class="mobile-card-title mb-1">
                                    Jane Smith
                                    <i class="fas fa-crown text-warning ms-1" title="Admin"></i>
                                </h6>
                                <div class="mobile-card-subtitle">
                                    <i class="fas fa-envelope me-1"></i>jane@example.com
                                    <span class="ms-2">
                                        <i class="fas fa-phone me-1"></i>+1234567890
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <div class="mb-1">
                                <span class="badge bg-warning">Admin</span>
                            </div>
                            <div>
                                <span class="badge bg-success bg-opacity-75">Verified</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mobile-card-body">
                    <div class="mobile-card-meta">
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                Joined 3 months ago
                            </small>
                        </div>
                        <div>
                            <small class="text-muted">
                                <i class="fas fa-wallet me-1"></i>
                                $250.00 Balance
                            </small>
                        </div>
                    </div>
                    <div class="mobile-card-actions">
                        <button class="mobile-btn mobile-btn-info">
                            <i class="fas fa-eye"></i>
                            <span class="d-none d-sm-inline ms-1">View</span>
                        </button>
                        <button class="mobile-btn mobile-btn-warning">
                            <i class="fas fa-edit"></i>
                            <span class="d-none d-sm-inline ms-1">Edit</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Features Demo -->
    <div class="mobile-card">
        <div class="mobile-card-header">
            <h6 class="mobile-card-title mb-0">
                <i class="fas fa-mobile-alt me-2"></i>Mobile Features Demo
            </h6>
        </div>
        <div class="mobile-card-body">
            <div class="row g-3">
                <div class="col-12">
                    <h6 class="text-primary">📱 Mobile-Specific Features:</h6>
                    <ul class="text-muted small">
                        <li><strong>Swipe Navigation:</strong> Swipe left/right to navigate between sections</li>
                        <li><strong>Touch Gestures:</strong> Tap and hold for context menus</li>
                        <li><strong>Pull to Refresh:</strong> Pull down to refresh data</li>
                        <li><strong>Infinite Scroll:</strong> Scroll to bottom to load more items</li>
                        <li><strong>Mobile Menu:</strong> Tap hamburger menu for full navigation</li>
                        <li><strong>Responsive Cards:</strong> Cards adapt to screen size</li>
                        <li><strong>Touch-Friendly Buttons:</strong> Larger touch targets</li>
                        <li><strong>Mobile Search:</strong> Optimized search interface</li>
                    </ul>
                </div>
                <div class="col-12">
                    <h6 class="text-primary">🎨 Design Features:</h6>
                    <ul class="text-muted small">
                        <li><strong>Dark Theme:</strong> Optimized for low-light conditions</li>
                        <li><strong>Card Layout:</strong> Easy-to-scan information cards</li>
                        <li><strong>Status Badges:</strong> Color-coded status indicators</li>
                        <li><strong>Action Buttons:</strong> Quick access to common actions</li>
                        <li><strong>Loading States:</strong> Smooth loading animations</li>
                        <li><strong>Empty States:</strong> Helpful empty state messages</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Demo infinite scroll functionality
    let isLoading = false;
    let demoItems = 0;
    
    function loadMoreDemoItems() {
        if (isLoading) return;
        
        isLoading = true;
        demoItems++;
        
        // Show loading indicator
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'mobile-loading';
        loadingDiv.innerHTML = `
            <div class="mobile-loading-spinner"></div>
            <div>Loading demo items...</div>
        `;
        
        const container = document.querySelector('.mobile-content-container');
        if (container) {
            container.appendChild(loadingDiv);
        }
        
        // Simulate loading
        setTimeout(() => {
            if (loadingDiv.parentNode) {
                loadingDiv.remove();
            }
            isLoading = false;
            
            if (demoItems >= 3) {
                // Stop loading after 3 items
                return;
            }
        }, 1000);
    }
    
    // Intersection Observer for infinite scroll demo
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !isLoading) {
                loadMoreDemoItems();
            }
        });
    });
    
    const loadingTrigger = document.querySelector('.mobile-loading-trigger');
    if (loadingTrigger) {
        observer.observe(loadingTrigger);
    }
});
</script>
@endpush 
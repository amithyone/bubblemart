@extends('layouts.admin-mobile')

@section('title', 'Products Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0 text-white">Products Management</h1>
        <a href="{{ route('admin.products.create') }}" class="mobile-btn mobile-btn-primary">
            <i class="fas fa-plus me-1"></i>Add Product
        </a>
    </div>

    <!-- Search and Filters Card -->
    <div class="mobile-search-card">
        <form method="GET" action="{{ route('admin.products.index') }}">
            <input type="text" 
                   class="mobile-search-input" 
                   name="search" 
                   placeholder="Search products..." 
                   value="{{ request('search') }}">
            
            <div class="mobile-filter-row">
                <select name="category" class="mobile-filter-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                
                <select name="store" class="mobile-filter-select">
                    <option value="">All Stores</option>
                    @foreach($stores as $store)
                        <option value="{{ $store->id }}" {{ request('store') == $store->id ? 'selected' : '' }}>
                            {{ $store->name }}
                        </option>
                    @endforeach
                </select>
                
                <button class="mobile-btn mobile-btn-secondary" type="submit">
                    <i class="fas fa-search me-1"></i>Filter
                </button>
            </div>
        </form>
    </div>

    <!-- Stats Cards -->
    <div class="mobile-stats-grid">
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="mobile-stat-number">{{ $products->total() }}</div>
            <div class="mobile-stat-label">Total Products</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="mobile-stat-number">{{ $products->where('is_active', true)->count() }}</div>
            <div class="mobile-stat-label">Active</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="mobile-stat-number">{{ $products->where('is_active', false)->count() }}</div>
            <div class="mobile-stat-label">Inactive</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-tags"></i>
            </div>
            <div class="mobile-stat-number">{{ $categories->count() }}</div>
            <div class="mobile-stat-label">Categories</div>
        </div>
    </div>

    <!-- Products Container -->
    <div class="mobile-content-container">

        @if($products->count() > 0)
            @foreach($products as $product)
                <div class="mobile-card">
                    <div class="mobile-card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mobile-card-title">{{ $product->name }}</h6>
                                <div class="mobile-card-subtitle">
                                    <i class="fas fa-hashtag me-1"></i>ID: {{ $product->id }}
                                    @if($product->sku)
                                        <span class="ms-2">
                                            <i class="fas fa-barcode me-1"></i>SKU: {{ $product->sku }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                @if($product->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mobile-card-body">
                        <div class="mobile-card-meta">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-tag me-1"></i>
                                    {{ $product->category->name ?? 'No Category' }}
                                </small>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-store me-1"></i>
                                    {{ $product->store->name ?? 'No Store' }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="mobile-card-meta">
                            <div>
                                <strong class="text-success">${{ number_format($product->price, 2) }}</strong>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $product->created_at->format('M d, Y') }}
                                </small>
                            </div>
                        </div>
                        
                        @if($product->description)
                            <p class="text-muted small mb-3">
                                {{ Str::limit($product->description, 100) }}
                            </p>
                        @endif
                        
                        <div class="mobile-card-actions">
                            <a href="{{ route('admin.products.show', $product) }}" 
                               class="mobile-btn mobile-btn-info" 
                               title="View">
                                <i class="fas fa-eye"></i>
                                <span class="d-none d-sm-inline ms-1">View</span>
                            </a>
                            
                            <a href="{{ route('admin.products.edit', $product) }}" 
                               class="mobile-btn mobile-btn-warning" 
                               title="Edit">
                                <i class="fas fa-edit"></i>
                                <span class="d-none d-sm-inline ms-1">Edit</span>
                            </a>
                            
                            <form action="{{ route('admin.products.toggle-status', $product) }}" 
                                  method="POST" 
                                  class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="mobile-btn {{ $product->is_active ? 'mobile-btn-warning' : 'mobile-btn-success' }}" 
                                        title="{{ $product->is_active ? 'Deactivate' : 'Activate' }}">
                                    <i class="fas {{ $product->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                    <span class="d-none d-sm-inline ms-1">{{ $product->is_active ? 'Deactivate' : 'Activate' }}</span>
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.products.destroy', $product) }}" 
                                  method="POST" 
                                  class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this product?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="mobile-btn mobile-btn-danger" 
                                        title="Delete">
                                    <i class="fas fa-trash"></i>
                                    <span class="d-none d-sm-inline ms-1">Delete</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
            
            <!-- Infinite Scroll Trigger -->
            <div class="mobile-loading-trigger" style="height: 20px;"></div>
            
            <!-- Pagination -->
            @if($products->hasPages())
                <div class="mobile-pagination">
                    @if($products->onFirstPage())
                        <span class="mobile-page-link disabled">Previous</span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="mobile-page-link">Previous</a>
                    @endif
                    
                    @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                        @if($page == $products->currentPage())
                            <span class="mobile-page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="mobile-page-link">{{ $page }}</a>
                        @endif
                    @endforeach
                    
                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="mobile-page-link">Next</a>
                    @else
                        <span class="mobile-page-link disabled">Next</span>
                    @endif
                </div>
            @endif
        @else
            <div class="mobile-empty-state">
                <div class="mobile-empty-icon">
                    <i class="fas fa-box-open"></i>
                </div>
                <h5 class="text-muted">No products found</h5>
                <p class="text-muted">Get started by creating your first product.</p>
                <a href="{{ route('admin.products.create') }}" class="mobile-btn mobile-btn-primary">
                    <i class="fas fa-plus me-1"></i>Create Product
                </a>
            </div>
        @endif
    </div>
</div>
</div>
@endsection

<!-- Floating Action Button for Add Product -->
<a href="{{ route('admin.products.create') }}" class="fab-add-product" title="Add Product">
    <i class="fas fa-plus"></i>
</a>

@push('styles')
<style>
.fab-add-product {
    position: fixed;
    right: 24px;
    bottom: 24px;
    z-index: 1000;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    width: 56px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    box-shadow: var(--shadow-lg);
    transition: all 0.2s ease;
    border: none;
}
.fab-add-product:hover {
    background: var(--primary-dark);
    color: white;
    text-decoration: none;
    transform: scale(1.05);
}

/* Status Badge Styling */
.badge {
    font-size: 0.75rem;
    font-weight: 600;
    padding: 0.375rem 0.75rem;
    border-radius: 6px;
    text-transform: uppercase;
    letter-spacing: 0.025em;
}

.badge.bg-success {
    background-color: var(--success-color) !important;
    color: white;
}

.badge.bg-danger {
    background-color: var(--danger-color) !important;
    color: white;
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    $('#productsTable').DataTable({
        "pageLength": 25,
        "order": [[ 0, "desc" ]]
    });
});
</script>
@endpush 
@extends('layouts.admin-mobile')

@section('title', 'Stores Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0 text-white">Stores Management</h1>
        <a href="{{ route('admin.stores.create') }}" class="mobile-btn mobile-btn-primary">
            <i class="fas fa-plus me-1"></i>Add Store
        </a>
    </div>

    <!-- Search and Filters Card -->
    <div class="mobile-search-card">
        <form method="GET" action="{{ route('admin.stores.index') }}">
            <input type="text" 
                   class="mobile-search-input" 
                   name="search" 
                   placeholder="Search stores..." 
                   value="{{ request('search') }}">
            
            <div class="mobile-filter-row">
                <select name="status" class="mobile-filter-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                <i class="fas fa-store"></i>
            </div>
            <div class="mobile-stat-number">{{ $stores->total() }}</div>
            <div class="mobile-stat-label">Total Stores</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="mobile-stat-number">{{ $stores->where('is_active', true)->count() }}</div>
            <div class="mobile-stat-label">Active</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="mobile-stat-number">{{ $stores->where('is_active', false)->count() }}</div>
            <div class="mobile-stat-label">Inactive</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="mobile-stat-number">{{ $totalProducts }}</div>
            <div class="mobile-stat-label">Total Products</div>
        </div>
    </div>

    <!-- Stores Container -->
    <div class="mobile-content-container">

        @if($stores->count() > 0)
            @foreach($stores as $store)
                <div class="mobile-card">
                    <div class="mobile-card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center">
                                @if($store->image_path)
                                    <img src="{{ asset('storage/' . $store->image_path) }}" 
                                         alt="{{ $store->name }}" 
                                         class="me-3" 
                                         style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <div class="me-3 d-flex align-items-center justify-content-center bg-light" 
                                         style="width: 48px; height: 48px; border-radius: 8px;">
                                        <i class="fas fa-store text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mobile-card-title">{{ $store->name }}</h6>
                                    <div class="mobile-card-subtitle">
                                        <i class="fas fa-hashtag me-1"></i>ID: {{ $store->id }}
                                        @if($store->is_featured)
                                            <span class="ms-2">
                                                <i class="fas fa-star me-1"></i>Featured
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div>
                                @if($store->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mobile-card-body">
                        @if($store->description)
                            <p class="text-muted small mb-3">
                                {{ Str::limit($store->description, 100) }}
                            </p>
                        @endif
                        
                        <div class="mobile-card-meta">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ Str::limit($store->address, 50) }}
                                </small>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $store->created_at->format('M d, Y') }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="mobile-card-meta">
                            <div>
                                <strong class="text-info">{{ $store->products_count }} Products</strong>
                            </div>
                            <div>
                                @if($store->phone)
                                    <small class="text-muted">
                                        <i class="fas fa-phone me-1"></i>{{ $store->phone }}
                                    </small>
                                @endif
                            </div>
                        </div>
                        
                        @if($store->email)
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-envelope me-1"></i>{{ $store->email }}
                                </small>
                            </div>
                        @endif
                        
                        @if($store->website_url)
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-globe me-1"></i>{{ $store->website_url }}
                                </small>
                            </div>
                        @endif
                        
                        <div class="mobile-card-actions">
                            <a href="{{ route('admin.stores.show', $store) }}" 
                               class="mobile-btn mobile-btn-info" 
                               title="View">
                                <i class="fas fa-eye"></i>
                                <span class="d-none d-sm-inline ms-1">View</span>
                            </a>
                            
                            <a href="{{ route('admin.stores.edit', $store) }}" 
                               class="mobile-btn mobile-btn-warning" 
                               title="Edit">
                                <i class="fas fa-edit"></i>
                                <span class="d-none d-sm-inline ms-1">Edit</span>
                            </a>
                            
                            <a href="{{ route('admin.stores.products', $store) }}" 
                               class="mobile-btn mobile-btn-primary" 
                               title="Products">
                                <i class="fas fa-box"></i>
                                <span class="d-none d-sm-inline ms-1">Products</span>
                            </a>
                            
                            <form action="{{ route('admin.stores.toggle-status', $store) }}" 
                                  method="POST" 
                                  class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="mobile-btn {{ $store->is_active ? 'mobile-btn-warning' : 'mobile-btn-success' }}" 
                                        title="{{ $store->is_active ? 'Deactivate' : 'Activate' }}">
                                    <i class="fas {{ $store->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                    <span class="d-none d-sm-inline ms-1">{{ $store->is_active ? 'Deactivate' : 'Activate' }}</span>
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.stores.destroy', $store) }}" 
                                  method="POST" 
                                  class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this store?')">
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
            @if($stores->hasPages())
                <div class="mobile-pagination">
                    @if($stores->onFirstPage())
                        <span class="mobile-page-link disabled">Previous</span>
                    @else
                        <a href="{{ $stores->previousPageUrl() }}" class="mobile-page-link">Previous</a>
                    @endif
                    
                    @foreach($stores->getUrlRange(1, $stores->lastPage()) as $page => $url)
                        @if($page == $stores->currentPage())
                            <span class="mobile-page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="mobile-page-link">{{ $page }}</a>
                        @endif
                    @endforeach
                    
                    @if($stores->hasMorePages())
                        <a href="{{ $stores->nextPageUrl() }}" class="mobile-page-link">Next</a>
                    @else
                        <span class="mobile-page-link disabled">Next</span>
                    @endif
                </div>
            @endif
        @else
            <div class="mobile-empty-state">
                <div class="mobile-empty-icon">
                    <i class="fas fa-store"></i>
                </div>
                <h5 class="text-muted">No stores found</h5>
                <p class="text-muted">Get started by creating your first store.</p>
                <a href="{{ route('admin.stores.create') }}" class="mobile-btn mobile-btn-primary">
                    <i class="fas fa-plus me-1"></i>Create Store
                </a>
            </div>
        @endif
    </div>
</div>
</div>
@endsection

<!-- Floating Action Button for Add Store -->
<a href="{{ route('admin.stores.create') }}" class="fab-add-store" title="Add Store">
    <i class="fas fa-plus"></i>
</a>

@push('styles')
<style>
.fab-add-store {
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
.fab-add-store:hover {
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

.badge.bg-info {
    background-color: var(--info-color) !important;
    color: white;
}

.badge.bg-primary {
    background-color: var(--primary-color) !important;
    color: white;
}

.badge.bg-secondary {
    background-color: var(--secondary-color) !important;
    color: white;
}
</style>
@endpush

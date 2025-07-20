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

    <!-- Search Card -->
    <div class="mobile-search-card">
        <form method="GET" action="{{ route('admin.stores.index') }}">
            <input type="text" 
                   class="mobile-search-input" 
                   name="search" 
                   placeholder="Search stores by name, location, or contact..." 
                   value="{{ request('search') }}">
            
            <div class="mobile-filter-row">
                <select name="status" class="mobile-filter-select">
                    <option value="">All Statuses</option>
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
                <i class="fas fa-box"></i>
            </div>
            <div class="mobile-stat-number">{{ $totalProducts }}</div>
            <div class="mobile-stat-label">Total Products</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="mobile-stat-number">{{ $stores->unique('location')->count() }}</div>
            <div class="mobile-stat-label">Locations</div>
        </div>
    </div>

    <!-- Stores Container -->
    <div class="mobile-content-container">
        @if($stores->count() > 0)
            @foreach($stores as $store)
                <div class="mobile-card">
                    <div class="mobile-card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mobile-card-title">
                                    <i class="fas fa-store me-2 text-primary"></i>
                                    {{ $store->name }}
                                </h6>
                                <div class="mobile-card-subtitle">
                                    <i class="fas fa-hashtag me-1"></i>ID: {{ $store->id }}
                                    @if($store->owner)
                                        <span class="ms-2">
                                            <i class="fas fa-user me-1"></i>Owner: {{ $store->owner->name }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                @if($store->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mobile-card-body">
                        <div class="mobile-card-meta">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $store->location ?? 'Location not specified' }}
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
                                <small class="text-muted">
                                    <i class="fas fa-box me-1"></i>
                                    {{ $store->products->count() }} Products
                                </small>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-phone me-1"></i>
                                    {{ $store->contact_number ?? 'No contact' }}
                                </small>
                            </div>
                        </div>
                        
                        @if($store->description)
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-info-circle me-1"></i>Description:
                                </small>
                                <p class="text-muted small mb-0 mt-1">
                                    {{ Str::limit($store->description, 100) }}
                                </p>
                            </div>
                        @endif
                        
                        @if($store->products->count() > 0)
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-list me-1"></i>Top Products:
                                </small>
                                <div class="mt-1">
                                    @foreach($store->products->take(3) as $product)
                                        <span class="badge bg-secondary me-1">
                                            {{ $product->name }}
                                        </span>
                                    @endforeach
                                    @if($store->products->count() > 3)
                                        <span class="badge bg-secondary">+{{ $store->products->count() - 3 }} more</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        @if($store->website)
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-globe me-1"></i>Website:
                                </small>
                                <div class="mt-1">
                                    <a href="{{ $store->website }}" 
                                       target="_blank" 
                                       class="text-primary text-decoration-none">
                                        {{ $store->website }}
                                    </a>
                                </div>
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
                            
                            <form action="{{ route('admin.stores.toggle-status', $store) }}" 
                                  method="POST" 
                                  class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" 
                                        class="mobile-btn mobile-btn-secondary" 
                                        title="Toggle Status">
                                    <i class="fas fa-toggle-on"></i>
                                    <span class="d-none d-sm-inline ms-1">Toggle</span>
                                </button>
                            </form>
                            
                            <a href="{{ route('admin.products.index', ['store' => $store->id]) }}" 
                               class="mobile-btn mobile-btn-primary" 
                               title="View Products">
                                <i class="fas fa-box"></i>
                                <span class="d-none d-sm-inline ms-1">Products</span>
                            </a>
                            
                            <form action="{{ route('admin.stores.destroy', $store) }}" 
                                  method="POST" 
                                  class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this store? This will also delete all associated products.')">
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
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize infinite scroll
    let isLoading = false;
    let currentPage = {{ $stores->currentPage() }};
    let hasMorePages = {{ $stores->hasMorePages() ? 'true' : 'false' }};
    
    function loadMoreStores() {
        if (isLoading || !hasMorePages) return;
        
        isLoading = true;
        currentPage++;
        
        // Show loading indicator
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'mobile-loading';
        loadingDiv.innerHTML = `
            <div class="mobile-loading-spinner"></div>
            <div>Loading more stores...</div>
        `;
        
        const container = document.querySelector('.mobile-content-container');
        container.appendChild(loadingDiv);
        
        // Fetch next page
        const url = new URL(window.location);
        url.searchParams.set('page', currentPage);
        
        fetch(url)
            .then(response => response.text())
            .then(html => {
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newStores = doc.querySelectorAll('.mobile-card');
                
                // Remove loading indicator
                loadingDiv.remove();
                
                // Add new stores
                newStores.forEach(store => {
                    container.appendChild(store.cloneNode(true));
                });
                
                // Update pagination state
                hasMorePages = newStores.length > 0;
                isLoading = false;
            })
            .catch(error => {
                console.error('Error loading more stores:', error);
                loadingDiv.remove();
                isLoading = false;
            });
    }
    
    // Intersection Observer for infinite scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !isLoading) {
                loadMoreStores();
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
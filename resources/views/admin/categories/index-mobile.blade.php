@extends('layouts.admin-mobile')

@section('title', 'Categories Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0 text-white">Categories Management</h1>
        <a href="{{ route('admin.categories.create') }}" class="mobile-btn mobile-btn-primary">
            <i class="fas fa-plus me-1"></i>Add Category
        </a>
    </div>

    <!-- Search Card -->
    <div class="mobile-search-card">
        <form method="GET" action="{{ route('admin.categories.index') }}">
            <input type="text" 
                   class="mobile-search-input" 
                   name="search" 
                   placeholder="Search categories..." 
                   value="{{ request('search') }}">
            
            <div class="mobile-filter-row">
                <select name="parent" class="mobile-filter-select">
                    <option value="">All Categories</option>
                    <option value="0" {{ request('parent') === '0' ? 'selected' : '' }}>Main Categories</option>
                    @foreach($categories as $category)
                        @if($category->parent_id === null)
                            <option value="{{ $category->id }}" {{ request('parent') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endif
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
                <i class="fas fa-tags"></i>
            </div>
            <div class="mobile-stat-number">{{ $categories->total() }}</div>
            <div class="mobile-stat-label">Total Categories</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-folder"></i>
            </div>
            <div class="mobile-stat-number">{{ $categories->where('parent_id', null)->count() }}</div>
            <div class="mobile-stat-label">Main Categories</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-folder-open"></i>
            </div>
            <div class="mobile-stat-number">{{ $categories->where('parent_id', '!=', null)->count() }}</div>
            <div class="mobile-stat-label">Subcategories</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-box"></i>
            </div>
            <div class="mobile-stat-number">{{ $totalProducts }}</div>
            <div class="mobile-stat-label">Total Products</div>
        </div>
    </div>

    <!-- Categories Container -->
    <div class="mobile-content-container">
        @if($categories->count() > 0)
            @foreach($categories as $category)
                <div class="mobile-card">
                    <div class="mobile-card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mobile-card-title">
                                    @if($category->parent_id)
                                        <i class="fas fa-level-down-alt me-2 text-muted"></i>
                                    @else
                                        <i class="fas fa-tag me-2 text-primary"></i>
                                    @endif
                                    {{ $category->name }}
                                </h6>
                                <div class="mobile-card-subtitle">
                                    <i class="fas fa-hashtag me-1"></i>ID: {{ $category->id }}
                                    @if($category->parent_id)
                                        <span class="ms-2">
                                            <i class="fas fa-level-up-alt me-1"></i>Parent: {{ $category->parent->name ?? 'Unknown' }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                @if($category->is_active)
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
                                    <i class="fas fa-box me-1"></i>
                                    {{ $category->products_count ?? 0 }} Products
                                </small>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $category->created_at->format('M d, Y') }}
                                </small>
                            </div>
                        </div>
                        
                        @if($category->description)
                            <p class="text-muted small mb-3">
                                {{ Str::limit($category->description, 100) }}
                            </p>
                        @endif
                        
                        @if($category->children->count() > 0)
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-folder-open me-1"></i>
                                    {{ $category->children->count() }} Subcategories:
                                </small>
                                <div class="mt-1">
                                    @foreach($category->children->take(3) as $child)
                                        <span class="badge bg-secondary me-1">{{ $child->name }}</span>
                                    @endforeach
                                    @if($category->children->count() > 3)
                                        <span class="badge bg-secondary">+{{ $category->children->count() - 3 }} more</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        <div class="mobile-card-actions">
                            <a href="{{ route('admin.categories.show', $category) }}" 
                               class="mobile-btn mobile-btn-info" 
                               title="View">
                                <i class="fas fa-eye"></i>
                                <span class="d-none d-sm-inline ms-1">View</span>
                            </a>
                            
                            <a href="{{ route('admin.categories.edit', $category) }}" 
                               class="mobile-btn mobile-btn-warning" 
                               title="Edit">
                                <i class="fas fa-edit"></i>
                                <span class="d-none d-sm-inline ms-1">Edit</span>
                            </a>
                            
                            <form action="{{ route('admin.categories.toggle-status', $category) }}" 
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
                            
                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this category? This will also delete all subcategories and move products to uncategorized.')">
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
            @if($categories->hasPages())
                <div class="mobile-pagination">
                    @if($categories->onFirstPage())
                        <span class="mobile-page-link disabled">Previous</span>
                    @else
                        <a href="{{ $categories->previousPageUrl() }}" class="mobile-page-link">Previous</a>
                    @endif
                    
                    @foreach($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                        @if($page == $categories->currentPage())
                            <span class="mobile-page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="mobile-page-link">{{ $page }}</a>
                        @endif
                    @endforeach
                    
                    @if($categories->hasMorePages())
                        <a href="{{ $categories->nextPageUrl() }}" class="mobile-page-link">Next</a>
                    @else
                        <span class="mobile-page-link disabled">Next</span>
                    @endif
                </div>
            @endif
        @else
            <div class="mobile-empty-state">
                <div class="mobile-empty-icon">
                    <i class="fas fa-tags"></i>
                </div>
                <h5 class="text-muted">No categories found</h5>
                <p class="text-muted">Get started by creating your first category.</p>
                <a href="{{ route('admin.categories.create') }}" class="mobile-btn mobile-btn-primary">
                    <i class="fas fa-plus me-1"></i>Create Category
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
    let currentPage = {{ $categories->currentPage() }};
    let hasMorePages = {{ $categories->hasMorePages() ? 'true' : 'false' }};
    
    function loadMoreCategories() {
        if (isLoading || !hasMorePages) return;
        
        isLoading = true;
        currentPage++;
        
        // Show loading indicator
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'mobile-loading';
        loadingDiv.innerHTML = `
            <div class="mobile-loading-spinner"></div>
            <div>Loading more categories...</div>
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
                const newCategories = doc.querySelectorAll('.mobile-card');
                
                // Remove loading indicator
                loadingDiv.remove();
                
                // Add new categories
                newCategories.forEach(category => {
                    container.appendChild(category.cloneNode(true));
                });
                
                // Update pagination state
                hasMorePages = newCategories.length > 0;
                isLoading = false;
            })
            .catch(error => {
                console.error('Error loading more categories:', error);
                loadingDiv.remove();
                isLoading = false;
            });
    }
    
    // Intersection Observer for infinite scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !isLoading) {
                loadMoreCategories();
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
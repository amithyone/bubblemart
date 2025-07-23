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

    <!-- Search and Filters Card -->
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
                    <option value="0" {{ request('parent') === '0' ? 'selected' : '' }}>Parent Categories</option>
                    @foreach($categories as $cat)
                        @if($cat->parent_id === null)
                            <option value="{{ $cat->id }}" {{ request('parent') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
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
                <i class="fas fa-folder"></i>
            </div>
            <div class="mobile-stat-number">{{ $categories->total() }}</div>
            <div class="mobile-stat-label">Total Categories</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="mobile-stat-number">{{ $categories->where('is_active', true)->count() }}</div>
            <div class="mobile-stat-label">Active</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-times-circle"></i>
            </div>
            <div class="mobile-stat-number">{{ $categories->where('is_active', false)->count() }}</div>
            <div class="mobile-stat-label">Inactive</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-star"></i>
            </div>
            <div class="mobile-stat-number">{{ $categories->where('is_featured', true)->count() }}/3</div>
            <div class="mobile-stat-label">Featured</div>
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
                            <div class="d-flex align-items-center">
                                @if($category->image_path)
                                    <img src="{{ asset('storage/' . $category->image_path) }}" 
                                         alt="{{ $category->name }}" 
                                         class="me-3" 
                                         style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <div class="me-3 d-flex align-items-center justify-content-center bg-light" 
                                         style="width: 48px; height: 48px; border-radius: 8px;">
                                        <i class="fas fa-folder text-muted"></i>
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mobile-card-title">{{ $category->name }}</h6>
                                    <div class="mobile-card-subtitle">
                                        <i class="fas fa-hashtag me-1"></i>ID: {{ $category->id }}
                                        @if($category->parent)
                                            <span class="ms-2">
                                                <i class="fas fa-level-up-alt me-1"></i>Parent: {{ $category->parent->name }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div>
                                @if($category->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-danger">Inactive</span>
                                @endif
                                @if($category->is_featured)
                                    <span class="badge bg-warning ms-1">
                                        <i class="fas fa-star me-1"></i>Featured
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="mobile-card-body">
                        @if($category->description)
                            <p class="text-muted small mb-3">
                                {{ Str::limit($category->description, 100) }}
                            </p>
                        @endif
                        
                        <div class="mobile-card-meta">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-link me-1"></i>
                                    {{ $category->slug }}
                                </small>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ $category->created_at->format('M d, Y') }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="mobile-card-meta">
                            <div>
                                <strong class="text-info">{{ $category->products_count }} Products</strong>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-code-branch me-1"></i>
                                    {{ $category->children_count ?? 0 }} Subcategories
                                </small>
                            </div>
                        </div>
                        
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
                                <button type="submit" 
                                        class="mobile-btn {{ $category->is_active ? 'mobile-btn-warning' : 'mobile-btn-success' }}" 
                                        title="{{ $category->is_active ? 'Deactivate' : 'Activate' }}">
                                    <i class="fas {{ $category->is_active ? 'fa-toggle-on' : 'fa-toggle-off' }}"></i>
                                    <span class="d-none d-sm-inline ms-1">{{ $category->is_active ? 'Deactivate' : 'Activate' }}</span>
                                </button>
                            </form>
                            
                            <form action="{{ route('admin.categories.destroy', $category) }}" 
                                  method="POST" 
                                  class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this category?')">
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
                    <i class="fas fa-folder-open"></i>
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
</div>
@endsection

<!-- Floating Action Button for Add Category -->
<a href="{{ route('admin.categories.create') }}" class="fab-add-category" title="Add Category">
    <i class="fas fa-plus"></i>
</a>

@push('styles')
<style>
.fab-add-category {
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
.fab-add-category:hover {
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
</style>
@endpush 
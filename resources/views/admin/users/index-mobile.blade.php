@extends('layouts.admin-mobile')

@section('title', 'Users Management')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h4 mb-0 text-white">Users Management</h1>
        <a href="{{ route('admin.users.create') }}" class="mobile-btn mobile-btn-primary">
            <i class="fas fa-plus me-1"></i>Add User
        </a>
    </div>

    <!-- Search and Filters Card -->
    <div class="mobile-search-card">
        <form method="GET" action="{{ route('admin.users.index') }}">
            <input type="text" 
                   class="mobile-search-input" 
                   name="search" 
                   placeholder="Search users by name, email, or phone..." 
                   value="{{ request('search') }}">
            
            <div class="mobile-filter-row">
                <select name="role" class="mobile-filter-select">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                </select>
                
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
                <i class="fas fa-users"></i>
            </div>
            <div class="mobile-stat-number">{{ $users->total() }}</div>
            <div class="mobile-stat-label">Total Users</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-user-shield"></i>
            </div>
            <div class="mobile-stat-number">{{ $users->where('is_admin', true)->count() }}</div>
            <div class="mobile-stat-label">Admins</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
            <div class="mobile-stat-number">{{ $users->where('email_verified_at', '!=', null)->count() }}</div>
            <div class="mobile-stat-label">Verified</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-calendar-plus"></i>
            </div>
            <div class="mobile-stat-number">{{ $users->where('created_at', '>=', now()->subDays(30))->count() }}</div>
            <div class="mobile-stat-label">New This Month</div>
        </div>
    </div>

    <!-- Users Container -->
    <div class="mobile-content-container">
        @if($users->count() > 0)
            @foreach($users as $user)
                <div class="mobile-card">
                    <div class="mobile-card-header">
                        <div class="d-flex justify-content-between align-items-start">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    @if($user->avatar)
                                        <img src="{{ asset('storage/' . $user->avatar) }}" 
                                             alt="{{ $user->name }}" 
                                             class="rounded-circle" 
                                             style="width: 40px; height: 40px; object-fit: cover;"
                                             onerror="this.src='{{ asset('template-assets/img/avatars/1.jpg') }}'">
                                    @else
                                        <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    @endif
                                </div>
                                <div>
                                    <h6 class="mobile-card-title mb-1">
                                        {{ $user->name }}
                                        @if($user->is_admin)
                                            <i class="fas fa-crown text-warning ms-1" title="Admin"></i>
                                        @endif
                                    </h6>
                                    <div class="mobile-card-subtitle">
                                        <i class="fas fa-envelope me-1"></i>{{ $user->email }}
                                        @if($user->phone)
                                            <span class="ms-2">
                                                <i class="fas fa-phone me-1"></i>{{ $user->phone }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="mb-1">
                                    @if($user->is_admin)
                                        <span class="badge bg-warning">Admin</span>
                                    @else
                                        <span class="badge bg-primary">User</span>
                                    @endif
                                </div>
                                <div>
                                    @if($user->email_verified_at)
                                        <span class="badge bg-success bg-opacity-75">Verified</span>
                                    @else
                                        <span class="badge bg-secondary bg-opacity-75">Unverified</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mobile-card-body">
                        <div class="mobile-card-meta">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-calendar me-1"></i>
                                    Joined {{ $user->created_at->format('M d, Y') }}
                                </small>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i>
                                    Last login {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="mobile-card-meta">
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-shopping-cart me-1"></i>
                                    {{ $user->orders->count() }} Orders
                                </small>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-wallet me-1"></i>
                                    ${{ number_format($user->wallet->balance ?? 0, 2) }} Balance
                                </small>
                            </div>
                        </div>
                        
                        @if($user->addresses->count() > 0)
                            <div class="mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>Addresses:
                                </small>
                                <div class="mt-1">
                                    @foreach($user->addresses->take(2) as $address)
                                        <span class="badge bg-secondary me-1">
                                            {{ $address->city }}, {{ $address->state }}
                                        </span>
                                    @endforeach
                                    @if($user->addresses->count() > 2)
                                        <span class="badge bg-secondary">+{{ $user->addresses->count() - 2 }} more</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        <div class="mobile-card-actions">
                            <a href="{{ route('admin.users.show', $user) }}" 
                               class="mobile-btn mobile-btn-info" 
                               title="View">
                                <i class="fas fa-eye"></i>
                                <span class="d-none d-sm-inline ms-1">View</span>
                            </a>
                            
                            <a href="{{ route('admin.users.edit', $user) }}" 
                               class="mobile-btn mobile-btn-warning" 
                               title="Edit">
                                <i class="fas fa-edit"></i>
                                <span class="d-none d-sm-inline ms-1">Edit</span>
                            </a>
                            
                            @if(!$user->is_admin)
                                <form action="{{ route('admin.users.toggle-admin', $user) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="mobile-btn mobile-btn-secondary" 
                                            title="Toggle Admin Status">
                                        <i class="fas fa-user-shield"></i>
                                        <span class="d-none d-sm-inline ms-1">Toggle Admin</span>
                                    </button>
                                </form>
                            @endif
                            
                            @if(!$user->email_verified_at)
                                <form action="{{ route('admin.users.verify-email', $user) }}" 
                                      method="POST" 
                                      class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                            class="mobile-btn mobile-btn-success" 
                                            title="Verify Email">
                                        <i class="fas fa-check"></i>
                                        <span class="d-none d-sm-inline ms-1">Verify</span>
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.users.destroy', $user) }}" 
                                  method="POST" 
                                  class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
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
            @if($users->hasPages())
                <div class="mobile-pagination">
                    @if($users->onFirstPage())
                        <span class="mobile-page-link disabled">Previous</span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="mobile-page-link">Previous</a>
                    @endif
                    
                    @foreach($users->getUrlRange(1, $users->lastPage()) as $page => $url)
                        @if($page == $users->currentPage())
                            <span class="mobile-page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="mobile-page-link">{{ $page }}</a>
                        @endif
                    @endforeach
                    
                    @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="mobile-page-link">Next</a>
                    @else
                        <span class="mobile-page-link disabled">Next</span>
                    @endif
                </div>
            @endif
        @else
            <div class="mobile-empty-state">
                <div class="mobile-empty-icon">
                    <i class="fas fa-users"></i>
                </div>
                <h5 class="text-muted">No users found</h5>
                <p class="text-muted">Users will appear here once they register.</p>
                <a href="{{ route('admin.users.create') }}" class="mobile-btn mobile-btn-primary">
                    <i class="fas fa-plus me-1"></i>Create User
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
    let currentPage = {{ $users->currentPage() }};
    let hasMorePages = {{ $users->hasMorePages() ? 'true' : 'false' }};
    
    function loadMoreUsers() {
        if (isLoading || !hasMorePages) return;
        
        isLoading = true;
        currentPage++;
        
        // Show loading indicator
        const loadingDiv = document.createElement('div');
        loadingDiv.className = 'mobile-loading';
        loadingDiv.innerHTML = `
            <div class="mobile-loading-spinner"></div>
            <div>Loading more users...</div>
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
                const newUsers = doc.querySelectorAll('.mobile-card');
                
                // Remove loading indicator
                loadingDiv.remove();
                
                // Add new users
                newUsers.forEach(user => {
                    container.appendChild(user.cloneNode(true));
                });
                
                // Update pagination state
                hasMorePages = newUsers.length > 0;
                isLoading = false;
            })
            .catch(error => {
                console.error('Error loading more users:', error);
                loadingDiv.remove();
                isLoading = false;
            });
    }
    
    // Intersection Observer for infinite scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !isLoading) {
                loadMoreUsers();
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
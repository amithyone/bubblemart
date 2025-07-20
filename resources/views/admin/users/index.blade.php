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
                   placeholder="Search users by name, email, phone..." 
                   value="{{ request('search') }}">
            
            <div class="mobile-filter-row">
                <select name="role" class="mobile-filter-select">
                    <option value="">All Roles</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admins</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Users</option>
                </select>
                
                <select name="status" class="mobile-filter-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Verified</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Unverified</option>
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
            <div class="mobile-stat-number">{{ $users->whereNotNull('email_verified_at')->count() }}</div>
            <div class="mobile-stat-label">Verified</div>
        </div>
        
        <div class="mobile-stat-card">
            <div class="mobile-stat-icon">
                <i class="fas fa-user-clock"></i>
            </div>
            <div class="mobile-stat-number">{{ $users->whereNull('email_verified_at')->count() }}</div>
            <div class="mobile-stat-label">Unverified</div>
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
                                @if($user->avatar)
                                    <img src="{{ asset('storage/' . $user->avatar) }}" 
                                         alt="{{ $user->name }}" 
                                         class="me-3" 
                                         style="width: 48px; height: 48px; object-fit: cover; border-radius: 50%;">
                                @else
                                    <div class="me-3 d-flex align-items-center justify-content-center bg-primary text-white" 
                                         style="width: 48px; height: 48px; border-radius: 50%; font-weight: 600;">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h6 class="mobile-card-title">{{ $user->name }}</h6>
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
                                @if($user->is_admin)
                                    <span class="badge bg-primary mb-1">Admin</span>
                                @else
                                    <span class="badge bg-secondary mb-1">User</span>
                                @endif
                                <br>
                                @if($user->email_verified_at)
                                    <span class="badge bg-success">Verified</span>
                                @else
                                    <span class="badge bg-warning">Unverified</span>
                                @endif
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
                                    {{ $user->created_at->format('H:i') }}
                                </small>
                            </div>
                        </div>
                        
                        <div class="mobile-card-meta">
                            <div>
                                <strong class="text-info">{{ $user->orders->count() }} Orders</strong>
                            </div>
                            <div>
                                <small class="text-muted">
                                    <i class="fas fa-wallet me-1"></i>
                                    ₦{{ number_format($user->wallet->balance ?? 0, 2) }}
                                </small>
                            </div>
                        </div>
                        
                        @if($user->orders->count() > 0)
                            <div class="mt-3">
                                <small class="text-muted">
                                    <i class="fas fa-shopping-cart me-1"></i>
                                    Total Spent: ₦{{ number_format($user->orders->sum('total'), 2) }}
                                </small>
                            </div>
                        @endif
                        
                        @if($user->addresses->count() > 0)
                            <div class="mt-2">
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>
                                    {{ $user->addresses->count() }} Address(es)
                                </small>
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
                            
                            @if($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" 
                                      method="POST" 
                                      class="d-inline" 
                                      onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="mobile-btn mobile-btn-danger" 
                                            title="Delete">
                                        <i class="fas fa-trash"></i>
                                        <span class="d-none d-sm-inline ms-1">Delete</span>
                                    </button>
                                </form>
                            @endif
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
                <p class="text-muted">Try adjusting your search criteria.</p>
            </div>
        @endif
    </div>
</div>
</div>
@endsection

<!-- Floating Action Button for Add User -->
<a href="{{ route('admin.users.create') }}" class="fab-add-user" title="Add User">
    <i class="fas fa-plus"></i>
</a>

@push('styles')
<style>
.fab-add-user {
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
.fab-add-user:hover {
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

.badge.bg-warning {
    background-color: var(--warning-color) !important;
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

.badge.bg-info {
    background-color: var(--info-color) !important;
    color: white;
}
</style>
@endpush 
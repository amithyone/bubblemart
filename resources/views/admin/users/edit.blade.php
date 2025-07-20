@extends('layouts.admin-mobile')

@section('title', 'Edit User')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-white">
                    <i class="fas fa-user-edit me-2"></i>Edit User
                </h1>
                <div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Users
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- User Information Card -->
            <div class="card adminuiux-card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-user me-2"></i>User Information
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', $user) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label text-white">Full Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label text-white">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
                                @error('email')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label text-white">Phone Number</label>
                                <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone', $user->phone) }}">
                                @error('phone')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="is_admin" class="form-label text-white">Admin Status</label>
                                <select class="form-select" id="is_admin" name="is_admin">
                                    <option value="0" {{ $user->is_admin ? '' : 'selected' }}>Regular User</option>
                                    <option value="1" {{ $user->is_admin ? 'selected' : '' }}>Admin User</option>
                                </select>
                                @error('is_admin')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label text-white">New Password (leave blank to keep current)</label>
                            <input type="password" class="form-control" id="password" name="password">
                            @error('password')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label text-white">Confirm New Password</label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- User Stats Card -->
            <div class="card adminuiux-card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-chart-bar me-2"></i>User Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="text-white h4">{{ $user->orders->count() }}</div>
                            <div class="text-muted small">Total Orders</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-white h4">₦{{ number_format($user->wallet->balance ?? 0, 2) }}</div>
                            <div class="text-muted small">Wallet Balance</div>
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="mb-2">
                        <small class="text-muted">Member Since:</small><br>
                        <span class="text-white">{{ $user->created_at->format('M j, Y') }}</span>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">Last Login:</small><br>
                        <span class="text-white">{{ $user->updated_at->format('M j, Y g:i A') }}</span>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">Status:</small><br>
                        <span class="badge {{ $user->is_admin ? 'bg-success' : 'bg-secondary' }}">
                            {{ $user->is_admin ? 'Admin' : 'User' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card adminuiux-card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.users.orders', $user) }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-shopping-bag me-1"></i>View Orders
                        </a>
                        <a href="{{ route('admin.users.wallet-transactions', $user) }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-wallet me-1"></i>Wallet Transactions
                        </a>
                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#addFundsModal">
                            <i class="fas fa-plus me-1"></i>Add Funds
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deductFundsModal">
                            <i class="fas fa-minus me-1"></i>Deduct Funds
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Funds Modal -->
<div class="modal fade" id="addFundsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content adminuiux-card">
            <div class="modal-header">
                <h5 class="modal-title text-white">Add Funds to Wallet</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.add-wallet-funds', $user) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="amount" class="form-label text-white">Amount (₦)</label>
                        <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label text-white">Description</label>
                        <input type="text" class="form-control" id="description" name="description" value="Admin credit" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success">Add Funds</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Deduct Funds Modal -->
<div class="modal fade" id="deductFundsModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content adminuiux-card">
            <div class="modal-header">
                <h5 class="modal-title text-white">Deduct Funds from Wallet</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.users.deduct-wallet-funds', $user) }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="deduct_amount" class="form-label text-white">Amount (₦)</label>
                        <input type="number" class="form-control" id="deduct_amount" name="amount" step="0.01" min="0" required>
                    </div>
                    <div class="mb-3">
                        <label for="deduct_description" class="form-label text-white">Description</label>
                        <input type="text" class="form-control" id="deduct_description" name="description" value="Admin debit" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Deduct Funds</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 
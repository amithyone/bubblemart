@extends('layouts.admin-mobile')

@section('title', 'Store Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-white">
                    <i class="fas fa-store me-2"></i>{{ $store->name }}
                </h1>
                <div>
                    <a href="{{ route('admin.stores.edit', $store) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit Store
                    </a>
                    <a href="{{ route('admin.stores.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Stores
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['total_products'] }}</h4>
                            <p class="mb-0">Total Products</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-box fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $stats['active_products'] }}</h4>
                            <p class="mb-0">Active Products</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">₦{{ number_format($stats['total_revenue'], 2) }}</h4>
                            <p class="mb-0">Total Revenue</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-money-bill-wave fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="mb-0">{{ $store->is_active ? 'Active' : 'Inactive' }}</h4>
                            <p class="mb-0">Status</p>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-toggle-{{ $store->is_active ? 'on' : 'off' }} fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Store Information -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Store Information</h5>
                </div>
                <div class="card-body">
                    @if($store->image_path)
                        <div class="text-center mb-3">
                            <img src="{{ asset('storage/' . $store->image_path) }}" 
                                 alt="Store Image" class="img-fluid rounded" style="max-height: 200px;">
                        </div>
                    @endif
                    
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td>{{ $store->name }}</td>
                        </tr>
                        <tr>
                            <td><strong>Address:</strong></td>
                            <td>{{ $store->address }}</td>
                        </tr>
                        @if($store->phone)
                        <tr>
                            <td><strong>Phone:</strong></td>
                            <td>{{ $store->phone }}</td>
                        </tr>
                        @endif
                        @if($store->email)
                        <tr>
                            <td><strong>Email:</strong></td>
                            <td>{{ $store->email }}</td>
                        </tr>
                        @endif
                        @if($store->website)
                        <tr>
                            <td><strong>Website:</strong></td>
                            <td><a href="{{ $store->website }}" target="_blank">{{ $store->website }}</a></td>
                        </tr>
                        @endif
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td>
                                <span class="badge bg-{{ $store->is_active ? 'success' : 'danger' }}">
                                    {{ $store->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Created:</strong></td>
                            <td>{{ $store->created_at->format('M d, Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td><strong>Updated:</strong></td>
                            <td>{{ $store->updated_at->format('M d, Y H:i') }}</td>
                        </tr>
                    </table>

                    @if($store->description)
                        <div class="mt-3">
                            <h6>Description:</h6>
                            <p class="text-muted">{{ $store->description }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Products -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Products</h5>
                    <a href="{{ route('admin.stores.products', $store) }}" class="btn btn-sm btn-primary">
                        View All
                    </a>
                </div>
                <div class="card-body">
                    @if($store->products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Category</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($store->products->take(5) as $product)
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                @if($product->image_path)
                                                    <img src="{{ asset('storage/' . $product->image_path) }}" 
                                                         alt="{{ $product->name }}" class="me-2" style="width: 30px; height: 30px; object-fit: cover;">
                                                @endif
                                                <div>
                                                    <strong>{{ $product->name }}</strong>
                                                    <br><small class="text-muted">{{ Str::limit($product->description, 30) }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $product->category->name ?? 'N/A' }}</td>
                                        <td>₦{{ number_format($product->price_naira, 2) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $product->is_active ? 'success' : 'danger' }}">
                                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">No products found for this store.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.stores.edit', $store) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-1"></i>Edit Store
                        </a>
                        <a href="{{ route('admin.stores.products', $store) }}" class="btn btn-info">
                            <i class="fas fa-box me-1"></i>Manage Products
                        </a>
                        <form action="{{ route('admin.stores.toggle-status', $store) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-{{ $store->is_active ? 'warning' : 'success' }}">
                                <i class="fas fa-toggle-{{ $store->is_active ? 'off' : 'on' }} me-1"></i>
                                {{ $store->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        @if($store->products->count() == 0)
                            <form action="{{ route('admin.stores.destroy', $store) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Are you sure you want to delete this store?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-1"></i>Delete Store
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
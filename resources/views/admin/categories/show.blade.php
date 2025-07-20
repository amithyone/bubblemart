@extends('layouts.admin-mobile')

@section('title', 'Category Details')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-white">
                    <i class="fas fa-tag me-2"></i>{{ $category->name }}
                </h1>
                <div>
                    <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit Category
                    </a>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Categories
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Category Details Card -->
            <div class="card adminuiux-card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-info-circle me-2"></i>Category Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-dark fw-bold">Name:</label>
                                <p class="text-dark">{{ $category->name }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-dark fw-bold">Slug:</label>
                                <p class="text-dark">{{ $category->slug }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-dark fw-bold">Status:</label>
                                <span class="badge {{ $category->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                    {{ ucfirst($category->status) }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label text-dark fw-bold">Created:</label>
                                <p class="text-dark">{{ $category->created_at->format('M j, Y g:i A') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-dark fw-bold">Last Updated:</label>
                                <p class="text-dark">{{ $category->updated_at->format('M j, Y g:i A') }}</p>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label text-dark fw-bold">Sort Order:</label>
                                <p class="text-dark">{{ $category->sort_order ?? 0 }}</p>
                            </div>
                        </div>
                    </div>
                    
                    @if($category->description)
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Description:</label>
                            <p class="text-dark">{{ $category->description }}</p>
                        </div>
                    @endif
                    
                    <!-- Variation Types Section -->
                    <div class="mb-3">
                        <label class="form-label text-dark fw-bold">
                            <i class="fas fa-cogs me-2"></i>Product Variation Types:
                        </label>
                        @if($category->variation_types && count($category->variation_types) > 0)
                            <div class="mt-2">
                                @foreach($category->variation_types as $type)
                                    <span class="badge bg-primary me-2 mb-2">
                                        <i class="fas fa-check me-1"></i>{{ ucfirst($type) }}
                                    </span>
                                @endforeach
                            </div>
                            <small class="text-muted">Products in this category can have these variation types.</small>
                        @else
                            <p class="text-muted">No variation types set for this category.</p>
                        @endif
                    </div>
                    
                    @if($category->image)
                        <div class="mb-3">
                            <label class="form-label text-dark fw-bold">Image:</label>
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-thumbnail" style="max-width: 300px;">
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Products in Category -->
            <div class="card adminuiux-card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-white">
                        <i class="fas fa-box me-2"></i>Products in this Category ({{ $category->products->count() }})
                    </h6>
                </div>
                <div class="card-body">
                    @if($category->products->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-dark table-hover">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($category->products->take(10) as $product)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="me-2" style="width: 40px; height: 40px; object-fit: cover;">
                                                    @endif
                                                    <div>
                                                        <div class="text-white">{{ $product->name }}</div>
                                                        <small class="text-muted">{{ Str::limit($product->description, 50) }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-white">₦{{ number_format($product->price, 2) }}</td>
                                            <td>
                                                <span class="badge {{ $product->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                                                    {{ ucfirst($product->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('admin.products.show', $product) }}" class="btn btn-sm btn-outline-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        @if($category->products->count() > 10)
                            <div class="text-center mt-3">
                                <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" class="btn btn-outline-primary">
                                    View All {{ $category->products->count() }} Products
                                </a>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-box-open fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No products in this category yet.</p>
                            <a href="{{ route('admin.products.create', ['category' => $category->id]) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Add Product
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Category Stats Card -->
            <div class="card adminuiux-card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-chart-bar me-2"></i>Category Statistics
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="text-dark h4">{{ $category->products->count() }}</div>
                            <div class="text-muted small">Total Products</div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="text-dark h4">{{ $category->products->where('status', 'active')->count() }}</div>
                            <div class="text-muted small">Active Products</div>
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="mb-2">
                        <small class="text-muted">Average Price:</small><br>
                        <span class="text-dark">₦{{ number_format($category->products->avg('price') ?? 0, 2) }}</span>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">Total Value:</small><br>
                        <span class="text-dark">₦{{ number_format($category->products->sum('price'), 2) }}</span>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">Status:</small><br>
                        <span class="badge {{ $category->status === 'active' ? 'bg-success' : 'bg-secondary' }}">
                            {{ ucfirst($category->status) }}
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
                        <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-edit me-1"></i>Edit Category
                        </a>
                        <a href="{{ route('admin.products.create', ['category' => $category->id]) }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-plus me-1"></i>Add Product
                        </a>
                        <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-box me-1"></i>View All Products
                        </a>
                        <button type="button" class="btn btn-outline-warning btn-sm" data-bs-toggle="modal" data-bs-target="#toggleStatusModal">
                            <i class="fas fa-toggle-on me-1"></i>Toggle Status
                        </button>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
                            <i class="fas fa-trash me-1"></i>Delete Category
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Toggle Status Modal -->
<div class="modal fade" id="toggleStatusModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content adminuiux-card">
            <div class="modal-header">
                <h5 class="modal-title text-white">Toggle Category Status</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p class="text-white">Are you sure you want to toggle the status of "{{ $category->name }}"?</p>
                    <p class="text-muted">Current status: <strong>{{ $category->status }}</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning">Toggle Status</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content adminuiux-card">
            <div class="modal-header">
                <h5 class="modal-title text-white">Delete Category</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p class="text-white">Are you sure you want to delete "{{ $category->name }}"?</p>
                    <p class="text-danger">This action cannot be undone!</p>
                    @if($category->products->count() > 0)
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-1"></i>
                            This category has {{ $category->products->count() }} products. Deleting it will affect those products.
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 
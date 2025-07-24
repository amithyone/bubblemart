@extends('layouts.admin-mobile')

@section('title', 'Product Variations - ' . $product->name)

@section('content')
<div class="container-fluid">
    <div class="mobile-card">
        <div class="mobile-card-header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="mobile-card-title">Product Variations</h2>
                    <p class="mobile-card-subtitle">{{ $product->name }}</p>
                </div>
                <a href="{{ route('admin.products.index') }}" class="mobile-btn mobile-btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Products
                </a>
            </div>
        </div>
        
        <div class="mobile-card-body">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Create New Variation -->
            <div class="card adminuiux-card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="bi bi-plus-circle me-2"></i>Add New Variation
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.products.variations.store', $product) }}" method="POST">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Variation Name</label>
                                <input type="text" name="name" class="form-control" placeholder="e.g., Color, Size, Material" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Type</label>
                                <select name="type" class="form-select" required>
                                    <option value="select">Dropdown</option>
                                    <option value="radio">Radio Buttons</option>
                                    <option value="checkbox">Checkboxes</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">&nbsp;</label>
                                <div class="form-check">
                                    <input type="checkbox" name="is_required" id="is_required" class="form-check-input" value="1">
                                    <label class="form-check-label" for="is_required">Required</label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-3">
                            <button type="submit" class="mobile-btn mobile-btn-primary">
                                <i class="fas fa-plus me-2"></i>Create Variation
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Existing Variations -->
            @forelse($product->variations as $variation)
                <div class="card adminuiux-card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">
                            <i class="bi bi-gear me-2"></i>{{ $variation->name }}
                            @if($variation->is_required)
                                <span class="badge bg-warning ms-2">Required</span>
                            @endif
                        </h5>
                        <span class="badge bg-secondary">{{ ucfirst($variation->type) }}</span>
                    </div>
                    
                    <div class="card-body">
                        <!-- Add New Option -->
                        <div class="mb-4">
                            <h6 class="fw-bold mb-3">Add New Option</h6>
                            <form action="{{ route('admin.variations.options.store', $variation) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-3">
                                        <label class="form-label">Value</label>
                                        <input type="text" name="value" class="form-control" placeholder="e.g., Red, Blue" required>
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label">Label (Optional)</label>
                                        <input type="text" name="label" class="form-control" placeholder="e.g., Classic Red">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Price Adjustment</label>
                                        <input type="number" name="price_adjustment" class="form-control" step="0.01" placeholder="0.00" required>
                                        <small class="text-muted">+ or - amount</small>
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">Stock</label>
                                        <input type="number" name="stock" class="form-control" min="0" placeholder="0">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label">SKU</label>
                                        <input type="text" name="sku" class="form-control" placeholder="SKU">
                                    </div>
                                </div>
                                <div class="row g-3 mt-2">
                                    <div class="col-md-6">
                                        <label class="form-label">Option Image</label>
                                        <input type="file" name="image" class="form-control" accept="image/*">
                                        <small class="text-muted">Upload image for this option (e.g., color swatch)</small>
                                    </div>
                                    <div class="col-md-6 d-flex align-items-end">
                                        <button type="submit" class="mobile-btn mobile-btn-primary">
                                            <i class="fas fa-plus me-2"></i>Add Option
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Existing Options -->
                        @if($variation->options->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Value</th>
                                            <th>Label</th>
                                            <th>Price Adjustment</th>
                                            <th>Stock</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($variation->options as $option)
                                            <tr>
                                                <td>
                                                    @if($option->image)
                                                        <img src="{{ asset('storage/' . $option->image) }}" 
                                                             alt="{{ $option->value }}" 
                                                             class="img-thumbnail" 
                                                             style="width: 50px; height: 50px; object-fit: cover;">
                                                    @else
                                                        <div class="bg-light d-flex align-items-center justify-content-center" 
                                                             style="width: 50px; height: 50px;">
                                                            <i class="bi bi-image text-muted"></i>
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <strong>{{ $option->value }}</strong>
                                                    @if($option->sku)
                                                        <br><small class="text-muted">{{ $option->sku }}</small>
                                                    @endif
                                                </td>
                                                <td>{{ $option->label ?: '-' }}</td>
                                                <td>
                                                    <span class="badge {{ $option->price_adjustment >= 0 ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $option->price_adjustment >= 0 ? '+' : '' }}{{ number_format($option->price_adjustment, 2) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    @if($option->stock !== null)
                                                        <span class="badge {{ $option->stock > 0 ? 'bg-success' : 'bg-danger' }}">
                                                            {{ $option->stock }}
                                                        </span>
                                                    @else
                                                        <span class="badge bg-secondary">Unlimited</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span class="badge {{ $option->is_active ? 'bg-success' : 'bg-danger' }}">
                                                        {{ $option->is_active ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <button type="button" class="btn btn-outline-primary" 
                                                                onclick="editOption({{ $option->id }}, '{{ $option->value }}', '{{ $option->label }}', {{ $option->price_adjustment }}, {{ $option->stock ?? 'null' }}, '{{ $option->sku }}')">
                                                            <i class="bi bi-pencil"></i>
                                                        </button>
                                                        <a href="{{ route('admin.variations.options.toggle-status', $option) }}" 
                                                           class="btn btn-outline-warning">
                                                            <i class="bi bi-toggle-{{ $option->is_active ? 'on' : 'off' }}"></i>
                                                        </a>
                                                        <form action="{{ route('admin.variations.options.destroy', $option) }}" 
                                                              method="POST" 
                                                              onsubmit="return confirm('Are you sure you want to delete this option?')" 
                                                              style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-outline-danger">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="bi bi-inbox display-4 text-muted"></i>
                                <p class="text-muted mt-2">No options added yet. Add your first option above.</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="bi bi-gear display-4 text-muted"></i>
                    <h5 class="text-muted mt-3">No Variations Yet</h5>
                    <p class="text-muted">Create your first variation (like Color, Size, etc.) to get started.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Edit Option Modal -->
<div class="modal fade" id="editOptionModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Option</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editOptionForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Value</label>
                            <input type="text" name="value" id="edit_value" class="form-control" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Label (Optional)</label>
                            <input type="text" name="label" id="edit_label" class="form-control">
                        </div>
                        <div class="col-6">
                            <label class="form-label">Price Adjustment</label>
                            <input type="number" name="price_adjustment" id="edit_price_adjustment" class="form-control" step="0.01" required>
                        </div>
                        <div class="col-6">
                            <label class="form-label">Stock</label>
                            <input type="number" name="stock" id="edit_stock" class="form-control" min="0">
                        </div>
                        <div class="col-12">
                            <label class="form-label">SKU</label>
                            <input type="text" name="sku" id="edit_sku" class="form-control">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Option Image</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Leave empty to keep current image</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Update Option</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function editOption(id, value, label, priceAdjustment, stock, sku) {
    document.getElementById('edit_value').value = value;
    document.getElementById('edit_label').value = label || '';
    document.getElementById('edit_price_adjustment').value = priceAdjustment;
    document.getElementById('edit_stock').value = stock !== null ? stock : '';
    document.getElementById('edit_sku').value = sku || '';
    
    document.getElementById('editOptionForm').action = `/admin/variations/options/${id}`;
    
    new bootstrap.Modal(document.getElementById('editOptionModal')).show();
}
</script>
@endpush

@endsection 
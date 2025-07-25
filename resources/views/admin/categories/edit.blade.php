@extends('layouts.admin-mobile')

@section('title', 'Edit Category')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-dark">
                    <i class="fas fa-edit me-2"></i>Edit Category
                </h1>
                <div>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Categories
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <!-- Category Information Card -->
            <div class="card adminuiux-card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-tag me-2"></i>Category Information
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label text-dark">Category Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}" required>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="slug" class="form-label text-dark">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" readonly>
                                <small class="text-muted">Auto-generated from name</small>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label text-dark">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                            @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="icon" class="form-label text-dark">
                                <i class="fas fa-icons me-2"></i>Category Icon
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="icon" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="🎁 or emoji">
                                    <small class="text-muted">Enter an emoji or icon (e.g., 🎁, 🏠, 🎨, 📱)</small>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <span class="display-4 me-3" id="icon-preview">{{ $category->icon ?? '🎁' }}</span>
                                        <div>
                                            <small class="text-muted d-block">Preview</small>
                                            <small class="text-muted">This icon will be displayed on category cards</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @error('icon')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Gender Variation Section -->
                        <div class="mb-4">
                            <label class="form-label text-dark">
                                <i class="fas fa-venus-mars me-2"></i>Gender Variation
                            </label>
                            <div class="card adminuiux-card border-0" style="border-radius: 15px;">
                                <div class="card-body">
                                    <p class="text-muted small mb-3">Select the gender variation for this category:</p>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="all" id="gender_all" 
                                                       {{ old('gender', $category->gender ?? 'all') === 'all' ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="gender_all">
                                                    <i class="fas fa-users me-2 text-primary"></i>All Genders
                                                </label>
                                                <small class="text-muted d-block">Suitable for all genders (default)</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="male" id="gender_male" 
                                                       {{ old('gender', $category->gender) === 'male' ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="gender_male">
                                                    <i class="fas fa-mars me-2 text-primary"></i>Men's Only
                                                </label>
                                                <small class="text-muted d-block">Specifically for men</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="female" id="gender_female" 
                                                       {{ old('gender', $category->gender) === 'female' ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="gender_female">
                                                    <i class="fas fa-venus me-2 text-primary"></i>Women's Only
                                                </label>
                                                <small class="text-muted d-block">Specifically for women</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="unisex" id="gender_unisex" 
                                                       {{ old('gender', $category->gender) === 'unisex' ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="gender_unisex">
                                                    <i class="fas fa-user-friends me-2 text-primary"></i>Unisex
                                                </label>
                                                <small class="text-muted d-block">Suitable for everyone</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Note:</strong> This will enable gender-based filtering for users browsing this category.
                                    </div>
                                </div>
                            </div>
                            @error('gender')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Variation Types Section -->
                        <div class="mb-4">
                            <label class="form-label text-dark">
                                <i class="fas fa-cogs me-2"></i>Product Variation Types
                            </label>
                            <div class="card adminuiux-card border-0" style="border-radius: 15px;">
                                <div class="card-body">
                                    <p class="text-muted small mb-3">Select which variation types are allowed for products in this category:</p>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="variation_types[]" value="size" id="variation_size" 
                                                       {{ in_array('size', old('variation_types', $category->variation_types ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="variation_size">
                                                    <i class="fas fa-ruler me-2 text-primary"></i>Size
                                                </label>
                                                <small class="text-muted d-block">XS, S, M, L, XL, XXL, etc.</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="variation_types[]" value="color" id="variation_color" 
                                                       {{ in_array('color', old('variation_types', $category->variation_types ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="variation_color">
                                                    <i class="fas fa-palette me-2 text-primary"></i>Color
                                                </label>
                                                <small class="text-muted d-block">Red, Blue, Green, Black, White, etc.</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="variation_types[]" value="material" id="variation_material" 
                                                       {{ in_array('material', old('variation_types', $category->variation_types ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="variation_material">
                                                    <i class="fas fa-fabric me-2 text-primary"></i>Material
                                                </label>
                                                <small class="text-muted d-block">Cotton, Polyester, Leather, etc.</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="variation_types[]" value="style" id="variation_style" 
                                                       {{ in_array('style', old('variation_types', $category->variation_types ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="variation_style">
                                                    <i class="fas fa-star me-2 text-primary"></i>Style
                                                </label>
                                                <small class="text-muted d-block">Casual, Formal, Sport, Vintage, etc.</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="variation_types[]" value="fit" id="variation_fit" 
                                                       {{ in_array('fit', old('variation_types', $category->variation_types ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="variation_fit">
                                                    <i class="fas fa-user me-2 text-primary"></i>Fit
                                                </label>
                                                <small class="text-muted d-block">Slim, Regular, Loose, Oversized, etc.</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="variation_types[]" value="pattern" id="variation_pattern" 
                                                       {{ in_array('pattern', old('variation_types', $category->variation_types ?? [])) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="variation_pattern">
                                                    <i class="fas fa-paint-brush me-2 text-primary"></i>Pattern
                                                </label>
                                                <small class="text-muted d-block">Solid, Striped, Floral, Geometric, etc.</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Note:</strong> When creating products in this category, only the selected variation types will be available.
                                    </div>
                                </div>
                            </div>
                            @error('variation_types')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="sort_order" class="form-label text-dark">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', $category->sort_order ?? 0) }}" min="0">
                                @error('sort_order')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Status Section -->
                        <div class="mb-4">
                            <label class="form-label text-dark">
                                <i class="fas fa-cog me-2"></i>Category Status
                            </label>
                            <div class="card adminuiux-card border-0" style="border-radius: 15px;">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $category->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="is_active">
                                                    <i class="fas fa-check-circle me-2 text-success"></i>Active
                                                </label>
                                                <small class="text-muted d-block">Make this category visible to customers</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured', $category->is_featured) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="is_featured">
                                                    <i class="fas fa-star me-2 text-warning"></i>Featured
                                                </label>
                                                <small class="text-muted d-block">Show this category prominently on homepage</small>
                                                <small class="text-info d-block">
                                                    <i class="fas fa-info-circle me-1"></i>Maximum 3 categories can be featured
                                                </small>
                                            </div>
                                            @error('is_featured')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        
                                        <div class="col-md-4 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="is_customizable" id="is_customizable" value="1" {{ old('is_customizable', $category->is_customizable) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="is_customizable">
                                                    <i class="fas fa-magic me-2 text-primary"></i>Customizable
                                                </label>
                                                <small class="text-muted d-block">Allow customers to customize products in this category</small>
                                                <small class="text-info d-block">
                                                    <i class="fas fa-info-circle me-1"></i>Shows on customize page
                                                </small>
                                            </div>
                                            @error('is_customizable')
                                                <div class="text-danger small mt-1">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label text-dark">Category Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            @if($category->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="img-thumbnail" style="max-width: 200px;">
                                    <small class="text-muted d-block">Current image</small>
                                </div>
                            @endif
                            @error('image')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Category
                            </button>
                        </div>
                    </form>
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
                            <div class="text-dark h4">{{ $category->status }}</div>
                            <div class="text-muted small">Status</div>
                        </div>
                    </div>
                    
                    <hr class="my-3">
                    
                    <!-- Current Variation Types -->
                    <div class="mb-3">
                        <small class="text-muted">Current Variation Types:</small><br>
                        @if($category->variation_types && count($category->variation_types) > 0)
                            <div class="mt-2">
                                @foreach($category->variation_types as $type)
                                    <span class="badge bg-primary me-1 mb-1">{{ ucfirst($type) }}</span>
                                @endforeach
                            </div>
                        @else
                            <span class="text-muted small">No variation types set</span>
                        @endif
                    </div>
                    
                    <hr class="my-3">
                    
                    <div class="mb-2">
                        <small class="text-muted">Created:</small><br>
                        <span class="text-dark">{{ $category->created_at->format('M j, Y') }}</span>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">Last Updated:</small><br>
                        <span class="text-dark">{{ $category->updated_at->format('M j, Y g:i A') }}</span>
                    </div>
                    
                    <div class="mb-2">
                        <small class="text-muted">Slug:</small><br>
                        <span class="text-dark">{{ $category->slug }}</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="card adminuiux-card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-bolt me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.categories.show', $category) }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-eye me-1"></i>View Category
                        </a>
                        <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-box me-1"></i>View Products
                        </a>
                        <button type="button" class="btn btn-outline-success btn-sm" data-bs-toggle="modal" data-bs-target="#toggleStatusModal">
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
                <h5 class="modal-title text-dark">Toggle Category Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.categories.toggle-status', $category) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <p class="text-dark">Are you sure you want to toggle the status of "{{ $category->name }}"?</p>
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
                <h5 class="modal-title text-dark">Delete Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p class="text-dark">Are you sure you want to delete "{{ $category->name }}"?</p>
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

<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
        .replace(/[^a-z0-9 -]/g, '')
        .replace(/\s+/g, '-')
        .replace(/-+/g, '-')
        .trim('-');
    document.getElementById('slug').value = slug;
});
</script>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const iconInput = document.getElementById('icon');
    const iconPreview = document.getElementById('icon-preview');
    
    if (iconInput && iconPreview) {
        iconInput.addEventListener('input', function() {
            iconPreview.textContent = this.value || '🎁';
        });
    }
});
</script>
@endpush 
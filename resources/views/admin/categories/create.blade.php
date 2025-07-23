@extends('layouts.admin-mobile')

@section('title', 'Create Category')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="h3 mb-0 text-dark">
                    <i class="fas fa-plus me-2"></i>Create New Category
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
                    <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label text-dark">Category Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="slug" class="form-label text-dark">Slug</label>
                                <input type="text" class="form-control" id="slug" name="slug" value="{{ old('slug') }}" readonly>
                                <small class="text-muted">Auto-generated from name</small>
                                @error('slug')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label text-dark">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
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
                                                       {{ old('gender', 'all') === 'all' ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="gender_all">
                                                    <i class="fas fa-users me-2 text-primary"></i>All Genders
                                                </label>
                                                <small class="text-muted d-block">Suitable for all genders (default)</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="male" id="gender_male" 
                                                       {{ old('gender') === 'male' ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="gender_male">
                                                    <i class="fas fa-mars me-2 text-primary"></i>Men's Only
                                                </label>
                                                <small class="text-muted d-block">Specifically for men</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="female" id="gender_female" 
                                                       {{ old('gender') === 'female' ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="gender_female">
                                                    <i class="fas fa-venus me-2 text-primary"></i>Women's Only
                                                </label>
                                                <small class="text-muted d-block">Specifically for women</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="gender" value="unisex" id="gender_unisex" 
                                                       {{ old('gender') === 'unisex' ? 'checked' : '' }}>
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

                        <!-- Gender-Based Subcategories Section -->
                        <div class="mb-4">
                            <label class="form-label text-dark">
                                <i class="fas fa-sitemap me-2"></i>Gender-Based Subcategories
                            </label>
                            <div class="card adminuiux-card border-0" style="border-radius: 15px;">
                                <div class="card-body">
                                    <p class="text-muted small mb-3">Automatically create subcategories for male and female items:</p>
                                    
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="create_gender_subcategories" id="create_gender_subcategories" value="1" 
                                                       {{ old('create_gender_subcategories') ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="create_gender_subcategories">
                                                    <i class="fas fa-users me-2 text-primary"></i>Create Gender Subcategories
                                                </label>
                                                <small class="text-muted d-block">Automatically creates "Men's" and "Women's" subcategories</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="include_unisex" id="include_unisex" value="1" 
                                                       {{ old('include_unisex') ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="include_unisex">
                                                    <i class="fas fa-user-friends me-2 text-primary"></i>Include Unisex
                                                </label>
                                                <small class="text-muted d-block">Also create "Unisex" subcategory</small>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="alert alert-info mt-3">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>Note:</strong> When enabled, this will automatically create subcategories for better product organization.
                                    </div>
                                </div>
                            </div>
                            @error('create_gender_subcategories')
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
                                                       {{ in_array('size', old('variation_types', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="variation_size">
                                                    <i class="fas fa-ruler me-2 text-primary"></i>Size
                                                </label>
                                                <small class="text-muted d-block">XS, S, M, L, XL, XXL, etc.</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="variation_types[]" value="color" id="variation_color" 
                                                       {{ in_array('color', old('variation_types', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="variation_color">
                                                    <i class="fas fa-palette me-2 text-primary"></i>Color
                                                </label>
                                                <small class="text-muted d-block">Red, Blue, Green, Black, White, etc.</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="variation_types[]" value="material" id="variation_material" 
                                                       {{ in_array('material', old('variation_types', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="variation_material">
                                                    <i class="fas fa-fabric me-2 text-primary"></i>Material
                                                </label>
                                                <small class="text-muted d-block">Cotton, Polyester, Leather, etc.</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="variation_types[]" value="style" id="variation_style" 
                                                       {{ in_array('style', old('variation_types', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="variation_style">
                                                    <i class="fas fa-star me-2 text-primary"></i>Style
                                                </label>
                                                <small class="text-muted d-block">Casual, Formal, Sport, Vintage, etc.</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="variation_types[]" value="fit" id="variation_fit" 
                                                       {{ in_array('fit', old('variation_types', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="variation_fit">
                                                    <i class="fas fa-user me-2 text-primary"></i>Fit
                                                </label>
                                                <small class="text-muted d-block">Slim, Regular, Loose, Oversized, etc.</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="variation_types[]" value="pattern" id="variation_pattern" 
                                                       {{ in_array('pattern', old('variation_types', [])) ? 'checked' : '' }}>
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
                                <label for="status" class="form-label text-dark">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                </select>
                                @error('status')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="sort_order" class="form-label text-dark">Sort Order</label>
                                <input type="number" class="form-control" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0">
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
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label text-dark" for="is_active">
                                                    <i class="fas fa-check-circle me-2 text-success"></i>Active
                                                </label>
                                                <small class="text-muted d-block">Make this category visible to customers</small>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6 mb-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="is_featured" id="is_featured" value="1" {{ old('is_featured') ? 'checked' : '' }}>
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
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="image" class="form-label text-dark">Category Image</label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <small class="text-muted">Optional: Upload an image for this category</small>
                            @error('image')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <!-- Help Card -->
            <div class="card adminuiux-card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-dark">
                        <i class="fas fa-question-circle me-2"></i>Creating Categories
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6 class="text-dark">Tips for creating categories:</h6>
                        <ul class="text-muted small">
                            <li>Use descriptive names that customers will understand</li>
                            <li>Keep names short but informative</li>
                            <li>Consider the customer journey when organizing</li>
                            <li>Use consistent naming conventions</li>
                        </ul>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-dark">Category Status:</h6>
                        <ul class="text-muted small">
                            <li><strong>Active:</strong> Visible to customers</li>
                            <li><strong>Inactive:</strong> Hidden from customers</li>
                            <li><strong>Featured:</strong> Shown prominently on homepage (max 3)</li>
                        </ul>
                    </div>
                    
                    <div class="mb-3">
                        <h6 class="text-dark">Sort Order:</h6>
                        <p class="text-muted small">Lower numbers appear first. Use increments of 10 (10, 20, 30) for easy reordering.</p>
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
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-info btn-sm">
                            <i class="fas fa-list me-1"></i>View All Categories
                        </a>
                        <a href="{{ route('admin.products.create') }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-plus me-1"></i>Create Product
                        </a>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-box me-1"></i>Manage Products
                        </a>
                    </div>
                </div>
            </div>
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

// Handle gender subcategories checkbox
document.getElementById('create_gender_subcategories').addEventListener('change', function() {
    const unisexCheckbox = document.getElementById('include_unisex');
    const unisexContainer = unisexCheckbox.closest('.col-md-6');
    
    if (this.checked) {
        unisexContainer.style.display = 'block';
    } else {
        unisexContainer.style.display = 'none';
        unisexCheckbox.checked = false;
    }
});

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    const genderCheckbox = document.getElementById('create_gender_subcategories');
    const unisexCheckbox = document.getElementById('include_unisex');
    const unisexContainer = unisexCheckbox.closest('.col-md-6');
    
    if (!genderCheckbox.checked) {
        unisexContainer.style.display = 'none';
    }
});
</script>
@endsection 
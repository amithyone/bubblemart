@extends('layouts.admin-mobile')

@section('title', 'Add New Product')

@section('content')
<div class="container-fluid">
    <div class="mobile-card">
        <div class="mobile-card-header">
            <h2 class="mobile-card-title">Create New Product</h2>
            <p class="mobile-card-subtitle">Add a new product to your store</p>
        </div>
        <div class="mobile-card-body">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="mobile-form-group">
                    <label for="name">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="mobile-input" value="{{ old('name') }}" required placeholder="Enter product name">
                </div>
                
                <div class="mobile-form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="mobile-input" rows="4" placeholder="Enter product description">{{ old('description') }}</textarea>
                </div>
                
                <div class="mobile-form-group">
                    <label for="category_id">Category <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="mobile-input" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @if($category->children->count() > 0)
                                @foreach($category->children as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ old('category_id') == $subcategory->id ? 'selected' : '' }}>
                                        &nbsp;&nbsp;&nbsp;&nbsp;└ {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            @endif
                        @endforeach
                    </select>
                </div>
                
                <div class="mobile-form-group">
                    <label for="store_id">Store <span class="text-danger">*</span></label>
                    <select name="store_id" id="store_id" class="mobile-input" required>
                        <option value="">Select a store</option>
                        @foreach($stores as $store)
                            <option value="{{ $store->id }}" {{ old('store_id') == $store->id ? 'selected' : '' }}>
                                {{ $store->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mobile-form-group">
                    <label for="price">Price ($) <span class="text-danger">*</span></label>
                    <input type="number" name="price" id="price" class="mobile-input" value="{{ old('price') }}" step="0.01" min="0" required placeholder="0.00">
                </div>
                
                <div class="mobile-form-group">
                    <label for="sale_price">Sale Price ($)</label>
                    <input type="number" name="sale_price" id="sale_price" class="mobile-input" value="{{ old('sale_price') }}" step="0.01" min="0" placeholder="0.00">
                    <small class="text-muted">Leave empty if no sale price</small>
                </div>
                
                <div class="mobile-form-group">
                    <label for="stock">Stock Quantity</label>
                    <input type="number" name="stock" id="stock" class="mobile-input" value="{{ old('stock') }}" min="0" placeholder="0">
                    <small class="text-muted">Leave empty for unlimited stock</small>
                </div>
                
                <div class="mobile-form-group">
                    <label for="image">Main Product Image</label>
                    <input type="file" name="image" id="image" class="mobile-input" accept="image/*">
                    <small class="text-muted">Upload a high-quality main image for your product</small>
                </div>
                
                <div class="mobile-form-group">
                    <label for="gallery">Product Gallery Images</label>
                    <input type="file" name="gallery[]" id="gallery" class="mobile-input" accept="image/*" multiple>
                    <small class="text-muted">Upload additional images for the product gallery (you can select multiple files)</small>
                </div>
                
                <div class="mobile-form-group mobile-checkbox-group">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" class="mobile-checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="mobile-checkbox-label" for="is_active">Make this product active</label>
                </div>
                
                <div class="mobile-form-group mobile-checkbox-group">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" id="is_featured" class="mobile-checkbox" value="1" {{ old('is_featured') ? 'checked' : '' }}>
                    <label class="mobile-checkbox-label" for="is_featured">Feature this product</label>
                </div>
                
                <div class="mobile-form-group mobile-checkbox-group">
                    <input type="hidden" name="allow_customization" value="0">
                    <input type="checkbox" name="allow_customization" id="allow_customization" class="mobile-checkbox" value="1" {{ old('allow_customization') ? 'checked' : '' }}>
                    <label class="mobile-checkbox-label" for="allow_customization">Allow customization</label>
                </div>
                
                <div class="mobile-form-group">
                    <label for="scope">Product Scope <span class="text-danger">*</span></label>
                    <select name="scope" id="scope" class="mobile-input" required>
                        <option value="international" {{ old('scope', 'international') == 'international' ? 'selected' : '' }}>International (Worldwide)</option>
                        <option value="us_only" {{ old('scope') == 'us_only' ? 'selected' : '' }}>US Only</option>
                    </select>
                    <small class="text-muted">US Only products can only be shipped to US addresses</small>
                </div>
                
                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="mobile-btn mobile-btn-primary flex-fill">
                        <i class="fas fa-plus me-2"></i>Create Product
                    </button>
                    <a href="{{ route('admin.products.index') }}" class="mobile-btn mobile-btn-secondary flex-fill">
                        <i class="fas fa-times me-2"></i>Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Preview selected images
    const galleryInput = document.getElementById('gallery');
    const imageInput = document.getElementById('image');
    
    // Create preview container
    const previewContainer = document.createElement('div');
    previewContainer.className = 'image-preview-container mt-3';
    galleryInput.parentNode.appendChild(previewContainer);
    
    function createImagePreview(file, container) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.createElement('div');
            preview.className = 'image-preview-item d-inline-block me-2 mb-2';
            preview.style.cssText = 'width: 100px; height: 100px; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; position: relative;';
            
            const img = document.createElement('img');
            img.src = e.target.result;
            img.style.cssText = 'width: 100%; height: 100%; object-fit: cover;';
            
            preview.appendChild(img);
            container.appendChild(preview);
        };
        reader.readAsDataURL(file);
    }
    
    // Handle main image preview
    if (imageInput) {
        imageInput.addEventListener('change', function() {
            const file = this.files[0];
            if (file) {
                const container = document.createElement('div');
                container.className = 'main-image-preview mt-2';
                container.innerHTML = '<small class="text-muted d-block mb-2">Main Image Preview:</small>';
                
                // Remove existing preview
                const existingPreview = this.parentNode.querySelector('.main-image-preview');
                if (existingPreview) {
                    existingPreview.remove();
                }
                
                this.parentNode.appendChild(container);
                createImagePreview(file, container);
            }
        });
    }
    
    // Handle gallery images preview
    if (galleryInput) {
        galleryInput.addEventListener('change', function() {
            const files = Array.from(this.files);
            
            // Clear existing previews
            previewContainer.innerHTML = '';
            
            if (files.length > 0) {
                const title = document.createElement('small');
                title.className = 'text-muted d-block mb-2';
                title.textContent = `Gallery Images Preview (${files.length} images):`;
                previewContainer.appendChild(title);
                
                files.forEach(file => {
                    createImagePreview(file, previewContainer);
                });
            }
        });
    }
});
</script>
@endpush

@endsection

 
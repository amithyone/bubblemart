@extends('layouts.admin-mobile')

@section('title', 'Edit Product')

@section('content')
<div class="container-fluid">
    <div class="mobile-card">
        <div class="mobile-card-header">
            <h2 class="mobile-card-title">Edit Product</h2>
            <p class="mobile-card-subtitle">Update product information</p>
        </div>
        <div class="mobile-card-body">
            <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="mobile-form-group">
                    <label for="name">Product Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="name" class="mobile-input" value="{{ old('name', $product->name) }}" required placeholder="Enter product name">
                </div>
                
                <div class="mobile-form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" class="mobile-input" rows="4" placeholder="Enter product description">{{ old('description', $product->description) }}</textarea>
                </div>
                
                <div class="mobile-form-group">
                    <label for="category_id">Category <span class="text-danger">*</span></label>
                    <select name="category_id" id="category_id" class="mobile-input" required>
                        <option value="">Select a category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @if($category->children->count() > 0)
                                @foreach($category->children as $subcategory)
                                    <option value="{{ $subcategory->id }}" {{ old('category_id', $product->category_id) == $subcategory->id ? 'selected' : '' }}>
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
                            <option value="{{ $store->id }}" {{ old('store_id', $product->store_id) == $store->id ? 'selected' : '' }}>
                                {{ $store->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mobile-form-group">
                    <label for="price">Price ($) <span class="text-danger">*</span></label>
                    <input type="number" name="price" id="price" class="mobile-input" value="{{ old('price', $product->price) }}" step="0.01" min="0" required placeholder="0.00">
                </div>
                
                <div class="mobile-form-group">
                    <label for="sale_price">Sale Price ($)</label>
                    <input type="number" name="sale_price" id="sale_price" class="mobile-input" value="{{ old('sale_price', $product->sale_price) }}" step="0.01" min="0" placeholder="0.00">
                    <small class="text-muted">Leave empty if no sale price</small>
                </div>
                
                <div class="mobile-form-group">
                    <label for="stock">Stock Quantity</label>
                    <input type="number" name="stock" id="stock" class="mobile-input" value="{{ old('stock', $product->stock) }}" min="0" placeholder="0">
                    <small class="text-muted">Leave empty for unlimited stock</small>
                </div>
                
                <div class="mobile-form-group">
                    <label for="image">Main Product Image</label>
                    <input type="file" name="image" id="image" class="mobile-input" accept="image/*">
                    <small class="text-muted">Upload a new main image to replace the current one</small>
                    @if($product->image)
                        <div class="mt-2">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
                            <small class="text-muted d-block">Current main image</small>
                        </div>
                    @endif
                </div>
                
                <div class="mobile-form-group">
                    <label for="gallery">Add Gallery Images</label>
                    <input type="file" name="gallery[]" id="gallery" class="mobile-input" accept="image/*" multiple>
                    <small class="text-muted">Upload additional images for the product gallery (you can select multiple files)</small>
                    
                    @if($product->gallery && count($product->gallery) > 0)
                        <div class="mt-3">
                            <small class="text-muted d-block mb-2">Current Gallery Images:</small>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($product->gallery as $index => $galleryImage)
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $galleryImage) }}" alt="Gallery Image {{ $index + 1 }}" 
                                             class="img-thumbnail" style="width: 80px; height: 80px; object-fit: cover;">
                                        <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" 
                                                style="width: 20px; height: 20px; padding: 0; font-size: 10px;"
                                                onclick="removeGalleryImage({{ $index }})">
                                            ×
                                        </button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                
                <div class="mobile-form-group mobile-checkbox-group">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" class="mobile-checkbox" value="1" {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
                    <label class="mobile-checkbox-label" for="is_active">Make this product active</label>
                </div>
                
                <div class="mobile-form-group mobile-checkbox-group">
                    <input type="hidden" name="is_featured" value="0">
                    <input type="checkbox" name="is_featured" id="is_featured" class="mobile-checkbox" value="1" {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                    <label class="mobile-checkbox-label" for="is_featured">Feature this product</label>
                </div>
                
                <div class="mobile-form-group mobile-checkbox-group">
                    <input type="hidden" name="allow_customization" value="0">
                    <input type="checkbox" name="allow_customization" id="allow_customization" class="mobile-checkbox" value="1" {{ old('allow_customization', $product->allow_customization) ? 'checked' : '' }}>
                    <label class="mobile-checkbox-label" for="allow_customization">Allow customization</label>
                </div>
                
                <div class="mobile-form-group">
                    <label for="scope">Product Scope <span class="text-danger">*</span></label>
                    <select name="scope" id="scope" class="mobile-input" required>
                        <option value="international" {{ old('scope', $product->scope ?? 'international') == 'international' ? 'selected' : '' }}>International (Worldwide)</option>
                        <option value="us_only" {{ old('scope', $product->scope ?? 'international') == 'us_only' ? 'selected' : '' }}>US Only</option>
                    </select>
                    <small class="text-muted">US Only products can only be shipped to US addresses</small>
                </div>
                
                <div class="d-flex gap-3 mt-4">
                    <button type="submit" class="mobile-btn mobile-btn-primary flex-fill">
                        <i class="fas fa-save me-2"></i>Update Product
                    </button>
                    <a href="{{ route('admin.products.variations.index', $product) }}" class="mobile-btn mobile-btn-info flex-fill">
                        <i class="fas fa-gear me-2"></i>Manage Variations
                    </a>
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
                container.innerHTML = '<small class="text-muted d-block mb-2">New Main Image Preview:</small>';
                
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
                title.textContent = `New Gallery Images Preview (${files.length} images):`;
                previewContainer.appendChild(title);
                
                files.forEach(file => {
                    createImagePreview(file, previewContainer);
                });
            }
        });
    }
});

// Function to remove gallery images
function removeGalleryImage(index) {
    if (confirm('Are you sure you want to remove this image?')) {
        fetch('{{ route("admin.products.remove-gallery-image", $product) }}', {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ index: index })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove the thumbnail from the DOM
                const thumbnail = document.querySelector(`[onclick="removeGalleryImage(${index})"]`);
                if (thumbnail) {
                    thumbnail.remove();
                }
                
                // Show success message
                alert('Gallery image removed successfully!');
                
                // Reload page to update the gallery display
                location.reload();
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred while removing the image.');
        });
    }
}
</script>
@endpush

@endsection 
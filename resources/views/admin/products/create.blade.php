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
                    <label for="image">Product Image</label>
                    <input type="file" name="image" id="image" class="mobile-input" accept="image/*">
                    <small class="text-muted">Upload a high-quality image for your product</small>
                </div>
                
                <div class="mobile-form-group mobile-checkbox-group">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" class="mobile-checkbox" value="1" {{ old('is_active', true) ? 'checked' : '' }}>
                    <label class="mobile-checkbox-label" for="is_active">Make this product active</label>
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
@endsection

 
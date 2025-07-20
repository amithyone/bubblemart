@extends('layouts.admin-mobile')

@section('title', 'Product Details')

@section('content')
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800">Product Details</h1>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid rounded mb-3">
                    @else
                        <div class="bg-light text-center py-5 mb-3">
                            <i class="fas fa-image fa-3x text-muted"></i>
                        </div>
                    @endif
                </div>
                <div class="col-md-8">
                    <h3>{{ $product->name }}</h3>
                    <p class="text-muted">SKU: {{ $product->sku ?? '-' }}</p>
                    <p>{{ $product->description }}</p>
                    <p><strong>Category:</strong> {{ $product->category->name ?? '-' }}</p>
                    <p><strong>Store:</strong> {{ $product->store->name ?? '-' }}</p>
                    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    <p><strong>Status:</strong> 
                        @if($product->is_active)
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-secondary">Inactive</span>
                        @endif
                    </p>
                    <p><strong>Created:</strong> {{ $product->created_at->format('M d, Y H:i') }}</p>
                    <p><strong>Updated:</strong> {{ $product->updated_at->format('M d, Y H:i') }}</p>
                    <div class="mt-3">
                        <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-warning mr-2"><i class="fas fa-edit"></i> Edit</a>
                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"><i class="fas fa-trash"></i> Delete</button>
                        </form>
                        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary ml-2"><i class="fas fa-arrow-left"></i> Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
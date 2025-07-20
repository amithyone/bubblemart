@extends('layouts.template')

@section('content')
<div class="container py-4">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold text-theme-1 mb-0">
            <i class="bi bi-grid-3x3-gap-fill me-2 text-theme-1"></i>
            Categories
        </h2>
        <a href="{{ route('products.index') }}" class="btn btn-theme btn-sm" style="border-radius: 10px;">
            <i class="bi bi-box-seam me-1"></i> All Products
        </a>
    </div>
    <div class="row g-3">
        @foreach($categories as $category)
        <div class="col-6 col-md-4 col-lg-3">
            <a href="{{ route('categories.show', $category->slug) }}" class="text-decoration-none">
                <div class="card adminuiux-card h-100 text-center" style="border-radius: 20px;">
                    <div class="card-body d-flex flex-column align-items-center justify-content-center p-4">
                        <div class="mb-3">
                            <span style="font-size: 3rem;">{{ $category->icon }}</span>
                        </div>
                        <h5 class="card-title fw-bold text-theme-1 mb-1">{{ $category->name }}</h5>
                        <p class="card-text text-secondary small mb-2">{{ $category->description }}</p>
                        <span class="badge bg-theme-1 text-dark" style="border-radius: 8px; font-size: 0.95em;">
                            {{ $category->total_products_count ?? $category->products_count ?? 0 }} Products
                        </span>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection 
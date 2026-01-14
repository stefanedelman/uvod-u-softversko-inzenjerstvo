@extends('layouts.app')

@section('title', 'Početna - Snowboard Shop')

@section('content')
<div class="container">
    <!-- Hero Banner -->
    <div class="bg-primary text-white rounded p-5 mb-5 text-center">
        <h1 class="display-4">🏂 Snowboard Shop</h1>
        <p class="lead">Najbolja oprema za snowboarding po najpovoljnijim cenama!</p>
        <a href="{{ url('/katalog') }}" class="btn btn-light btn-lg">Pregledaj proizvode</a>
    </div>

    <!-- Kategorije -->
    <h2 class="mb-4">Kategorije</h2>
    <div class="row mb-5">
        @foreach($categories as $category)
        <div class="col-md-4 col-lg-2 mb-3">
            <a href="{{ url('/katalog?category=' . $category->id) }}" class="text-decoration-none">
                <div class="card text-center h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="text-muted">{{ $category->products_count }} proizvoda</p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>

    <!-- Izdvojeni proizvodi -->
    <h2 class="mb-4">Izdvojeni proizvodi</h2>
    <div class="row">
        @foreach($featuredProducts as $product)
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card product-card h-100">
                @if($product->image)
                    <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                @else
                    <div class="bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                        <span class="text-muted display-4">🏂</span>
                    </div>
                @endif
                <div class="card-body">
                    <span class="badge bg-secondary category-badge mb-2">{{ $product->category->name }}</span>
                    <h5 class="card-title">{{ $product->name }}</h5>
                    <p class="card-text text-muted small">{{ Str::limit($product->description, 60) }}</p>
                    <p class="h5 text-primary mb-0">{{ number_format($product->price, 0, ',', '.') }} RSD</p>
                </div>
                <div class="card-footer bg-white border-0">
                    <a href="{{ url('/proizvod/' . $product->id) }}" class="btn btn-outline-primary w-100">Pogledaj</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

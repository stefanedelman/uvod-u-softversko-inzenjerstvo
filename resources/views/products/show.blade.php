@extends('layouts.shop')

@section('title', $product->name)

@section('content')
<div class="container">
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Početna</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/katalog') }}">Katalog</a></li>
            <li class="breadcrumb-item"><a href="{{ url('/katalog?category=' . $product->category->id) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Slika proizvoda -->
        <div class="col-md-6 mb-4">
            @if($product->image)
                <img src="{{ $product->image }}" class="img-fluid rounded" alt="{{ $product->name }}" style="width: 100%; height: 400px; object-fit: cover;">
            @else
                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 400px;">
                    <span class="text-muted display-1">🏂</span>
                </div>
            @endif
        </div>

        <!-- Detalji proizvoda -->
        <div class="col-md-6">
            <span class="badge bg-secondary mb-2">{{ $product->category->name }}</span>
            <h1>{{ $product->name }}</h1>
            
            <p class="h2 text-primary my-4">{{ number_format($product->price, 0, ',', '.') }} RSD</p>

            <div class="mb-4">
                @if($product->stock_quantity > 0)
                    <span class="badge bg-success fs-6">✓ Na stanju ({{ $product->stock_quantity }} kom)</span>
                @else
                    <span class="badge bg-danger fs-6">✗ Nema na stanju</span>
                @endif
            </div>

            <p class="lead">{{ $product->description }}</p>

            @if($product->stock_quantity > 0)
            <form action="{{ url('/korpa/dodaj') }}" method="POST" class="mt-4">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <div class="row g-3 align-items-center">
                    <div class="col-auto">
                        <label class="form-label mb-0">Količina:</label>
                    </div>
                    <div class="col-auto">
                        <input type="number" name="quantity" value="1" min="1" 
                               max="{{ $product->stock_quantity }}" class="form-control" style="width: 80px;">
                    </div>
                    <div class="col-auto">
                        <button type="submit" class="btn btn-primary btn-lg">
                            🛒 Dodaj u korpu
                        </button>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>
</div>
@endsection

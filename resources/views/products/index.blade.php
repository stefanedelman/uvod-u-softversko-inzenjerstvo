@extends('layouts.shop')

@section('title', 'Katalog')

@section('content')
<div class="container">
    <div class="row">
        <!-- Filteri - leva strana -->
        <div class="col-md-3">
            <div class="card mb-4">
                <div class="card-header">
                    <strong>Filteri</strong>
                </div>
                <div class="card-body">
                    <!-- Pretraga -->
                    <form action="{{ url('/katalog') }}" method="GET">
                        <div class="mb-3">
                            <label class="form-label">Pretraga</label>
                            <input type="text" name="search" class="form-control" 
                                   value="{{ request('search') }}" placeholder="Naziv proizvoda...">
                        </div>
                        
                        <!-- Kategorije -->
                        <div class="mb-3">
                            <label class="form-label">Kategorija</label>
                            <select name="category" class="form-select">
                                <option value="">Sve kategorije</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" 
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Primeni filtere</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Proizvodi - desna strana -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>
                    @if(request('category'))
                        {{ $categories->find(request('category'))->name ?? 'Proizvodi' }}
                    @else
                        Svi proizvodi
                    @endif
                </h2>
                <span class="text-muted">{{ $products->count() }} proizvoda</span>
            </div>

            @if($products->isEmpty())
                <div class="alert alert-info">
                    Nema proizvoda koji odgovaraju vašoj pretrazi.
                </div>
            @else
                <div class="row">
                    @foreach($products as $product)
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card product-card h-100">
                            @if($product->image)
                                <img src="{{ $product->image }}" class="card-img-top" alt="{{ $product->name }}" style="height: 180px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                                    <span class="text-muted display-4">🏂</span>
                                </div>
                            @endif
                            <div class="card-body">
                                <span class="badge bg-secondary category-badge mb-2">{{ $product->category->name }}</span>
                                <h6 class="card-title">{{ $product->name }}</h6>
                                <p class="card-text text-muted small">{{ Str::limit($product->description, 60) }}</p>
                                <p class="h5 text-primary mb-1">{{ number_format($product->price, 0, ',', '.') }} RSD</p>
                                <small class="text-muted">
                                    @if($product->stock_quantity > 0)
                                        <span class="text-success">✓ Na stanju</span>
                                    @else
                                        <span class="text-danger">✗ Nema na stanju</span>
                                    @endif
                                </small>
                            </div>
                            <div class="card-footer bg-white border-0">
                                <a href="{{ url('/proizvod/' . $product->id) }}" class="btn btn-outline-primary w-100">Pogledaj detalje</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

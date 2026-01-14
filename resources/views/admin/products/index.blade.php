@extends('admin.layouts.admin')

@section('title', 'Proizvodi')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Lista proizvoda</h4>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Dodaj proizvod
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Slika</th>
                    <th>Naziv</th>
                    <th>Kategorija</th>
                    <th>Cena</th>
                    <th>Zaliha</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>
                            @if($product->image)
                                <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $product->name }}</td>
                        <td>{{ $product->category->name ?? '-' }}</td>
                        <td>{{ number_format($product->price, 0, ',', '.') }} RSD</td>
                        <td>
                            <span class="badge bg-{{ $product->stock_quantity > 10 ? 'success' : ($product->stock_quantity > 0 ? 'warning' : 'danger') }}">
                                {{ $product->stock_quantity }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.products.delete', $product) }}" method="POST" class="d-inline" onsubmit="return confirm('Da li ste sigurni?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Nema proizvoda.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $products->links() }}
    </div>
</div>
@endsection

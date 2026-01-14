@extends('layouts.app')

@section('title', 'Korpa - Snowboard Shop')

@section('content')
<div class="container">
    <h1 class="mb-4">🛒 Vaša korpa</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(empty($cart) || count($cart) == 0)
        <div class="alert alert-info">
            <h4>Korpa je prazna</h4>
            <p>Dodajte proizvode u korpu da biste nastavili sa kupovinom.</p>
            <a href="{{ url('/katalog') }}" class="btn btn-primary">Pregledaj proizvode</a>
        </div>
    @else
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <strong>Proizvodi u korpi</strong>
                    </div>
                    <ul class="list-group list-group-flush">
                        @php $total = 0; @endphp
                        @foreach($cart as $item)
                            @php 
                                $subtotal = $item['price'] * $item['quantity'];
                                $total += $subtotal;
                            @endphp
                            <li class="list-group-item">
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <h5 class="mb-1">{{ $item['name'] }}</h5>
                                        <small class="text-muted">{{ number_format($item['price'], 2) }} RSD / kom</small>
                                    </div>
                                    <div class="col-md-2">
                                        <span class="badge bg-secondary">x{{ $item['quantity'] }}</span>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <strong>{{ number_format($subtotal, 2) }} RSD</strong>
                                    </div>
                                    <div class="col-md-2 text-end">
                                        <form action="{{ url('/korpa/ukloni/' . $item['product_id']) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">✕</button>
                                        </form>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <strong>Pregled porudžbine</strong>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ukupno proizvoda:</span>
                            <span>{{ count($cart) }}</span>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between mb-3">
                            <strong class="h5">Ukupno:</strong>
                            <strong class="h5 text-primary">{{ number_format($total, 2) }} RSD</strong>
                        </div>
                        <a href="{{ url('/checkout') }}" class="btn btn-primary w-100 btn-lg">
                            Nastavi na plaćanje
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection

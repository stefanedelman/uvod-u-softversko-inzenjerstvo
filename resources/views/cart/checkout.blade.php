@extends('layouts.shop')

@section('title', 'Checkout')

@section('content')
<div class="container">
    <h1 class="mb-4">Završi porudžbinu</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <form action="{{ url('/checkout') }}" method="POST">
                @csrf
                
                <!-- Podaci za dostavu -->
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>1. Podaci za dostavu</strong>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Ime *</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Prezime *</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Telefon *</label>
                            <input type="tel" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Adresa dostave *</label>
                            <input type="text" name="address" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Grad *</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Poštanski broj *</label>
                                <input type="text" name="zip" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Način plaćanja -->
                <div class="card mb-4">
                    <div class="card-header">
                        <strong>2. Način plaćanja</strong>
                    </div>
                    <div class="card-body">
                        <div class="form-check mb-2">
                            <input class="form-check-input" type="radio" name="payment_method" value="pouzecem" id="pouzecem" checked>
                            <label class="form-check-label" for="pouzecem">
                                💵 Plaćanje pouzećem
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="payment_method" value="kartica" id="kartica">
                            <label class="form-check-label" for="kartica">
                                💳 Plaćanje karticom
                            </label>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-lg w-100">
                    ✓ Potvrdi porudžbinu
                </button>
            </form>
        </div>

        <!-- Pregled korpe -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <strong>Vaša porudžbina</strong>
                </div>
                <ul class="list-group list-group-flush">
                    @php $total = 0; @endphp
                    @foreach($cart as $item)
                        @php $total += $item['price'] * $item['quantity']; @endphp
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $item['name'] }} x{{ $item['quantity'] }}</span>
                            <strong>{{ number_format($item['price'] * $item['quantity'], 2) }} RSD</strong>
                        </li>
                    @endforeach
                </ul>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <strong class="h5 mb-0">Ukupno:</strong>
                        <strong class="h5 mb-0 text-primary">{{ number_format($total, 2) }} RSD</strong>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

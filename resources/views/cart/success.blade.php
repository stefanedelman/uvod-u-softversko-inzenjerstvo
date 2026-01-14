@extends('layouts.shop')

@section('title', 'Porudžbina uspešna')

@section('content')
<div class="container">
    <div class="text-center py-5">
        <div class="mb-4">
            <span class="display-1">✅</span>
        </div>
        <h1 class="text-success">Porudžbina uspešno kreirana!</h1>
        <p class="lead text-muted">Hvala vam na kupovini!</p>
        
        <div class="card mx-auto mt-4" style="max-width: 500px;">
            <div class="card-body">
                <h5>Detalji porudžbine</h5>
                <p class="mb-1"><strong>Broj porudžbine:</strong> #{{ $order->id }}</p>
                <p class="mb-1"><strong>Status:</strong> <span class="badge bg-warning">{{ $order->status }}</span></p>
                <p class="mb-1"><strong>Ukupno:</strong> {{ number_format($order->total_price, 2) }} RSD</p>
                <p class="mb-0"><strong>Datum:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
            </div>
        </div>

        <div class="mt-4">
            <a href="{{ url('/') }}" class="btn btn-primary">Nazad na početnu</a>
            <a href="{{ url('/katalog') }}" class="btn btn-outline-primary">Nastavi kupovinu</a>
        </div>
    </div>
</div>
@endsection

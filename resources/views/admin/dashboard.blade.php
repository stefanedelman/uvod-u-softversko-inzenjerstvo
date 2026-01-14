@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-uppercase opacity-75">Proizvodi</h6>
                        <h2 class="mb-0">{{ $stats['products'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-box-seam fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-uppercase opacity-75">Kategorije</h6>
                        <h2 class="mb-0">{{ $stats['categories'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-tags fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-uppercase opacity-75">Narudžbine</h6>
                        <h2 class="mb-0">{{ $stats['orders'] }}</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-cart-check fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h6 class="text-uppercase opacity-75">Prihod</h6>
                        <h2 class="mb-0">{{ number_format($stats['revenue'], 0, ',', '.') }} RSD</h2>
                    </div>
                    <div class="align-self-center">
                        <i class="bi bi-cash-stack fs-1 opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Nedavne narudžbine</h5>
            </div>
            <div class="card-body">
                @if($recentOrders->count() > 0)
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Korisnik</th>
                                <th>Ukupno</th>
                                <th>Status</th>
                                <th>Datum</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>{{ $order->user->name ?? 'Gost' }}</td>
                                    <td>{{ number_format($order->total_price, 0, ',', '.') }} RSD</td>
                                    <td>
                                        <span class="badge bg-{{ $order->status === 'delivered' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'warning') }}">
                                            {{ ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-muted mb-0">Nema narudžbina.</p>
                @endif
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Brze akcije</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary w-100 mb-2">
                    <i class="bi bi-plus-circle"></i> Dodaj proizvod
                </a>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-success w-100 mb-2">
                    <i class="bi bi-plus-circle"></i> Dodaj kategoriju
                </a>
                <a href="{{ route('admin.orders') }}" class="btn btn-warning w-100">
                    <i class="bi bi-cart-check"></i> Pregledaj narudžbine
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

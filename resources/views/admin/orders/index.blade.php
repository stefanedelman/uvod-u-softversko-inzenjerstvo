@extends('admin.layouts.admin')

@section('title', 'Narudžbine')

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Korisnik</th>
                    <th>Ukupno</th>
                    <th>Način plaćanja</th>
                    <th>Status</th>
                    <th>Datum</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>#{{ $order->id }}</td>
                        <td>{{ $order->user->name ?? 'Gost' }}</td>
                        <td>{{ number_format($order->total_price, 0, ',', '.') }} RSD</td>
                        <td>{{ ucfirst($order->payment_method) }}</td>
                        <td>
                            @php
                                $statusColors = [
                                    'pending' => 'warning',
                                    'processing' => 'info',
                                    'shipped' => 'primary',
                                    'delivered' => 'success',
                                    'cancelled' => 'danger',
                                ];
                            @endphp
                            <span class="badge bg-{{ $statusColors[$order->status] ?? 'secondary' }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </td>
                        <td>{{ $order->created_at->format('d.m.Y H:i') }}</td>
                        <td>
                            <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-eye"></i> Detalji
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Nema narudžbina.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $orders->links() }}
    </div>
</div>
@endsection

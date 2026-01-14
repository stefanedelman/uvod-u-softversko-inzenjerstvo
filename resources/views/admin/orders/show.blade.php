@extends('admin.layouts.admin')

@section('title', 'Narudžbina #' . $order->id)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Stavke narudžbine</h5>
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Proizvod</th>
                            <th>Cena</th>
                            <th>Količina</th>
                            <th>Ukupno</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ $item->product->image }}" alt="" style="width: 40px; height: 40px; object-fit: cover;" class="me-2">
                                        @endif
                                        {{ $item->product->name ?? 'Proizvod obrisan' }}
                                    </div>
                                </td>
                                <td>{{ number_format($item->price, 0, ',', '.') }} RSD</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->price * $item->quantity, 0, ',', '.') }} RSD</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="table-light">
                            <td colspan="3" class="text-end"><strong>Ukupno:</strong></td>
                            <td><strong>{{ number_format($order->total_price, 0, ',', '.') }} RSD</strong></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="mb-0">Informacije o narudžbini</h5>
            </div>
            <div class="card-body">
                <p><strong>ID:</strong> #{{ $order->id }}</p>
                <p><strong>Datum:</strong> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                <p><strong>Korisnik:</strong> {{ $order->user->name ?? 'Gost' }}</p>
                <p><strong>Email:</strong> {{ $order->user->email ?? '-' }}</p>
                <p><strong>Način plaćanja:</strong> {{ ucfirst($order->payment_method) }}</p>
                <hr>
                <form action="{{ route('admin.orders.status', $order) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <label for="status" class="form-label"><strong>Status:</strong></label>
                    <select name="status" id="status" class="form-select mb-2">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-check-lg"></i> Ažuriraj status
                    </button>
                </form>
            </div>
        </div>

        <a href="{{ route('admin.orders') }}" class="btn btn-secondary w-100">
            <i class="bi bi-arrow-left"></i> Nazad na listu
        </a>
    </div>
</div>
@endsection

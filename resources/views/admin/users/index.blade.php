@extends('admin.layouts.admin')

@section('title', 'Korisnici')

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Ime</th>
                    <th>Email</th>
                    <th>Narudžbine</th>
                    <th>Admin</th>
                    <th>Registrovan</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $user->orders_count }}</span>
                        </td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge bg-success">Da</span>
                            @else
                                <span class="badge bg-secondary">Ne</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d.m.Y') }}</td>
                        <td>
                            @if($user->id !== Auth::id())
                                <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-{{ $user->is_admin ? 'warning' : 'success' }}">
                                        @if($user->is_admin)
                                            <i class="bi bi-shield-x"></i> Ukloni admin
                                        @else
                                            <i class="bi bi-shield-check"></i> Dodeli admin
                                        @endif
                                    </button>
                                </form>
                            @else
                                <span class="text-muted">Trenutni korisnik</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Nema korisnika.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $users->links() }}
    </div>
</div>
@endsection

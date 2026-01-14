@extends('admin.layouts.admin')

@section('title', 'Kategorije')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4>Lista kategorija</h4>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
        <i class="bi bi-plus-circle"></i> Dodaj kategoriju
    </a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Naziv</th>
                    <th>Opis</th>
                    <th>Broj proizvoda</th>
                    <th>Akcije</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td>{{ $category->id }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ Str::limit($category->description, 50) }}</td>
                        <td>
                            <span class="badge bg-primary">{{ $category->products_count }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categories.delete', $category) }}" method="POST" class="d-inline" onsubmit="return confirm('Da li ste sigurni?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" {{ $category->products_count > 0 ? 'disabled' : '' }}>
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Nema kategorija.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $categories->links() }}
    </div>
</div>
@endsection

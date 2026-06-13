@extends('admin.layout')
@section('title', 'Catégories')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3>Catégories</h3>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-dark">+ Nouvelle catégorie</a>
</div>

<table class="table table-bordered table-hover">
    <thead class="table-dark">
        <tr><th>Nom</th><th>Slug</th><th>Articles</th><th>Actions</th></tr>
    </thead>
    <tbody>
        @forelse($categories as $cat)
        <tr>
            <td>{{ $cat->nom }}</td>
            <td><code>{{ $cat->slug }}</code></td>
            <td>{{ $cat->posts_count }}</td>
            <td>
                <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-outline-dark">Modifier</a>
                <form method="POST" action="{{ route('admin.categories.destroy', $cat) }}"
                    class="d-inline" onsubmit="return confirm('Supprimer ?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                </form>
            </td>
        </tr>
        @empty
        <tr><td colspan="4" class="text-center text-muted">Aucune catégorie.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection

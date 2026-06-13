@extends('admin.layout')
@section('title', 'Modifier la catégorie')

@section('content')
<h3 class="mb-4">Modifier : {{ $category->nom }}</h3>

<form method="POST" action="{{ route('admin.categories.update', $category) }}" style="max-width:400px">
    @csrf @method('PUT')
    <div class="mb-3">
        <label class="form-label">Nom</label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $category->nom) }}" required>
        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
    </div>
    <button class="btn btn-dark">Mettre à jour</button>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary ms-2">Annuler</a>
</form>
@endsection

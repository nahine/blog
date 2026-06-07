@extends('admin.layout')
@section('title', 'Modifier un article')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h3 class="mb-0">Modifier : {{ $post->title }}</h3>
    <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Titre *</label>
                        <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                            value="{{ old('title', $post->title) }}" required>
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Extrait (optionnel)</label>
                        <textarea name="excerpt" rows="2" class="form-control @error('excerpt') is-invalid @enderror" 
                            placeholder="Court résumé de l'article (max 500 caractères)">{{ old('excerpt', $post->excerpt) }}</textarea>
                        @error('excerpt') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Contenu *</label>
                        <textarea name="content" rows="15"
                            class="form-control @error('content') is-invalid @enderror" required>{{ old('content', $post->content) }}</textarea>
                        @error('content') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Image de couverture</label>
                        
                        @if($post->image)
                        <div class="mb-2">
                            <img src="{{ $post->image_url }}" alt="Image actuelle" class="img-fluid rounded border">
                            <small class="text-muted d-block mt-1">Image actuelle</small>
                        </div>
                        @endif
                        
                        <input type="file" name="image" class="form-control @error('image') is-invalid @enderror"
                            accept="image/*" onchange="previewImage(event)">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <small class="text-muted d-block mt-1">JPG, PNG, GIF ou WebP - Max 2MB</small>
                        
                        <div id="imagePreview" class="mt-3" style="display: none;">
                            <img id="preview" src="" alt="Nouvel aperçu" class="img-fluid rounded border">
                            <small class="text-muted d-block mt-1">Nouvel aperçu</small>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Catégorie *</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}"
                                    {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input" name="publish" id="publish"
                                        {{ $post->isPublished() ? 'checked' : '' }}>
                                    <label class="form-check-label fw-bold" for="publish">
                                        {{ $post->isPublished() ? 'Publié' : 'Brouillon' }}
                                    </label>
                                </div>
                                <small class="text-muted">
                                    @if($post->published_at)
                                        Publié le {{ $post->published_at->format('d/m/Y à H:i') }}
                                    @else
                                        Non publié
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>

                    <div class="card border-info">
                        <div class="card-body">
                            <h6 class="card-title">Statistiques</h6>
                            <ul class="list-unstyled mb-0 small">
                                <li><i class="bi bi-heart-fill text-danger"></i> {{ $post->likes_count ?? 0 }} likes</li>
                                <li><i class="bi bi-chat-fill text-primary"></i> {{ $post->comments_count ?? 0 }} commentaires</li>
                                <li><i class="bi bi-calendar-event"></i> Créé le {{ $post->created_at->format('d/m/Y') }}</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.posts.index') }}" class="btn btn-outline-secondary">
                    <i class="bi bi-x-circle"></i> Annuler
                </a>
                <button type="submit" class="btn btn-dark btn-lg">
                    <i class="bi bi-check-circle"></i> Mettre à jour
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function previewImage(event) {
    const preview = document.getElementById('preview');
    const previewDiv = document.getElementById('imagePreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            previewDiv.style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection

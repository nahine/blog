@extends('admin.layout')
@section('title', 'Articles')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="mb-0">Gestion des Articles</h3>
        <small class="text-muted">Total : {{ $posts->total() }} article(s)</small>
    </div>
    <a href="{{ route('admin.posts.create') }}" class="btn btn-dark btn-lg">
        <i class="bi bi-plus-circle"></i> Nouvel article
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th style="width: 80px;">Image</th>
                        <th>Titre</th>
                        <th style="width: 150px;">Catégorie</th>
                        <th style="width: 100px;" class="text-center">Likes</th>
                        <th style="width: 100px;" class="text-center">Comments</th>
                        <th style="width: 120px;">Statut</th>
                        <th style="width: 120px;">Date</th>
                        <th style="width: 200px;" class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td>
                            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" 
                                class="img-thumbnail" style="width: 60px; height: 60px; object-fit: cover;">
                        </td>
                        <td>
                            <div class="fw-bold">{{ Str::limit($post->title, 50) }}</div>
                            <small class="text-muted">Par {{ $post->user->name }}</small>
                        </td>
                        <td>
                            <span class="badge bg-info text-dark">{{ $post->category->name }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-danger"><i class="bi bi-heart-fill"></i> {{ $post->likes_count }}</span>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-primary"><i class="bi bi-chat-fill"></i> {{ $post->comments_count }}</span>
                        </td>
                        <td>
                            @if($post->isPublished())
                                <span class="badge bg-success">Publié</span>
                            @else
                                <span class="badge bg-secondary">Brouillon</span>
                            @endif
                        </td>
                        <td>
                            <small>{{ $post->created_at->format('d/m/Y') }}</small>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="{{ route('posts.show', $post->slug) }}" 
                                    class="btn btn-outline-info" target="_blank" title="Voir">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.posts.edit', $post) }}" 
                                    class="btn btn-outline-dark" title="Modifier">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                    class="d-inline" onsubmit="return confirm('Supprimer définitivement cet article ?')">
                                    @csrf @method('DELETE')
                                    <button class="btn btn-outline-danger" title="Supprimer">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-5">
                            <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                            <p class="mt-3 mb-0">Aucun article pour le moment.</p>
                            <a href="{{ route('admin.posts.create') }}" class="btn btn-dark mt-3">
                                Créer le premier article
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4">
    {{ $posts->links() }}
</div>
@endsection

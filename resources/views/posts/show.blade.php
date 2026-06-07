@extends('layouts.app')
@section('title', $post->title)

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <!-- Bouton Retour -->
        <div class="mb-3">
            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Retour aux articles
            </a>
        </div>
        
        <!-- Article Header -->
        <article class="mb-5">
            <div class="mb-3">
                <a href="{{ route('categories.show', $post->category->slug) }}" 
                    class="badge bg-info text-dark text-decoration-none fs-6">
                    {{ $post->category->name }}
                </a>
            </div>
            
            <h1 class="display-4 fw-bold mb-3">{{ $post->title }}</h1>
            
            <div class="d-flex align-items-center gap-3 text-muted mb-4">
                <span><i class="bi bi-person-circle"></i> {{ $post->user->name }}</span>
                <span><i class="bi bi-calendar-event"></i> {{ $post->published_at->format('d M Y') }}</span>
                <span><i class="bi bi-clock"></i> {{ $post->reading_time }} min de lecture</span>
                <span><i class="bi bi-eye"></i> {{ $post->likes_count }} likes</span>
                <span><i class="bi bi-chat"></i> {{ $post->comments_count }} commentaires</span>
            </div>

            <!-- Featured Image -->
            <img src="{{ $post->image_url }}" alt="{{ $post->title }}" 
                class="img-fluid rounded shadow-sm mb-4" style="width: 100%; max-height: 500px; object-fit: cover;">

            <!-- Content -->
            <div class="post-content fs-5 lh-lg mb-5">
                {!! nl2br(e($post->content)) !!}
            </div>

            <!-- Like Section -->
            <div class="card bg-light mb-5" id="like-section">
                <div class="card-body text-center">
                    @auth
                    <button type="button" onclick="toggleLike()" class="btn btn-lg {{ $post->isLikedBy(auth()->user()) ? 'btn-danger' : 'btn-outline-danger' }}" id="like-btn">
                        <i class="bi bi-heart-fill"></i>
                        <span id="like-text">{{ $post->isLikedBy(auth()->user()) ? 'Vous aimez cet article' : 'J\'aime cet article' }}</span>
                        <span class="badge bg-white text-dark ms-2" id="like-count">{{ $post->likes_count }}</span>
                    </button>
                    @else
                    <p class="mb-3">
                        <i class="bi bi-heart-fill text-danger fs-3"></i>
                        <span class="fs-4 fw-bold ms-2">{{ $post->likes_count }} personnes aiment cet article</span>
                    </p>
                    <a href="{{ route('login') }}" class="btn btn-dark">
                        Connectez-vous pour aimer cet article
                    </a>
                    @endauth
                </div>
            </div>
        </article>

        <!-- Related Posts -->
        @if(isset($relatedPosts) && $relatedPosts->count() > 0)
        <section class="mb-5">
            <h3 class="mb-4">Articles similaires</h3>
            <div class="row">
                @foreach($relatedPosts as $related)
                <div class="col-md-4 mb-3">
                    <div class="card h-100 shadow-sm">
                        <img src="{{ $related->image_url }}" class="card-img-top" alt="{{ $related->title }}"
                            style="height: 150px; object-fit: cover;">
                        <div class="card-body">
                            <h6 class="card-title">
                                <a href="{{ route('posts.show', $related->slug) }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($related->title, 50) }}
                                </a>
                            </h6>
                            <small class="text-muted d-flex gap-2">
                                <span><i class="bi bi-heart-fill text-danger"></i> {{ $related->likes_count }}</span>
                                <span><i class="bi bi-chat-fill text-primary"></i> {{ $related->comments_count }}</span>
                            </small>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </section>
        <hr class="my-5">
        @endif

        <!-- Comments Section -->
        <section class="mb-5" id="comments-section">
            <h3 class="mb-4">Commentaires ({{ $post->comments_count }})</h3>

            <!-- Add Comment -->
            @auth
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form method="POST" action="{{ route('comments.store', $post) }}#comments-section">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-bold">Laissez votre commentaire</label>
                            <textarea name="body" class="form-control @error('body') is-invalid @enderror"
                                rows="4" placeholder="Partagez votre avis..." required minlength="2"></textarea>
                            @error('body') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <button type="submit" class="btn btn-dark">
                            <i class="bi bi-send"></i> Publier le commentaire
                        </button>
                    </form>
                </div>
            </div>
            @else
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i>
                <a href="{{ route('login') }}" class="alert-link">Connectez-vous</a> pour laisser un commentaire.
            </div>
            @endauth

            <!-- Comments List -->
            @forelse($post->comments as $comment)
            <div class="card shadow-sm mb-3" id="comment-{{ $comment->id }}">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <strong class="text-primary">
                                <i class="bi bi-person-circle"></i> {{ $comment->user->name }}
                            </strong>
                            <small class="text-muted d-block">
                                <i class="bi bi-clock"></i> {{ $comment->created_at->diffForHumans() }}
                            </small>
                        </div>
                        
                        @if(auth()->check() && auth()->user()->isAdmin())
                        <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}"
                            class="d-inline"
                            onsubmit="return confirm('Supprimer ce commentaire ?')">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                        @endif
                    </div>
                    
                    <p class="mb-3">{{ $comment->body }}</p>

                    <!-- Reply Button -->
                    @auth
                    <button class="btn btn-sm btn-outline-secondary" 
                        type="button"
                        onclick="toggleReply({{ $comment->id }})">
                        <i class="bi bi-reply"></i> Répondre
                    </button>
                    
                    <div class="mt-3" id="reply-{{ $comment->id }}" style="display: none;">
                        <form method="POST" action="{{ route('comments.reply', $comment) }}#comment-{{ $comment->id }}">
                            @csrf
                            <div class="mb-2">
                                <textarea name="body" class="form-control" rows="2"
                                    placeholder="Votre réponse..." required minlength="2"></textarea>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-sm btn-dark">
                                    <i class="bi bi-send"></i> Envoyer
                                </button>
                                <button type="button" class="btn btn-sm btn-secondary" 
                                    onclick="toggleReply({{ $comment->id }})">
                                    Annuler
                                </button>
                            </div>
                        </form>
                    </div>
                    @else
                    <a href="{{ route('login') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-reply"></i> Répondre (Connexion requise)
                    </a>
                    @endauth

                    <!-- Replies -->
                    @if($comment->replies->count() > 0)
                    <div class="mt-3">
                        @foreach($comment->replies as $reply)
                        <div class="card bg-light mb-2">
                            <div class="card-body py-2">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong class="text-success">
                                            <i class="bi bi-arrow-return-right"></i> {{ $reply->user->name }}
                                        </strong>
                                        <small class="text-muted d-block">
                                            {{ $reply->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    
                                    @if(auth()->check() && auth()->user()->isAdmin())
                                    <form method="POST" action="{{ route('admin.comments.destroy', $reply) }}"
                                        class="d-inline"
                                        onsubmit="return confirm('Supprimer cette réponse ?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                <p class="mb-0 mt-2">{{ $reply->body }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-chat-quote" style="font-size: 3rem; color: #dee2e6;"></i>
                <p class="text-muted mt-3">Aucun commentaire pour le moment. Soyez le premier !</p>
            </div>
            @endforelse
        </section>
    </div>
</div>

<style>
.post-content {
    line-height: 1.8;
    color: #333;
}
.post-content p {
    margin-bottom: 1.5rem;
}
/* Ajustement pour les ancres pour compenser la navbar sticky */
#like-section {
    scroll-margin-top: 20px;
}
#comments-section {
    scroll-margin-top: 20px;
}
</style>

<script>
function toggleReply(commentId) {
    const replyForm = document.getElementById('reply-' + commentId);
    if (replyForm.style.display === 'none') {
        replyForm.style.display = 'block';
        setTimeout(() => {
            replyForm.querySelector('textarea').focus();
        }, 100);
    } else {
        replyForm.style.display = 'none';
    }
}

// Toggle like avec AJAX (pas de rechargement!)
function toggleLike() {
    const btn = document.getElementById('like-btn');
    const likeText = document.getElementById('like-text');
    const likeCount = document.getElementById('like-count');
    
    btn.disabled = true;
    
    fetch('{{ route("posts.like", $post) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Erreur HTTP: ' + response.status);
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            // Mettre à jour le compteur
            likeCount.textContent = data.likes_count;
            
            // Changer le style du bouton
            if (data.liked) {
                btn.classList.remove('btn-outline-danger');
                btn.classList.add('btn-danger');
                likeText.textContent = 'Vous aimez cet article';
            } else {
                btn.classList.remove('btn-danger');
                btn.classList.add('btn-outline-danger');
                likeText.textContent = "J'aime cet article";
            }
        } else {
            throw new Error('Réponse invalide du serveur');
        }
        
        btn.disabled = false;
    })
    .catch(error => {
        console.error('Erreur complète:', error);
        btn.disabled = false;
        alert('Erreur: ' + error.message + '. Vérifiez la console (F12) pour plus de détails.');
    });
}
</script>
@endsection

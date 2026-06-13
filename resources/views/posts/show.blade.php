@extends('layouts.app')
@section('title', $post->titre)
@section('meta_description', $post->extrait)

@section('content')
<div class="row">
    <div class="col-lg-8 mx-auto">
        <div class="mb-4">
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-brand">
                <i class="bi bi-arrow-left"></i> Retour aux articles
            </a>
        </div>

        <article class="mb-5">
            <div class="mb-3">
                <a href="{{ route('categories.show', $post->category->slug) }}" class="badge cat-pill text-decoration-none">
                    {{ $post->category->nom }}
                </a>
            </div>

            <h1 class="fw-bold mb-3" style="font-size: clamp(1.9rem, 4vw, 2.8rem); line-height: 1.15;">{{ $post->titre }}</h1>

            <div class="d-flex align-items-center flex-wrap gap-3 mb-4">
                <span class="meta-chip"><i class="bi bi-person-circle"></i> {{ $post->user->nom }}</span>
                <span class="meta-chip"><i class="bi bi-calendar-event"></i> {{ $post->publie_le->format('d M Y') }}</span>
                <span class="meta-chip"><i class="bi bi-clock"></i> {{ $post->reading_time }} min de lecture</span>
                <span class="meta-chip"><i class="bi bi-heart-fill"></i> <span data-likes-count>{{ $post->likes_count }}</span> likes</span>
                <span class="meta-chip"><i class="bi bi-chat-dots"></i> <span data-comments-count>{{ $post->comments_count }}</span> commentaires</span>
            </div>

            <img src="{{ $post->image_url }}" alt="{{ $post->titre }}" class="article-hero-img mb-4">

            <div class="post-content mb-5">
                {!! nl2br(e($post->contenu)) !!}
            </div>

            <!-- Like -->
            <div class="like-box p-4 text-center mb-5" id="like-section">
                @auth
                <form method="POST" action="{{ route('posts.like', $post) }}" class="like-form m-0">
                    @csrf
                    <button type="submit" class="btn btn-like {{ $post->isLikedBy(auth()->user()) ? 'is-liked' : '' }}">
                        <i class="bi bi-heart-fill"></i>
                        <span class="like-label">{{ $post->isLikedBy(auth()->user()) ? 'Vous aimez cet article' : "J'aime cet article" }}</span>
                        <span class="like-count" data-likes-count>{{ $post->likes_count }}</span>
                    </button>
                </form>
                @else
                <p class="mb-3">
                    <i class="bi bi-heart-fill" style="color: var(--like); font-size: 1.5rem;"></i>
                    <span class="fs-5 fw-bold ms-2"><span data-likes-count>{{ $post->likes_count }}</span> personnes aiment cet article</span>
                </p>
                <a href="{{ route('login') }}" class="btn btn-brand">
                    <i class="bi bi-box-arrow-in-right"></i> Connectez-vous pour aimer cet article
                </a>
                @endauth
            </div>
        </article>

        <!-- Articles similaires -->
        @if(isset($relatedPosts) && $relatedPosts->count() > 0)
        <section class="mb-5">
            <h3 class="section-title mb-4">Articles similaires</h3>
            <div class="row g-3">
                @foreach($relatedPosts as $related)
                <div class="col-md-4">
                    <a href="{{ route('posts.show', $related->slug) }}" class="text-decoration-none">
                        <div class="card h-100 hover-lift">
                            <img src="{{ $related->image_url }}" class="card-img-top" alt="{{ $related->titre }}" style="height: 150px; object-fit: cover;">
                            <div class="card-body">
                                <h6 class="card-title" style="color: var(--ink-900);">{{ Str::limit($related->titre, 50) }}</h6>
                                <div class="d-flex gap-3 mt-2">
                                    <span class="meta-chip"><i class="bi bi-heart-fill"></i> {{ $related->likes_count }}</span>
                                    <span class="meta-chip"><i class="bi bi-chat-dots"></i> {{ $related->comments_count }}</span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </section>
        @endif

        <!-- Commentaires -->
        <section class="mb-5" id="comments-section">
            <h3 class="section-title mb-4">Commentaires (<span data-comments-count>{{ $post->comments_count }}</span>)</h3>

            @auth
            <div class="card mb-4">
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('comments.store', $post) }}" id="comment-form">
                        @csrf
                        <label class="form-label">Laissez votre commentaire</label>
                        <div class="d-flex gap-3">
                            <div class="avatar d-none d-sm-grid">{{ strtoupper(mb_substr(auth()->user()->nom, 0, 1)) }}</div>
                            <div class="flex-grow-1">
                                <textarea name="body" class="form-control" rows="3"
                                    placeholder="Partagez votre avis..." required minlength="2"></textarea>
                                <div class="text-end mt-2">
                                    <button type="submit" class="btn btn-brand">
                                        <i class="bi bi-send"></i> Publier
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @else
            <div class="card mb-4">
                <div class="card-body d-flex align-items-center gap-3 p-4">
                    <i class="bi bi-info-circle fs-3" style="color: var(--brand-500);"></i>
                    <span><a href="{{ route('login') }}" class="fw-bold text-decoration-none">Connectez-vous</a> pour rejoindre la discussion.</span>
                </div>
            </div>
            @endauth

            <div id="comments-list">
                @foreach($post->comments as $comment)
                    @include('posts._comment', ['comment' => $comment])
                @endforeach
            </div>

            @if($post->comments->isEmpty())
            <div class="text-center py-5 empty-state" id="comments-empty">
                <i class="bi bi-chat-quote"></i>
                <p class="mt-3">Aucun commentaire pour le moment. Soyez le premier !</p>
            </div>
            @endif
        </section>
    </div>
</div>
@endsection

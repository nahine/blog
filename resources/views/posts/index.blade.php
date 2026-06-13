@extends('layouts.app')
@section('title', isset($category) ? $category->nom : 'Accueil')

@section('content')
@if(!isset($category))
<!-- Hero -->
<section class="hero mb-5">
    <div class="position-relative" style="z-index:1;">
        <span class="badge cat-pill mb-3" style="background: rgba(255,255,255,.18); color:#fff; border-color: rgba(255,255,255,.3);">
            <i class="bi bi-stars"></i> Bienvenue
        </span>
        <h1 class="mb-3">Des idées, des histoires<br>et des découvertes.</h1>
        <p>Explorez mes derniers articles : technologie, réflexions personnelles et bien plus encore.</p>
        <div class="hero-stats">
            <div class="hero-stat">
                <span class="num">{{ $posts->total() }}</span>
                <span class="lbl">Articles</span>
            </div>
            <div class="hero-stat">
                <span class="num">{{ $categories->count() }}</span>
                <span class="lbl">Catégories</span>
            </div>
            <div class="hero-stat">
                <span class="num">{{ \App\Models\Like::count() }}</span>
                <span class="lbl">J'aime</span>
            </div>
        </div>
    </div>
</section>
@else
<div class="mb-4">
    <a href="{{ route('home') }}" class="btn btn-sm btn-outline-brand"><i class="bi bi-arrow-left"></i> Tous les articles</a>
    <h1 class="fw-bold mt-3 mb-1">{{ $category->nom }}</h1>
    <p class="text-muted">Articles dans cette catégorie</p>
</div>
@endif

<!-- Articles populaires -->
@if(!isset($category) && isset($featured) && $featured->count() > 0)
<div class="mb-5">
    <h3 class="section-title mb-1">Articles populaires</h3>
    <p class="text-muted small mb-4 mt-3"><i class="bi bi-fire" style="color: var(--accent);"></i> Les plus aimés par la communauté</p>
    <div class="row g-4">
        @foreach($featured as $featuredPost)
        <div class="col-md-4">
            <a href="{{ route('posts.show', $featuredPost->slug) }}" class="text-decoration-none">
                <div class="card h-100 hover-lift">
                    <div class="position-relative">
                        <img src="{{ $featuredPost->image_url }}" class="card-img-top" alt="{{ $featuredPost->titre }}" style="height: 200px; object-fit: cover;">
                        <span class="badge cat-pill position-absolute" style="top:.75rem; left:.75rem;">{{ $featuredPost->category->nom }}</span>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title" style="color: var(--ink-900);">{{ Str::limit($featuredPost->titre, 55) }}</h5>
                        <div class="d-flex gap-3 mt-3">
                            <span class="meta-chip"><i class="bi bi-heart-fill"></i> {{ $featuredPost->likes_count }}</span>
                            <span class="meta-chip"><i class="bi bi-chat-dots"></i> {{ $featuredPost->comments_count }}</span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endif

<div class="row g-4">
    <!-- Liste -->
    <div class="col-lg-8">
        <h3 class="section-title mb-4">{{ isset($category) ? 'Articles' : 'Tous les articles' }}</h3>

        @forelse($posts as $post)
        <article class="card mb-4 hover-lift">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ $post->image_url }}" class="img-fluid h-100 w-100" alt="{{ $post->titre }}" style="object-fit: cover; min-height: 200px;">
                </div>
                <div class="col-md-8">
                    <div class="card-body h-100 d-flex flex-column p-4">
                        <div class="mb-2">
                            <a href="{{ route('categories.show', $post->category->slug) }}" class="badge cat-pill text-decoration-none">
                                {{ $post->category->nom }}
                            </a>
                        </div>
                        <h4 class="card-title mb-2">
                            <a href="{{ route('posts.show', $post->slug) }}" class="text-decoration-none stretched-link" style="color: var(--ink-900);">
                                {{ $post->titre }}
                            </a>
                        </h4>
                        <p class="text-muted small mb-3">
                            <i class="bi bi-person"></i> {{ $post->user->nom }} ·
                            <i class="bi bi-calendar3"></i> {{ $post->publie_le->translatedFormat('j F Y') }}
                        </p>
                        <p class="card-text flex-grow-1">{{ $post->extrait }}</p>
                        <div class="d-flex gap-3 mt-auto pt-2">
                            <span class="meta-chip"><i class="bi bi-heart-fill"></i> {{ $post->likes_count }} likes</span>
                            <span class="meta-chip"><i class="bi bi-chat-dots"></i> {{ $post->comments_count }} commentaires</span>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        @empty
        <div class="text-center py-5 empty-state">
            <i class="bi bi-journal-x"></i>
            <p class="mt-3">Aucun article disponible pour le moment.</p>
        </div>
        @endforelse

        <div class="mt-4">{{ $posts->links() }}</div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-body p-4">
                <h5 class="mb-3 d-flex align-items-center gap-2"><i class="bi bi-grid" style="color: var(--brand-500);"></i> Catégories</h5>
                <div class="d-flex flex-column gap-1">
                    @foreach($categories as $cat)
                    <a href="{{ route('categories.show', $cat->slug) }}"
                        class="d-flex justify-content-between align-items-center text-decoration-none px-3 py-2 rounded-3 {{ isset($category) && $category->id == $cat->id ? 'fw-bold' : '' }}"
                        style="color: var(--ink-700); transition: background .15s;"
                        onmouseover="this.style.background='var(--brand-50)'" onmouseout="this.style.background='transparent'">
                        <span>{{ $cat->nom }}</span>
                        <span class="badge rounded-pill" style="background: var(--brand-100); color: var(--brand-700);">{{ $cat->posts_count }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="card" style="background: var(--gradient); border:none;">
            <div class="card-body p-4 text-white">
                <h5 class="text-white d-flex align-items-center gap-2"><i class="bi bi-person-heart"></i> À propos</h5>
                <p class="mb-0" style="color: rgba(255,255,255,.9);">
                    Bienvenue sur mon blog personnel ! Je partage ici mes réflexions,
                    mes découvertes et mes passions à travers différents articles.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection

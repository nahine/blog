@extends('layouts.app')
@section('title', isset($category) ? $category->name : 'Accueil')

@section('content')
<!-- Header Section -->
<div class="mb-5">
    <h1 class="display-4 fw-bold mb-3">
        {{ isset($category) ? $category->name : 'Blog Personnel' }}
    </h1>
    <p class="lead text-muted">
        {{ isset($category) ? 'Articles dans cette catégorie' : 'Découvrez mes derniers articles' }}
    </p>
</div>

<!-- Featured Posts (only on home page) -->
@if(!isset($category) && isset($featured) && $featured->count() > 0)
<div class="row mb-5">
    <div class="col-12">
        <h3 class="mb-2">Articles populaires</h3>
        <p class="text-muted small mb-4">
            <i class="bi bi-info-circle"></i> Les articles les plus aimés par la communauté
        </p>
    </div>
    @foreach($featured as $featuredPost)
    <div class="col-md-4 mb-4">
        <a href="{{ route('posts.show', $featuredPost->slug) }}" class="text-decoration-none">
            <div class="card h-100 shadow-sm hover-lift">
                <img src="{{ $featuredPost->image_url }}" class="card-img-top" alt="{{ $featuredPost->title }}" 
                    style="height: 200px; object-fit: cover;">
                <div class="card-body">
                    <span class="badge bg-info text-dark mb-2">{{ $featuredPost->category->name }}</span>
                    <h5 class="card-title text-dark">
                        {{ Str::limit($featuredPost->title, 50) }}
                    </h5>
                    <div class="d-flex align-items-center gap-3 text-muted small mt-3">
                        <span><i class="bi bi-heart-fill text-danger"></i> {{ $featuredPost->likes_count }} likes</span>
                        <span><i class="bi bi-chat-fill text-primary"></i> {{ $featuredPost->comments_count }} commentaires</span>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @endforeach
</div>
<hr class="my-5">
@endif

<div class="row">
    <!-- Main Content -->
    <div class="col-lg-8">
        <h3 class="mb-4">{{ isset($category) ? 'Articles' : 'Tous les articles' }}</h3>

        @forelse($posts as $post)
        <article class="card mb-4 shadow-sm hover-lift">
            <div class="row g-0">
                <div class="col-md-4">
                    <img src="{{ $post->image_url }}" class="img-fluid rounded-start h-100" 
                        alt="{{ $post->title }}" style="object-fit: cover; max-height: 250px;">
                </div>
                <div class="col-md-8">
                    <div class="card-body h-100 d-flex flex-column">
                        <div class="mb-2">
                            <a href="{{ route('categories.show', $post->category->slug) }}" 
                                class="badge bg-info text-dark text-decoration-none">
                                {{ $post->category->name }}
                            </a>
                        </div>
                        
                        <h4 class="card-title">
                            <a href="{{ route('posts.show', $post->slug) }}" 
                                class="text-decoration-none text-dark stretched-link">
                                {{ $post->title }}
                            </a>
                        </h4>
                        
                        <p class="text-muted small mb-2">
                            Par {{ $post->user->name }} · 
                            {{ $post->published_at->format('d M Y') }} ·
                            {{ $post->reading_time }} min de lecture
                        </p>
                        
                        <p class="card-text flex-grow-1">
                            {{ $post->excerpt }}
                        </p>
                        
                        <div class="d-flex align-items-center justify-content-between mt-auto">
                            <div class="d-flex gap-3 text-muted small">
                                <span>{{ $post->likes_count }} likes</span>
                                <span>{{ $post->comments_count }} commentaires</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        @empty
        <div class="text-center py-5">
            <p class="text-muted mt-3 fs-5">Aucun article disponible pour le moment.</p>
        </div>
        @endforelse

        <div class="mt-4">
            {{ $posts->links() }}
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Categories -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">Catégories</h5>
            </div>
            <ul class="list-group list-group-flush">
                @foreach($categories as $cat)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <a href="{{ route('categories.show', $cat->slug) }}" 
                        class="text-decoration-none {{ isset($category) && $category->id == $cat->id ? 'fw-bold' : '' }}">
                        {{ $cat->name }}
                    </a>
                    <span class="badge bg-secondary rounded-pill">{{ $cat->posts_count }}</span>
                </li>
                @endforeach
            </ul>
        </div>

        <!-- About -->
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">À propos</h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    Bienvenue sur mon blog personnel ! Je partage ici mes réflexions, 
                    mes découvertes et mes passions à travers différents articles.
                </p>
            </div>
        </div>
    </div>
</div>

<style>
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
}
</style>
@endsection

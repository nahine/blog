<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Accueil') — {{ config('app.name') }}</title>
    <meta name="description" content="@yield('meta_description', 'Blog personnel — articles, réflexions et découvertes.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}?v=2" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg app-nav sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <span class="brand-badge"><i class="bi bi-journal-richtext"></i></span>
            {{ config('app.name') }}
        </a>

        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door"></i> Accueil
                    </a>
                </li>
                @auth
                    @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.*') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">
                            <i class="bi bi-gear"></i> Administration
                        </a>
                    </li>
                    @endif
                @endauth
            </ul>

            <div class="d-flex align-items-center gap-2">
                @guest
                    <a class="btn btn-sm btn-outline-brand" href="{{ route('login') }}">
                        <i class="bi bi-box-arrow-in-right"></i> Connexion
                    </a>
                    <a class="btn btn-sm btn-brand" href="{{ route('register') }}">
                        <i class="bi bi-person-plus"></i> Inscription
                    </a>
                @else
                    <span class="user-chip">
                        <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                    </span>
                    <form method="POST" action="{{ route('logout') }}" class="m-0">
                        @csrf
                        <button class="btn btn-sm btn-outline-brand">
                            <i class="bi bi-box-arrow-right"></i> Déconnexion
                        </button>
                    </form>
                @endguest
            </div>
        </div>
    </div>
</nav>

<main class="container my-4 my-md-5">
    @yield('content')
</main>

<footer class="app-footer py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-5">
                <h5 class="d-flex align-items-center gap-2">
                    <i class="bi bi-journal-richtext"></i> {{ config('app.name') }}
                </h5>
                <p class="text-secondary mb-0" style="max-width: 24rem;">
                    Un blog personnel pour partager réflexions, découvertes et passions.
                    Merci de votre visite.
                </p>
            </div>
            <div class="col-6 col-md-3">
                <h6 class="mb-3">Navigation</h6>
                <ul class="list-unstyled d-flex flex-column gap-2 mb-0">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    @foreach(\App\Models\Category::limit(4)->get() as $cat)
                    <li><a href="{{ route('categories.show', $cat->slug) }}">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-6 col-md-4">
                <h6 class="mb-3">Suivez-moi</h6>
                <div class="d-flex gap-2">
                    <a href="#" class="social-ic"><i class="bi bi-twitter-x"></i></a>
                    <a href="#" class="social-ic"><i class="bi bi-github"></i></a>
                    <a href="#" class="social-ic"><i class="bi bi-linkedin"></i></a>
                    <a href="#" class="social-ic"><i class="bi bi-envelope"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4" style="border-color: rgba(255,255,255,.1);">
        <div class="text-center text-secondary">
            <small>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</small>
        </div>
    </div>
</footer>

<div class="toast-stack"></div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/blog.js') }}?v=2"></script>
@if(session('success'))
<script>document.addEventListener('DOMContentLoaded',()=>window.blogToast(@json(session('success')),'success'));</script>
@endif
@if(session('error'))
<script>document.addEventListener('DOMContentLoaded',()=>window.blogToast(@json(session('error')),'error'));</script>
@endif
@if(session('status'))
<script>document.addEventListener('DOMContentLoaded',()=>window.blogToast(@json(session('status')),'success'));</script>
@endif
@yield('scripts')
</body>
</html>

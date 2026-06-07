<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Accueil') — {{ config('app.name') }}</title>
    <meta name="description" content="Blog personnel - Découvrez mes articles et réflexions">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        main {
            flex: 1;
        }
        footer {
            background: #212529;
            color: white;
            margin-top: auto;
        }
    </style>
</head>
<body>

<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold fs-4" href="{{ route('home') }}">
            <i class="bi bi-journal-text"></i> {{ config('app.name') }}
        </a>
        
        @guest
        <!-- Boutons visibles TOUJOURS pour les invités -->
        <div class="d-flex gap-2 ms-auto order-lg-2">
            <a class="btn btn-sm btn-outline-light" href="{{ route('login') }}">
                <i class="bi bi-box-arrow-in-right"></i> Connexion
            </a>
            <a class="btn btn-sm btn-light text-dark" href="{{ route('register') }}">
                <i class="bi bi-person-plus"></i> Inscription
            </a>
        </div>
        @else
        <!-- Utilisateur connecté - Bouton déconnexion visible -->
        <div class="d-flex gap-2 ms-auto order-lg-2 align-items-center">
            <span class="text-light d-none d-md-inline">
                <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
            </span>
            @if(auth()->user()->isAdmin())
                <a class="btn btn-sm btn-outline-info" href="{{ route('admin.posts.index') }}">
                    <i class="bi bi-gear"></i> Admin
                </a>
            @endif
            <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                @csrf
                <button class="btn btn-sm btn-danger">
                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                </button>
            </form>
        </div>
        @endguest
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active fw-bold' : '' }}" href="{{ route('home') }}">
                        <i class="bi bi-house-door"></i> Accueil
                    </a>
                </li>
            </ul>
            
            @auth
            <ul class="navbar-nav ms-auto align-items-lg-center gap-2">
                @if(auth()->user()->isAdmin())
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('admin.*') ? 'active fw-bold' : '' }}" 
                            href="{{ route('admin.posts.index') }}">
                            <i class="bi bi-gear"></i> Administration
                        </a>
                    </li>
                @endif
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" 
                        data-bs-toggle="dropdown" id="userDropdown">
                        <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <i class="bi bi-person"></i> Mon Profil
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Déconnexion
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
            @endauth
        </div>
    </div>
</nav>

<!-- Main Content -->
<main class="container my-5">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @yield('content')
</main>

<!-- Footer -->
<footer class="py-4 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h5>{{ config('app.name') }}</h5>
                <p class="text-muted">Blog personnel - Partage de réflexions et de passions</p>
            </div>
            <div class="col-md-3">
                <h6>Liens rapides</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ route('home') }}" class="text-white-50 text-decoration-none">Accueil</a></li>
                    @foreach(\App\Models\Category::limit(3)->get() as $cat)
                    <li><a href="{{ route('categories.show', $cat->slug) }}" class="text-white-50 text-decoration-none">{{ $cat->name }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="col-md-3">
                <h6>Suivez-moi</h6>
                <div class="d-flex gap-3">
                    <a href="#" class="text-white-50"><i class="bi bi-twitter fs-4"></i></a>
                    <a href="#" class="text-white-50"><i class="bi bi-github fs-4"></i></a>
                    <a href="#" class="text-white-50"><i class="bi bi-linkedin fs-4"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4 bg-secondary">
        <div class="text-center text-muted">
            <small>&copy; {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.</small>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Fermer automatiquement les messages de succès/erreur après 5 secondes
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000); // 5 secondes
    });
});
</script>
</body>
</html>

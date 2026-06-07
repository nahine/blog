<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — @yield('title')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('admin.posts.index') }}">
            <i class="bi bi-gear"></i> Admin Blog
        </a>
        <div>
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-light me-2">
                <i class="bi bi-eye"></i> Voir le blog
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button class="btn btn-sm btn-outline-danger">Déconnexion</button>
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 bg-light min-vh-100 pt-3 border-end">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.posts*') ? 'fw-bold text-dark' : 'text-muted' }}"
                        href="{{ route('admin.posts.index') }}">
                        <i class="bi bi-file-text"></i> Articles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'fw-bold text-dark' : 'text-muted' }}"
                        href="{{ route('admin.categories.index') }}">
                        <i class="bi bi-tag"></i> Catégories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.comments*') ? 'fw-bold text-dark' : 'text-muted' }}"
                        href="{{ route('admin.comments.index') }}">
                        <i class="bi bi-chat"></i> Commentaires
                    </a>
                </li>
            </ul>
        </nav>

        <main class="col-md-10 p-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @yield('content')
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Fermer automatiquement les messages de succès après 5 secondes
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert-dismissible');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
});
</script>
</body>
</html>

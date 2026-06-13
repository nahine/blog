<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — @yield('title')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="{{ asset('css/theme.css') }}?v=2" rel="stylesheet">
    <style>
        .admin-sidebar { background: var(--ink-900); min-height: 100vh; }
        .admin-sidebar .nav-link { color: #94a3b8 !important; border-radius: var(--radius-sm); margin-bottom: .25rem; padding: .65rem .9rem; font-weight: 500; transition: all .15s; }
        .admin-sidebar .nav-link:hover { background: rgba(255,255,255,.06); color: #fff !important; }
        .admin-sidebar .nav-link.active { background: var(--gradient); color: #fff !important; box-shadow: var(--shadow); }
        .admin-brand { color:#fff; font-weight:800; }
    </style>
</head>
<body style="background: var(--bg);">
<nav class="navbar app-nav sticky-top">
    <div class="container-fluid px-4">
        <a class="navbar-brand" href="{{ route('admin.posts.index') }}">
            <span class="brand-badge"><i class="bi bi-speedometer2"></i></span> Administration
        </a>
        <div class="d-flex gap-2">
            <a href="{{ route('home') }}" class="btn btn-sm btn-outline-brand">
                <i class="bi bi-eye"></i> Voir le blog
            </a>
            <form method="POST" action="{{ route('logout') }}" class="d-inline m-0">
                @csrf
                <button class="btn btn-sm btn-outline-brand"><i class="bi bi-box-arrow-right"></i> Déconnexion</button>
            </form>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 admin-sidebar pt-4 px-3">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.posts*') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">
                        <i class="bi bi-file-text"></i> Articles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                        <i class="bi bi-tag"></i> Catégories
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.comments*') ? 'active' : '' }}" href="{{ route('admin.comments.index') }}">
                        <i class="bi bi-chat-dots"></i> Commentaires
                    </a>
                </li>
            </ul>
        </nav>

        <main class="col-md-10 p-4">
            @yield('content')
        </main>
    </div>
</div>

<div class="toast-stack"></div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('js/blog.js') }}?v=2"></script>
@if(session('success'))
<script>document.addEventListener('DOMContentLoaded',()=>window.blogToast(@json(session('success')),'success'));</script>
@endif
@if(session('error'))
<script>document.addEventListener('DOMContentLoaded',()=>window.blogToast(@json(session('error')),'error'));</script>
@endif
</body>
</html>

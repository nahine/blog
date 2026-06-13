@extends('layouts.app')
@section('title', 'Vérifiez votre email')

@section('content')
<div class="auth-wrap">
    <div class="col-md-5" style="max-width: 480px;">
        <div class="card auth-card border-0">
            <div class="card-body p-4 p-md-5 text-center">
                <div class="auth-icon mb-3"><i class="bi bi-envelope-check"></i></div>
                <h2 class="mt-2 mb-1">Vérifiez votre email</h2>
                <p class="text-muted">
                    Merci pour votre inscription ! Avant de commencer, veuillez confirmer votre adresse
                    email en cliquant sur le lien que nous venons de vous envoyer.
                    Vous n'avez rien reçu ? Nous pouvons vous renvoyer un autre lien.
                </p>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle"></i> Un nouveau lien de vérification a été envoyé à votre adresse email.
                    </div>
                @elseif (session('status') == 'verification-link-error')
                    <div class="alert alert-warning" role="alert">
                        <i class="bi bi-exclamation-triangle"></i> L'envoi de l'email a échoué pour le moment. Veuillez réessayer dans quelques instants.
                    </div>
                @endif

                <div class="d-flex flex-column gap-2 mt-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <div class="d-grid">
                            <button type="submit" class="btn btn-brand btn-lg">
                                <i class="bi bi-arrow-repeat"></i> Renvoyer l'email de vérification
                            </button>
                        </div>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-muted text-decoration-none">
                            Se déconnecter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

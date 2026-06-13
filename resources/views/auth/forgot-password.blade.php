@extends('layouts.app')
@section('title', 'Mot de passe oublié')

@section('content')
<div class="auth-wrap">
    <div class="col-md-5" style="max-width: 460px;">
        <div class="card auth-card border-0">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="auth-icon mb-3"><i class="bi bi-key"></i></div>
                    <h2 class="mt-2 mb-1">Mot de passe oublié ?</h2>
                    <p class="text-muted">Pas de panique. Indiquez votre email et nous vous enverrons un lien pour le réinitialiser.</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        <i class="bi bi-check-circle"></i> {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email"
                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}" required autofocus
                            placeholder="votre@email.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-brand btn-lg">
                            <i class="bi bi-envelope-paper"></i> Envoyer le lien de réinitialisation
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('login') }}" class="text-decoration-none small">
                            <i class="bi bi-arrow-left"></i> Retour à la connexion
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

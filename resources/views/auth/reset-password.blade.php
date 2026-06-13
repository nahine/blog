@extends('layouts.app')
@section('title', 'Réinitialiser le mot de passe')

@section('content')
<div class="auth-wrap">
    <div class="col-md-5" style="max-width: 460px;">
        <div class="card auth-card border-0">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="auth-icon mb-3"><i class="bi bi-shield-lock"></i></div>
                    <h2 class="mt-2 mb-1">Nouveau mot de passe</h2>
                    <p class="text-muted">Choisissez un nouveau mot de passe pour votre compte.</p>
                </div>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email"
                            class="form-control form-control-lg @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email', $request->email) }}" required autofocus
                            placeholder="votre@email.com">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <div class="pwd-wrap">
                            <input id="password" type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                name="password" required autocomplete="new-password"
                                placeholder="Minimum 8 caractères">
                            <button type="button" class="pwd-toggle" aria-label="Afficher le mot de passe">
                                <i class="bi bi-eye"></i>
                            </button>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <div class="pwd-wrap">
                            <input id="password_confirmation" type="password"
                                class="form-control form-control-lg"
                                name="password_confirmation" required autocomplete="new-password"
                                placeholder="Retapez votre mot de passe">
                            <button type="button" class="pwd-toggle" aria-label="Afficher le mot de passe">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-brand btn-lg">
                            <i class="bi bi-check2-circle"></i> Réinitialiser le mot de passe
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

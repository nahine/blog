@extends('layouts.app')
@section('title', 'Confirmer le mot de passe')

@section('content')
<div class="auth-wrap">
    <div class="col-md-5" style="max-width: 460px;">
        <div class="card auth-card border-0">
            <div class="card-body p-4 p-md-5">
                <div class="text-center mb-4">
                    <div class="auth-icon mb-3"><i class="bi bi-shield-check"></i></div>
                    <h2 class="mt-2 mb-1">Zone sécurisée</h2>
                    <p class="text-muted">Veuillez confirmer votre mot de passe avant de continuer.</p>
                </div>

                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="password" class="form-label">Mot de passe</label>
                        <div class="pwd-wrap">
                            <input id="password" type="password"
                                class="form-control form-control-lg @error('password') is-invalid @enderror"
                                name="password" required autocomplete="current-password" autofocus
                                placeholder="••••••••">
                            <button type="button" class="pwd-toggle" aria-label="Afficher le mot de passe">
                                <i class="bi bi-eye"></i>
                            </button>
                            @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-brand btn-lg">
                            <i class="bi bi-unlock"></i> Confirmer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

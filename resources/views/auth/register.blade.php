@extends('layouts.app')
@section('title', 'Inscription')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-person-plus-fill" style="font-size: 4rem; color: #333;"></i>
                    <h2 class="mt-3 mb-2">Inscription</h2>
                    <p class="text-muted">Créez votre compte gratuitement</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nom complet</label>
                        <input id="name" type="text" 
                            class="form-control form-control-lg @error('name') is-invalid @enderror" 
                            name="name" value="{{ old('name') }}" 
                            required autofocus autocomplete="name"
                            placeholder="GBABLI Nahine">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" 
                            class="form-control form-control-lg @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" 
                            required autocomplete="username"
                            placeholder="votre@email.com">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input id="password" type="password" 
                            class="form-control form-control-lg @error('password') is-invalid @enderror" 
                            name="password" required autocomplete="new-password"
                            placeholder="Minimum 8 caractères">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-4">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input id="password_confirmation" type="password" 
                            class="form-control form-control-lg" 
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Retapez votre mot de passe">
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark btn-lg">
                            <i class="bi bi-person-plus"></i> Créer mon compte
                        </button>
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-0">Vous avez déjà un compte ?
                            <a href="{{ route('login') }}" class="text-decoration-none fw-bold">
                                Se connecter
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

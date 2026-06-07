@extends('layouts.app')
@section('title', 'Connexion')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card shadow-lg border-0">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <i class="bi bi-person-circle" style="font-size: 4rem; color: #333;"></i>
                    <h2 class="mt-3 mb-2">Connexion</h2>
                    <p class="text-muted">Connectez-vous à votre compte</p>
                </div>

                @if (session('status'))
                    <div class="alert alert-success mb-4" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" type="email" 
                            class="form-control form-control-lg @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" 
                            required autofocus autocomplete="username"
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
                            name="password" required autocomplete="current-password"
                            placeholder="••••••••">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Remember Me -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                        <label class="form-check-label" for="remember_me">
                            Se souvenir de moi
                        </label>
                    </div>

                    <!-- Submit Button -->
                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-dark btn-lg">
                            <i class="bi bi-box-arrow-in-right"></i> Se connecter
                        </button>
                    </div>

                    <!-- Links -->
                    <div class="text-center">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-decoration-none small">
                                Mot de passe oublié ?
                            </a>
                        @endif
                    </div>

                    <hr class="my-4">

                    <div class="text-center">
                        <p class="mb-0">Pas encore de compte ?
                            <a href="{{ route('register') }}" class="text-decoration-none fw-bold">
                                S'inscrire
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

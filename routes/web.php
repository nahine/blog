<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\Admin;

// Routes publiques
Route::get('/', [PostController::class, 'index'])->name('home');
Route::get('/posts/{slug}', [PostController::class, 'show'])->name('posts.show');
Route::get('/categories/{slug}', [PostController::class, 'byCategory'])->name('categories.show');

// Routes connectés
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->isAdmin()) {
            return redirect()->route('admin.posts.index');
        }
        return redirect()->route('home');
    })->name('dashboard');
    
    // Interagir (aimer / commenter) exige un email vérifié.
    Route::middleware('verified')->group(function () {
        Route::post('/posts/{post}/like', [LikeController::class, 'toggle'])->name('posts.like');
        Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
        Route::post('/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comments.reply');
    });
});

// Routes admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn() => redirect()->route('admin.posts.index'));

    Route::resource('posts', Admin\PostController::class);
    Route::resource('categories', Admin\CategoryController::class);

    Route::get('comments', [Admin\CommentController::class, 'index'])->name('comments.index');
    Route::delete('comments/{comment}', [Admin\CommentController::class, 'destroy'])->name('comments.destroy');
});

// Route temporaire et protégée pour réinitialiser le contenu en production.
// Active uniquement si la variable d'environnement SETUP_KEY est définie.
// Visiter /__setup/VOTRE_CLE une seule fois, puis SUPPRIMER SETUP_KEY.
Route::get('/__setup/{key}', function (string $key) {
    abort_unless(filled(config('app.setup_key')) && hash_equals((string) config('app.setup_key'), $key), 404);

    // Reconstruit entièrement le schéma (en français) puis insère le contenu.
    Artisan::call('migrate:fresh', [
        '--force' => true,
        '--seed'  => true,
    ]);

    return response(
        "✅ Base de données réinitialisée (schéma en français) et contenu recréé.\n\n"
        . "Admin : combarinahine@gmail.com / password\n\n"
        . "⚠️ IMPORTANT : supprimez maintenant la variable SETUP_KEY dans Railway pour désactiver cette page.",
        200
    )->header('Content-Type', 'text/plain; charset=utf-8');
})->name('setup');

require __DIR__.'/auth.php';

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {
    use Notifiable;

    protected $table = 'utilisateurs';

    protected $fillable = ['nom', 'email', 'password', 'role'];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = ['email_verified_at' => 'datetime', 'password' => 'hashed'];

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function posts() {
        return $this->hasMany(Post::class, 'utilisateur_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'utilisateur_id');
    }

    public function likes() {
        return $this->hasMany(Like::class, 'utilisateur_id');
    }
}

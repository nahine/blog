<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Post extends Model {
    protected $table = 'articles';

    protected $fillable = [
        'titre',
        'slug',
        'contenu',
        'extrait',
        'image',
        'categorie_id',
        'utilisateur_id',
        'publie_le'
    ];

    protected $casts = [
        'publie_le' => 'datetime'
    ];

    protected $appends = ['image_url', 'reading_time'];

    // Relations
    public function user() {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function category() {
        return $this->belongsTo(Category::class, 'categorie_id');
    }

    public function comments() {
        return $this->hasMany(Comment::class, 'article_id')->whereNull('parent_id')->with('replies.user')->latest();
    }

    public function likes() {
        return $this->hasMany(Like::class, 'article_id');
    }

    // Accesseurs
    public function getImageUrlAttribute(): ?string {
        if (!$this->image) {
            return asset('images/default-post.svg');
        }

        // Photo externe (ex: Unsplash) : on l'utilise telle quelle
        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        // Si l'image est dans public/images/ (fichiers SVG par défaut)
        if (str_starts_with($this->image, 'images/')) {
            return asset($this->image);
        }
        
        // Si l'image est uploadée dans storage
        return Storage::disk('public')->exists($this->image) 
            ? Storage::url($this->image)
            : asset('images/default-post.svg');
    }

    public function getReadingTimeAttribute(): int {
        $words = str_word_count(strip_tags($this->contenu));
        return max(1, ceil($words / 200)); // 200 mots par minute
    }

    public function getExtraitAttribute($value): string {
        return $value ?? \Illuminate\Support\Str::limit(strip_tags($this->contenu), 150);
    }

    // Méthodes
    public function isLikedBy(?User $user): bool {
        if (!$user) return false;
        return $this->likes()->where('utilisateur_id', $user->id)->exists();
    }

    public function isPublished(): bool {
        return $this->publie_le !== null && $this->publie_le->isPast();
    }

    // Scopes
    public function scopePublished($query) {
        return $query->whereNotNull('publie_le')
                    ->where('publie_le', '<=', now())
                    ->orderBy('publie_le', 'desc');
    }

    public function scopeWithCounts($query) {
        return $query->withCount(['comments', 'likes']);
    }

    // Events
    protected static function boot() {
        parent::boot();

        static::deleting(function ($post) {
            // Supprimer l'image lors de la suppression du post
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
        });
    }
}

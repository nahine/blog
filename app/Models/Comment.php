<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model {
    protected $table = 'commentaires';

    protected $fillable = ['article_id', 'utilisateur_id', 'parent_id', 'contenu'];

    public function user() {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function post() {
        return $this->belongsTo(Post::class, 'article_id');
    }

    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id')->with('user')->latest();
    }

    public function parent() {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
}

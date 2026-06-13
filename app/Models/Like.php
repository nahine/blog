<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model {
    protected $table = 'jaimes';

    protected $fillable = ['utilisateur_id', 'article_id'];

    public function user() {
        return $this->belongsTo(User::class, 'utilisateur_id');
    }

    public function post() {
        return $this->belongsTo(Post::class, 'article_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    protected $table = 'categories';

    protected $fillable = ['nom', 'slug'];

    public function posts() {
        return $this->hasMany(Post::class, 'categorie_id');
    }
}

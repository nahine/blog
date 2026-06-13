<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class PostController extends Controller {

    public function index() {
        $posts = Post::published()
            ->with(['user', 'category'])
            ->withCount(['likes', 'comments'])
            ->paginate(12);
        
        $categories = Category::withCount('posts')->get();
        $featured = Post::published()
            ->withCount(['likes', 'comments'])
            ->orderBy('likes_count', 'desc')
            ->limit(3)
            ->get();
        
        return view('posts.index', compact('posts', 'categories', 'featured'));
    }

    public function show(string $slug) {
        $post = Post::published()
            ->with(['user', 'category', 'comments.user', 'comments.replies.user'])
            ->withCount(['likes', 'comments'])
            ->where('slug', $slug)
            ->firstOrFail();
        
        // Articles similaires (même catégorie)
        $relatedPosts = Post::published()
            ->where('categorie_id', $post->categorie_id)
            ->where('id', '!=', $post->id)
            ->withCount(['likes', 'comments'])
            ->limit(3)
            ->get();
        
        return view('posts.show', compact('post', 'relatedPosts'));
    }

    public function byCategory(string $slug) {
        $category = Category::where('slug', $slug)->firstOrFail();
        $posts = Post::published()
            ->where('categorie_id', $category->id)
            ->with(['user', 'category'])
            ->withCount(['likes', 'comments'])
            ->paginate(12);
        
        $categories = Category::withCount('posts')->get();
        
        return view('posts.index', compact('posts', 'category', 'categories'));
    }
}

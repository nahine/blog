<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller {

    public function index() {
        $posts = Post::with(['category', 'user'])
            ->withCount(['likes', 'comments'])
            ->latest()
            ->paginate(15);
        
        return view('admin.posts.index', compact('posts'));
    }

    public function create() {
        $categories = Category::all();
        return view('admin.posts.create', compact('categories'));
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'title'       => 'required|max:255',
            'content'     => 'required|min:50',
            'excerpt'     => 'nullable|max:500',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Gérer l'upload de l'image
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }

        Post::create([
            'title'        => $validated['title'],
            'slug'         => Str::slug($validated['title']) . '-' . uniqid(),
            'content'      => $validated['content'],
            'excerpt'      => $validated['excerpt'] ?? null,
            'image'        => $imagePath,
            'category_id'  => $validated['category_id'],
            'user_id'      => auth()->id(),
            'published_at' => $request->has('publish') ? now() : null,
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', '✅ Article créé avec succès.');
    }

    public function edit(Post $post) {
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories'));
    }

    public function update(Request $request, Post $post) {
        $validated = $request->validate([
            'title'       => 'required|max:255',
            'content'     => 'required|min:50',
            'excerpt'     => 'nullable|max:500',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Gérer l'upload de la nouvelle image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($post->image && Storage::disk('public')->exists($post->image)) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title'        => $validated['title'],
            'content'      => $validated['content'],
            'excerpt'      => $validated['excerpt'] ?? $post->excerpt,
            'image'        => $validated['image'] ?? $post->image,
            'category_id'  => $validated['category_id'],
            'published_at' => $request->has('publish') ? ($post->published_at ?? now()) : null,
        ]);

        return redirect()->route('admin.posts.index')
            ->with('success', '✅ Article mis à jour avec succès.');
    }

    public function destroy(Post $post) {
        // L'image sera supprimée automatiquement par l'événement boot() du modèle
        $post->delete();
        
        return back()->with('success', '🗑️ Article supprimé avec succès.');
    }
}

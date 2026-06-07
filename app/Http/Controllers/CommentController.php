<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller {

    public function store(Request $request, Post $post) {
        $request->validate(['body' => 'required|min:2|max:1000']);

        $post->comments()->create([
            'user_id' => auth()->id(),
            'body'    => $request->body,
        ]);

        // Return JSON for AJAX requests
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Commentaire ajouté avec succès !'
            ]);
        }

        return back()->with('success', 'Commentaire ajouté.');
    }

    public function reply(Request $request, Comment $comment) {
        $request->validate(['body' => 'required|min:2|max:1000']);

        Comment::create([
            'post_id'   => $comment->post_id,
            'user_id'   => auth()->id(),
            'parent_id' => $comment->id,
            'body'      => $request->body,
        ]);

        // Return JSON for AJAX requests
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Réponse ajoutée avec succès !'
            ]);
        }

        return back()->with('success', 'Réponse ajoutée.');
    }
}

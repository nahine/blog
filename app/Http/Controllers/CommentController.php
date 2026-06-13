<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller {

    public function store(Request $request, Post $post) {
        $request->validate(['body' => 'required|min:2|max:1000']);

        $comment = $post->comments()->create([
            'user_id' => auth()->id(),
            'body'    => $request->body,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            $comment->load('user', 'replies.user');
            return response()->json([
                'success'        => true,
                'message'        => 'Commentaire publié avec succès !',
                'comments_count' => Comment::where('post_id', $post->id)->whereNull('parent_id')->count(),
                'html'           => view('posts._comment', ['comment' => $comment])->render(),
            ]);
        }

        return back()->with('success', 'Commentaire ajouté.');
    }

    public function reply(Request $request, Comment $comment) {
        $request->validate(['body' => 'required|min:2|max:1000']);

        $reply = Comment::create([
            'post_id'   => $comment->post_id,
            'user_id'   => auth()->id(),
            'parent_id' => $comment->id,
            'body'      => $request->body,
        ]);

        if ($request->wantsJson() || $request->ajax()) {
            $reply->load('user');
            return response()->json([
                'success'        => true,
                'message'        => 'Réponse publiée avec succès !',
                'comments_count' => Comment::where('post_id', $comment->post_id)->whereNull('parent_id')->count(),
                'html'           => view('posts._reply', ['reply' => $reply])->render(),
            ]);
        }

        return back()->with('success', 'Réponse ajoutée.');
    }
}

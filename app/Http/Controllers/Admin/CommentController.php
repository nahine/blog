<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;

class CommentController extends Controller {

    public function index() {
        $comments = Comment::with(['user', 'post'])->latest()->paginate(20);
        return view('admin.comments.index', compact('comments'));
    }

    public function destroy(Comment $comment) {
        $comment->delete();
        return back()->with('success', 'Commentaire supprimé.');
    }
}

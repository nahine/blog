<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Like;
use Illuminate\Http\Request;

class LikeController extends Controller {

    public function toggle(Request $request, Post $post) {
        $existing = Like::where('user_id', auth()->id())
                        ->where('post_id', $post->id)
                        ->first();

        $liked = false;
        if ($existing) {
            $existing->delete();
            $liked = false;
        } else {
            Like::create([
                'user_id' => auth()->id(),
                'post_id' => $post->id,
            ]);
            $liked = true;
        }

        // Return JSON for AJAX requests
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $post->likes()->count()
            ]);
        }

        return back();
    }
}

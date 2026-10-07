<?php

namespace App\Http\Controllers;

use App\Models\Comment;

use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request) {

        $inputs=request()->validate([
            'body'=>'required|max:1000',
        ]);

        $comment=Comment::create([
            'body'=>$inputs['body'],
            'user_id'=>auth()->user()->id,
            'post_id'=>$request->post_id
        ]);

        return back();
    }

    public function destroy(Post $post)
    {        
        $post->comments()->delete();
        $post->delete();
        return redirect()->route('post.index')->with('message', '投稿を削除しました');
    }
}

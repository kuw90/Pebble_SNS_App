<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\Like;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function likePost(Post $post) {

        // ログインユーザーのidを取得
        $user_id = Auth::id();

        // ログインユーザーがその投稿をいいねしているレコードを取得
        $liked_post = $post->likes()->where('user_id', $user_id);

        // 既に「いいね」しているか確認
        if (!$liked_post->exists()) {

            //「いいね」していない場合は，likesテーブルにレコードを追加
            $like = new Like();
            $like->user_id = $user_id;
            $like->post_id = $post->id;
            $like->save();
        } else {
            // 既に「いいね」をしていた場合は，likesテーブルからレコードを削除     
            $liked_post->delete();
        }

        // いいねの数を取得
        $likes_count = $post->likes->count();

    
        $param = [
            'likes_count' => $likes_count, // いいねの数
        ];

        // フロントにいいねの数を返す
        return response()->json([
            'likesCount' => $likes_count
        ]);
    }
}

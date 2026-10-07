<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;

class AdminUserController
{
    public function index()
    {
        return view('post.user-list', [
            'users' => User::all(),
        ]);
    }

    public function destroy($id)
    {
        User::findOrFail($id)->delete();

        return redirect()->route('admin.users')
            ->with('message', 'ユーザーを削除しました');
    }

public function posts()
{
    $posts = Post::with('user')->latest()->get();

    return view('post.user-post', compact('posts'));
}
}

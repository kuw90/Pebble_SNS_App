<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
// 追加
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts=Post::orderBy('created_at','desc')->get();
        $user=auth()->user();

        //管理者(rolesテーブルのnameがadminの時)の場合の処理
        if ($user->roles()->where('name', 'admin')->exists()) {
            return redirect()->route('admin.users');
        }
        
        return view('post.index',compact('posts','user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs=$request->validate([
            'title'=>'required|max:255',
            'body'=>'required|max:1000',
            'image'=>'image|max:1024',
        ]);
        $post=new Post();
        $post->title=$request->title;
        $post->body=$request->body;
        $post->user_id=auth()->user()->id;
        if (request('image')){
            // $nameを$originalに変更
            $original = request()->file('image')->getClientOriginalName();
            // 名前に日時追加
            $name = date('Ymd_His').'_'.$original;
            request()->file('image')->move('storage/images', $name);
            $post->image = $name;
        }
        $post->save();

        return redirect()->route('post.index')->with('message', '投稿を作成しました');
    }
    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('post.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (Gate::allows('post-owner', $post)) {
            // 認可に成功した場合の処理
            return view('post.edit', compact('post'));
        } else {
            // 認可に失敗した場合の処理
            abort(403, 'Unauthorized action.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        Gate::authorize('post-owner', $post);
        $inputs=$request->validate([
            'title'=>'required|max:7',
            'body'=>'required|max:100',
            'image'=>'image|max:4096',
        ]);

        $post->title=$inputs['title'];
        $post->body=$inputs['body'];

        if (request('image')){
            // $nameを$originalに変更
            $original = request()->file('image')->getClientOriginalName();
            // 名前に日時追加
            $name = date('Ymd_His').'_'.$original;
            request()->file('image')->move('storage/images', $name);
            $post->image = $name;
        }

        $post->save();

        return redirect()->route('post.show', $post)->with('message', '投稿を更新しました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        $user=auth()->user();
        
        if (Gate::allows('post-owner', $post) || Gate::allows('admin')) {
            $post->delete();

            // 管理者なら管理画面へ
            if ($user->roles()->where('name', 'admin')->exists()) {
                return redirect()->route('admin.posts')->with('message', '投稿を削除しました');
            }
            // 一般ユーザーなら投稿一覧へ
                return redirect()->route('post.index')->with('message', '投稿を削除しました');
            } else {
            abort(403, 'Unauthorized action.');
        }

    }

    public function mypost() {
        $user=auth()->user()->id;
        $posts=Post::where('user_id', $user)->get();
        return view('post.mypost', compact('posts'));
    }
}

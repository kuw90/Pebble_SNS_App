<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AdminUserController;

Route::view('/', 'welcome')->name('home');

// ゲストログイン（ログイン前に使うので auth グループの外）
Route::post('/guest-login', function () {
    $user = User::firstOrCreate(
        ['email' => 'guest@example.com'],
        ['name' => 'ゲスト', 'password' => Hash::make(Str::random(32))]
    );

    Auth::login($user);
    request()->session()->regenerate();

    return redirect()->route('post.index');
})->middleware('guest')->name('guest.login');

// Route::middleware(['auth', 'verified'])->group(function () {
//     Route::view('dashboard', 'dashboard')->name('dashboard');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/post', function () {
    });
    
    Route::get('post/mypost', [PostController::class, 'mypost'])->name('post.mypost');
    Route::resource('post', PostController::class);

    Route::resource('post', PostController::class)
        ->only(['edit', 'update'])->middleware(['can:post-owner,post']);
    
    Route::post('post/comment/store', [CommentController::class, 'store'])->name('comment.store');

    Route::post('/post/{post}/like', [LikeController::class, 'likePost'])->middleware("auth");

    // 追加
    Route::middleware(['auth', 'can:admin'])->group(function () {
        Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users');
        Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.delete');
        Route::get('/admin/posts', [AdminUserController::class, 'posts'])
            ->name('admin.posts');
    });
});

require __DIR__.'/settings.php';
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\AdminUserController;

Route::view('/', 'welcome')->name('home');

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

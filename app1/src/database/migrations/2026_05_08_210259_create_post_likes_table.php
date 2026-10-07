<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('likes', function (Blueprint $table) {
            // constrainedの第一引数は参照するテーブル名．
            // 何も指定しない場合は外部キー(foreignId)から自動で推測される．
            $table->foreignId('user_id')->constrained("users")->onDelete('cascade');
            $table->foreignId('post_id')->constrained("posts")->onDelete('cascade');
            // 主キーをuser_idとpost_idの組み合わせにする
            $table->primary(['user_id', 'post_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_likes');
    }
};

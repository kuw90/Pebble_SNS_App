<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    // リレーション (Like belongs to a Post)
    public function post()
    {
	    return $this->belongsTo(Post::class);
    }

    // リレーション (Like belongs to a User)
    public function user()
    {
	    return $this->belongsTo(User::class);
    }
}

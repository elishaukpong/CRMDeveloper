<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_id', 'user_id', 'message'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commentator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }
}

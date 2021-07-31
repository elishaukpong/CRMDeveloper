<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['title', 'content', 'user_id'];


    /**
     * @return int
     *
     * In the case of a proper system, there should be a PostView model that captures which user has already viewed the
     * post so we do not keep incrementing the views column when one user views repeatedly.
     */
    public function recordViewership()
    {
        //todo check if user has not viewed previously and increment,
        // else do not increment

        return $this->increment('views');
    }

    public function creator()
    {
        return $this->belongsTo(User::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Post extends Model
{
    /**
     * @var string[]
     */
    protected $fillable = ['title', 'content', 'user_id','views','likes'];

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

    /**
     * @return int
     *
     * In the case of a proper system, there should be a Like Morph model that captures which user has already liked the
     * post so we do not keep incrementing the likes column when one user likes repeatedly. I choose Morph so that we can
     * also choose to add the like feature to another model type in the future
     */
    public function recordLike()
    {
        //todo check if user has not liked previously and increment,
        // else do not increment

        return $this->increment('likes');
    }

    /**
     * @param array $data
     * @return Model
     */
    public function recordComment(array $data)
    {
        return $this->comments()->create([
            'user_id' => $data['user_id'],
            'message' => $data['message']
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}

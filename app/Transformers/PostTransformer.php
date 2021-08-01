<?php

namespace App\Transformers;

use App\Post;
use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'creator','comments'
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        //
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'content' => $post->content,
            'views' => $post->views ?? 0,
            'likes' => $post->likes ?? 0,
            'created_at' => $post->created_at->format('d-m-Y')
        ];
    }

    public function includeCreator(Post $post)
    {
        return $this->item($post->creator, new UserTransformer);
    }

    public function includeComments(Post $post)
    {
        return $this->collection($post->comments, new CommentTransformer);
    }

    public function customTransformSingleModel($data)
    {
        return [
            $this->transform($data),
        ];
    }
}

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Transformers\CommentTransformer;
use App\Transformers\PostTransformer;
use App\User;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Data Retrieved', 'data' =>$this->transformObject(Post::all(), new PostTransformer())]);
    }

    public function add(PostRequest $request)
    {
        $post = Post::create($request->all());

        return response()->json(['message' => 'Post created successfully', 'data' => $this->transformObject(collect([$post]), new PostTransformer())]);
    }

    public function view($postId)
    {
        $post = Post::findOrFail($postId);

        if(auth()->user()->can('view articles'))
            $post->recordViewership();

        return response()->json(['message' => 'Post Retrieved Successfully', 'data' => $this->transformObject(collect([$post]), new PostTransformer())]);
    }

    public function like($postId)
    {
        $post = Post::findOrFail($postId);

        if(! auth()->user()->can('like articles'))
            return response()->json(['message' => 'Post Can Only be liked by Reader'],403);

        $post->recordLike();

        return response()->json(['message' => 'Post Retrieved Successfully', 'data' => $this->transformObject(collect([$post]), new PostTransformer())]);
    }

    public function comment(CommentRequest $request)
    {
        $post = Post::findOrFail($request->post_id);

        $comment = $post->recordComment($request->all());

        return response()->json(['message' => 'Post has been commented on Successfully', 'data' => $this->transformObject(collect([$comment]), new CommentTransformer())]);
    }


}

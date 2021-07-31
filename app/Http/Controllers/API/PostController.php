<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PostRequest;
use App\Post;
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
        $user = User::findOrFail($request->user_id);

        if(! $user->hasRole('Writer')){
            return response()->json(['message' => 'You must be a writer to make posts.'], 403);
        }

        $post = Post::create($request->all());

        return response()->json(['message' => 'Post created successfully', 'data' => $this->transformObject($post, new PostTransformer())]);
    }

    public function view($postId)
    {
        $post = Post::find($postId);

        if(! $post){
            return response()->json(['message' => 'Post record does not exist'],404);
        }

        if(auth()->user()->can('view articles'))
            $post->recordViewership();

        return response()->json(['message' => 'Post Retrieved Successfully', 'data' => $this->transformObject($post, new PostTransformer())]);
    }

    public function like($postId)
    {
        $post = Post::find($postId);

        if(! $post){
            return response()->json(['message' => 'Post record does not exist'],404);
        }

        if(auth()->user()->can('like articles'))
            $post->recordLike();

        return response()->json(['message' => 'Post Retrieved Successfully', 'data' => $this->transformObject($post, new PostTransformer())]);
    }

    public function comment(CommentRequest $request)
    {
        $post = Post::findOrFail($request->post_id);

        $post->recordComment($request->all());

        return response()->json(['message' => 'Post has been commented on Successfully', 'data' => $this->transformObject($post, new PostTransformer())]);
    }


}

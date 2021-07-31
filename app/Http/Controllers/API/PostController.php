<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Post;
use App\Transformers\PostTransformer;
use App\User;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Data Retrieved', 'data' =>Post::all()->transformWith(new PostTransformer())]);
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

        $post->recordViewership();

        return response()->json(['message' => 'Post Retrieved Successfully', 'data' => $this->transformObject($post, new PostTransformer())]);
    }

    public function like($postId)
    {
        $post = Post::find($postId);

        if(! $post){
            return response()->json(['message' => 'Post record does not exist'],404);
        }

        $post->recordLike();

        return response()->json(['message' => 'Post Retrieved Successfully', 'data' => $this->transformObject($post, new PostTransformer())]);
    }

    public function comment($postId)
    {
        $post = Post::find($postId);

        if(! $post){
            return response()->json(['message' => 'Post record does not exist'],404);
        }

        $post->recordViewership();

        return response()->json(['message' => 'Post Retrived Successfully', 'data' => $this->transformObject($post, new PostTransformer())]);
    }


}

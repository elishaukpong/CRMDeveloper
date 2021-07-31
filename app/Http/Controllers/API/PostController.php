<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Post;
use App\Transformers\PostTransformer;

class PostController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Data Retrieved', 'data' =>Post::all()->transformWith(new PostTransformer())]);
    }
}

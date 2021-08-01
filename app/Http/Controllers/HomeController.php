<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function allUsers()
    {
        return view('users.index');
    }

    public function createUser()
    {
        return view('users.create');
    }

    public function changeUserRole()
    {
        return view('users.changerole');
    }

    public function writerIndex()
    {
        return view('writer');
    }

    public function allPosts()
    {
        return view('posts.index');
    }

    public function viewPosts()
    {
        return view('posts.show');
    }

    public function createPost()
    {
        return view('posts.create');
    }

    public function readerIndex()
    {
        return view('reader');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

//import Model "Post"
use App\Models\Post;

class PostController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $posts = Post::latest()->get();

        return response()
            ->view('app/photogps/index', [
                "posts" => $posts
            ], 200);
    }
}

<?php

namespace App\Http\Controllers;

//import Model "Post"
use App\Models\Post;
use Illuminate\Support\Facades\DB;

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
        $photographers = DB::table('posts')->select('photographer as name', 'photographer_username as code')->distinct()->get();

        return response()
            ->view('app/photogps/index', [
                'photographers' => $photographers
            ], 200);
    }
}

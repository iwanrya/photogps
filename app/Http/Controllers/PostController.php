<?php

namespace App\Http\Controllers;

//import Model "Post"
use App\Models\Post;
use App\Models\User;
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
        // $photographers = DB::table('posts')->select('photographer as name', 'photographer_username as code')->distinct()->get();
        $photographers = User::select('name', 'username as code')->orderBy('username')->get();

        return response()
            ->view('app/photogps/index', [
                'photographers' => $photographers
            ], 200);
    }
}

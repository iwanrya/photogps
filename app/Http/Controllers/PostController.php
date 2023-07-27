<?php

namespace App\Http\Controllers;

//import Model "Post"

use App\Core\App;
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
        $photographers = User::select('name', 'username', 'id as code')->orderBy('username')->get();

        return response()
            ->view('app/photogps/index', [
                'photographers' => $photographers
            ], 200);
    }

    public function original_image(string $id)
    {
        $post = Post::find($id);

        if ($post) {
            $this->showImage(App::photo_mobile_original_file_location() . $post->getRawOriginal('image'));
        } else {
            return response('', 404);
        }
    }

    private function showImage($file)
    {
        $imginfo = getimagesize($file);
        header("Content-type: {$imginfo['mime']}");
        readfile($file);
    }
}

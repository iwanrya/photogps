<?php

namespace App\Http\Controllers;

use App\Core\App;
use App\Models\PostPhoto;
use Illuminate\Http\Request;

class PostPhotoController extends Controller
{

    public function original_image(string $id)
    {
        $post = PostPhoto::find($id);

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

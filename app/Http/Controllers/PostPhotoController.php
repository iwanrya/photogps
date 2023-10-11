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

    public function resize(string $id, int $width, int $height) {
        $post = PostPhoto::find($id);

        if ($post) {
            $file_src = App::photo_mobile_original_file_location() . $post->getRawOriginal('image');
            $src = imagecreatefromstring(file_get_contents($file_src));

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

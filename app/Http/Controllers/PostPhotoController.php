<?php

namespace App\Http\Controllers;

use App\Core\App;
use App\Core\general\image\DuplicateImage;
use App\Models\PostPhoto;
use Exception;
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

    public function resize(string $id, string $maxDim)
    {
        try {
            $post = PostPhoto::find($id);

            if ($post) {

                $image_name = $post->getRawOriginal('image');

                $filepath_src = App::photo_mobile_noexif_file_location() . $image_name;

                if (!file_exists($filepath_src)) {
                    throw new Exception();
                }
                
                $filepath_desc = App::photo_mobile_custom_size_file_location($maxDim) . $image_name;

                if (!is_dir(App::photo_mobile_custom_size_file_location($maxDim))) {
                    mkdir(App::photo_mobile_custom_size_file_location($maxDim), 0777, true);
                }

                if (!file_exists($filepath_desc)) {
                    DuplicateImage::create_photo_thumbnail($filepath_src, $filepath_desc, 0, $maxDim);
                }

                $this->showImage($filepath_desc);
            } else {
                return response('', 404);
            }
        } catch (Exception $ex) {
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

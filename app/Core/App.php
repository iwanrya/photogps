<?php

namespace App\Core;

use Illuminate\Support\Facades\File;

final class App
{
    static $allowed_custom_size = array(300, 500, 700);

    static public function photo_mobile_noexif_file_location()
    {
        $path = storage_path("app/public/posts/");
        File::makeDirectory($path, $mode = 0777, true, true);

        return $path;
    }

    static public function photo_mobile_thumbnail_file_location()
    {
        $path = storage_path("app/public/thumbnail/posts/");
        File::makeDirectory($path, $mode = 0777, true, true);

        return $path;
    }

    static public function photo_mobile_custom_size_file_location($custom_size)
    {
        $custom_size = intval($custom_size);
        if (!in_array($custom_size, self::$allowed_custom_size)) {
            $custom_size = 300;
        }
        $path = storage_path("app/public/custom_size/posts/{$custom_size}/");
        File::makeDirectory($path, $mode = 0777, true, true);

        return $path;
    }

    static public function photo_mobile_original_file_location()
    {
        $path = storage_path("app/private/posts/");
        File::makeDirectory($path, $mode = 0777, true, true);
        return $path;
    }

    static public function temp_download_folder()
    {
        $path = storage_path("app/private/temp/download/");
        File::makeDirectory($path, $mode = 0777, true, true);
        return $path;
    }
}

<?php

namespace App\Core;

final class App
{

    static public function photo_mobile_noexif_file_location()
    {
        return storage_path('app/public/posts/');
    }

    static public function photo_mobile_thumbnail_file_location()
    {
        return storage_path('app/public/thumbnail/posts/');
    }

    static public function photo_mobile_original_file_location()
    {
        return storage_path('app/private/posts/');
    }

    static public function temp_download_folder()
    {
        return storage_path('app/private/temp/download/');
    }
}

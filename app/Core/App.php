<?php

namespace App\Core;

final class App {

    static public function photo_mobile_noexif_file_location() {
        return storage_path('app/public/posts/');
    }

    static public function photo_mobile_thumbnail_file_location() {
        return storage_path('app/public/thumbnail/posts/');
    }
    
}
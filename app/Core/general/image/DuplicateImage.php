<?php

namespace App\Core\general\image;

use App\Core\App;

class DuplicateImage
{

    static function duplicate_photo($file, $file_name, $rotation)
    {
        if (!is_dir(App::photo_mobile_noexif_file_location())) {
            mkdir(App::photo_mobile_noexif_file_location(), 0777, true);
        }
        if (!is_dir(App::photo_mobile_thumbnail_file_location())) {
            mkdir(App::photo_mobile_thumbnail_file_location(), 0777, true);
        }

        $file_noexif_dir = App::photo_mobile_noexif_file_location() . $file_name;
        $file_thumbnail_dir = App::photo_mobile_thumbnail_file_location() . $file_name;
        // copy without exif data
        self::create_photo_withno_exif($file, $file_noexif_dir, $rotation);

        // copy as thumbnail without exif data
        self::create_photo_thumbnail($file, $file_thumbnail_dir, $rotation);
    }

    static function create_photo_withno_exif($file_src, $file_dst, $rotation = 0)
    {
        $img_info = getimagesize($file_src);

        $width = $img_info[0];
        $height = $img_info[1];

        $src = imagecreatefromstring(file_get_contents($file_src));
        $dst = imagecreatetruecolor($width, $height);

        imagecopyresampled($dst, $src, 0, 0, 0, 0, $width, $height, $width, $height);
        imagedestroy($src);

        if ($rotation != 0) {
            $dst = imagerotate($dst, $rotation, 0);
        }

        imagejpeg($dst, $file_dst);
        imagedestroy($dst);
    }

    /**
     * @param String $file_src file source path
     * @param String $file_dst file destination path
     */
    static function create_photo_thumbnail($file_src, $file_dst, $rotation = 0)
    {
        $maxDim = 100;

        $img_info = getimagesize($file_src);

        $width = $img_info[0];
        $height = $img_info[1];

        if ($width > $maxDim || $height > $maxDim) {
            $ratio = $width / $height;
            if ($ratio > 1) {
                $new_width = $maxDim;
                $new_height = $maxDim / $ratio;
            } else {
                $new_width = $maxDim * $ratio;
                $new_height = $maxDim;
            }

            $src = imagecreatefromstring(file_get_contents($file_src));
            $dst = imagecreatetruecolor($new_width, $new_height);

            imagecopyresampled($dst, $src, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
            imagedestroy($src);

            if ($rotation != 0) {
                $dst = imagerotate($dst, $rotation, 0);
            }

            imagejpeg($dst, $file_dst);
            imagedestroy($dst);
        }
    }
}
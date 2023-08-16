<?php

namespace App\Core\general\image;

use App\Core\general\GPSLocation;
use Exception;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTag;

class ExifImage
{

    static function get_image_location($image = '')
    {
        try {
            $jpeg = new PelJpeg($image);

            $exif = $jpeg->getExif();

            if ($exif !== null) {

                $tiff = $exif->getTiff();

                if ($tiff !== null) {

                    $ifd0 = $tiff->getIfd();

                    if ($ifd0 !== null) {

                        $gps_ifd = $ifd0->getSubIfd(PelIfd::GPS);

                        if ($gps_ifd !== null) {
                            
                            if (
                                $gps_ifd->getEntry(PelTag::GPS_LATITUDE_REF) !== null 
                                && $gps_ifd->getEntry(PelTag::GPS_LATITUDE) !== null
                                && $gps_ifd->getEntry(PelTag::GPS_LONGITUDE_REF) !== null
                                && $gps_ifd->getEntry(PelTag::GPS_LONGITUDE) !== null

                                && $gps_ifd->getEntry(PelTag::GPS_LATITUDE_REF)->getValue() !== null 
                                && $gps_ifd->getEntry(PelTag::GPS_LATITUDE)->getValue() !== null
                                && $gps_ifd->getEntry(PelTag::GPS_LONGITUDE_REF)->getValue() !== null
                                && $gps_ifd->getEntry(PelTag::GPS_LONGITUDE)->getValue() !== null
                            ) {

                                $GPSLatitudeRef = $gps_ifd->getEntry(PelTag::GPS_LATITUDE_REF)->getValue();
                                $GPSLatitude    = $gps_ifd->getEntry(PelTag::GPS_LATITUDE)->getValue();
                                $GPSLongitudeRef = $gps_ifd->getEntry(PelTag::GPS_LONGITUDE_REF)->getValue();
                                $GPSLongitude   = $gps_ifd->getEntry(PelTag::GPS_LONGITUDE)->getValue();

                                $lat_degrees = count($GPSLatitude) > 0 && $GPSLatitude[0][1] > 0 ? GPSLocation::gps2Num($GPSLatitude[0][0] / $GPSLatitude[0][1]) : 0;
                                $lat_minutes = count($GPSLatitude) > 1 && $GPSLatitude[1][1] > 0 ? GPSLocation::gps2Num($GPSLatitude[1][0] / $GPSLatitude[1][1]) : 0;
                                $lat_seconds = count($GPSLatitude) > 2 && $GPSLatitude[2][1] > 0 ? GPSLocation::gps2Num($GPSLatitude[2][0] / $GPSLatitude[2][1]) : 0;

                                $lon_degrees = count($GPSLongitude) > 0 && $GPSLongitude[0][1] > 0 ? GPSLocation::gps2Num($GPSLongitude[0][0] / $GPSLongitude[0][1]) : 0;
                                $lon_minutes = count($GPSLongitude) > 1 && $GPSLongitude[1][1] > 0 ? GPSLocation::gps2Num($GPSLongitude[1][0] / $GPSLongitude[1][1]) : 0;
                                $lon_seconds = count($GPSLongitude) > 2 && $GPSLongitude[2][1] > 0 ? GPSLocation::gps2Num($GPSLongitude[2][0] / $GPSLongitude[2][1]) : 0;

                                $lat_direction = ($GPSLatitudeRef == 'W' or $GPSLatitudeRef == 'S') ? -1 : 1;
                                $lon_direction = ($GPSLongitudeRef == 'W' or $GPSLongitudeRef == 'S') ? -1 : 1;

                                $latitude = $lat_direction * ($lat_degrees + ($lat_minutes / 60) + ($lat_seconds / (60 * 60)));
                                $longitude = $lon_direction * ($lon_degrees + ($lon_minutes / 60) + ($lon_seconds / (60 * 60)));

                                return array('latitude' => $latitude, 'longitude' => $longitude);
                            }
                        }
                    }
                }
            }
        } catch (Exception $ex) {
        }

        return false;
    }

    static function get_image_rotation($image = '')
    {

        $exif = exif_read_data($image, 0, true);
        if ($exif && isset($exif['IFD0']) && isset($exif['IFD0']['Orientation'])) {

            $orientation = $exif['IFD0']['Orientation'];
            switch ($orientation) {
                case 3:
                    return 180;

                case 6:
                    return 90;

                case 8:
                    return -90;
            }
        }

        return 0;
    }
}

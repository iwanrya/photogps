<?php

namespace App\Core\general\image;

use App\Core\general\GPSLocation;
use lsolesen\pel\PelEntryAscii;
use lsolesen\pel\PelEntryRational;
use lsolesen\pel\PelIfd;
use lsolesen\pel\PelJpeg;
use lsolesen\pel\PelTag;

class AddExifToImage
{
    /**
     * Add GPS information to an image basic metadata.
     * Any old Exif data
     * is discarded.
     *
     * @param string $input
     *            the input filename.
     * @param string $output
     *            the output filename. An updated copy of the input
     *            image is saved here.
     * @param float $longitude
     *            expressed as a fractional number of degrees,
     *            e.g. 12.345�. Negative values denotes degrees west of Greenwich.
     * @param float $latitude
     *            expressed as for longitude. Negative values
     *            denote degrees south of equator.
     */
    static function addGpsInfo($input, $output, $longitude, $latitude)
    {
        $jpeg = new PelJpeg($input);

        $exif = $jpeg->getExif();

        $tiff = $exif->getTiff();

        $ifd0 = $tiff->getIfd();

        $gps_ifd = $ifd0->getSubIfd(PelIfd::GPS);

        if ($gps_ifd === null) {
            $gps_ifd = new PelIfd(PelIfd::GPS);
            $ifd0->addSubIfd($gps_ifd);
        }

        list($hours, $minutes, $seconds) = GPSLocation::convertDecimalToDMS($latitude);

        /* We interpret a negative latitude as being south. */
        $latitude_ref = ($latitude < 0) ? 'S' : 'N';

        $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LATITUDE_REF, $latitude_ref));
        $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LATITUDE, $hours, $minutes, $seconds));

        /* The longitude works like the latitude. */
        list($hours, $minutes, $seconds) = GPSLocation::convertDecimalToDMS($longitude);
        $longitude_ref = ($longitude < 0) ? 'W' : 'E';

        $gps_ifd->addEntry(new PelEntryAscii(PelTag::GPS_LONGITUDE_REF, $longitude_ref));
        $gps_ifd->addEntry(new PelEntryRational(PelTag::GPS_LONGITUDE, $hours, $minutes, $seconds));

        file_put_contents($output, $jpeg->getBytes());
    }
}
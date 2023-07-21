<?php

namespace App\Core\general;

class GPSLocation
{
    static function convertDecimalToDMS($degree)
    {
        if ($degree > 180 || $degree < -180) {
            return null;
        }

        $degree = abs($degree); // make sure number is positive
        // (no distinction here for N/S
        // or W/E).

        $seconds = $degree * 3600; // Total number of seconds.

        $degrees = floor($degree); // Number of whole degrees.
        $seconds -= $degrees * 3600; // Subtract the number of seconds
        // taken by the degrees.

        $minutes = floor($seconds / 60); // Number of whole minutes.
        $seconds -= $minutes * 60; // Subtract the number of seconds
        // taken by the minutes.

        $seconds = round($seconds * 100, 0); // Round seconds with a 1/100th
        // second precision.

        return [
            [
                $degrees,
                1
            ],
            [
                $minutes,
                1
            ],
            [
                $seconds,
                100
            ]
        ];
    }

    static function gps2Num($coordPart)
    {
        $parts = explode('/', $coordPart);
        if (count($parts) <= 0)
            return 0;
        if (count($parts) == 1)
            return $parts[0];
        return floatval($parts[0]) / floatval($parts[1]);
    }
}
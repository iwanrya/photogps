<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Validator;

class PostImages implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $photos, Closure $fail): void
    {

        $imageRules = array(
            'image' => 'image|mimes:jpeg,jpg|max:80000'
        );
        
        foreach($photos as $image)
        {
            $image = array('image' => $image);
        
            $imageValidator = Validator::make($image, $imageRules);
        
            if ($imageValidator->fails()) {
        
                $messages = $imageValidator->messages();
        
                $fail($messages);
            }
        }

        // $shoot_datetime = Request()->post('shoot_datetime');
        // $lat = Request()->post('latitude');
        // $long = Request()->post('longitude');
        // $separate_exif = Request()->post('separate_exif');

        // $unmatched = [];

        // if ($separate_exif == null || count($photos) != count($separate_exif)) {
        //     $unmatched[] = 'separate_exif';
        // }
        
        // if ($shoot_datetime == null || count($photos) != count($shoot_datetime)) {
        //     $unmatched[] = 'shoot_datetime';
        // }

        // if ($lat == null || count($photos) != count($lat)) {
        //     $unmatched[] = 'latitude';
        // }

        // if ($long == null || count($photos) != count($long)) {
        //     $unmatched[] = 'longitude';
        // }

        // if (!empty($unmatched)) {
        //     $fail("The {$attribute}'s support data [" . implode(', ', $unmatched) . "] count are unmatched");
        //     return;
        // }
    }
}

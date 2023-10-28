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
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class AccessTokenResource extends BaseResource
{
    public $access_token;

    public function __construct($status, $access_token, $message = '', $resource = null){
        parent::__construct($status, $message, $resource);
        
        $this->access_token  = $access_token;
    }

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $array = parent::toArray($request);
        $array['access_token'] = $this->access_token;

        return $array;
    }
}

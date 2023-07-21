<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    protected $dateFormat = 'Y/m/d H:i:s';
    
    protected function getCreatedAtFormattedAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format($this->dateFormat);
    }

    protected function getUpdatedAtFormattedAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format($this->dateFormat);
    }
}

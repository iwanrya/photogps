<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{

    protected $dateFormat = 'Y/m/d H:i:s';

    protected function getCreatedAtFormattedAttribute()
    {
        if (!empty($this->created_at)) {
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format($this->dateFormat);
        } else {
            return '';
        }
    }

    protected function getUpdatedAtFormattedAttribute()
    {
        if (!empty($this->updated_at)) {
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format($this->dateFormat);
        } else {
            return '';
        }
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use DB;

class Post extends Model
{
    use HasFactory;

    protected $primaryKey = null;

    public $incrementing = false;

    protected $fillable = [
        'image',
        'latitude',
        'longitude',
    ];

    protected $dateFormat = 'Y/m/d H:i:s';

    protected $appends = [
        'image_thumbnail'
    ];

    protected function getImageAttribute($value)
    {
        return asset('/storage/posts/' . $value);
    }

    public function getImageThumbnailAttribute()
    {
        return asset('/storage/thumbnail/posts/' . $this->getRawOriginal('image'));
    }

    protected function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->format($this->dateFormat);
    }

    protected function getUpdatedAtAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->format($this->dateFormat);
    }

}

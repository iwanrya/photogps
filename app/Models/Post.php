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
        'image_thumbnail',
        'created_at_formatted',
        'updated_at_formatted'
    ];

    protected function getImageAttribute($value)
    {
        return asset('/storage/posts/' . $value);
    }

    protected function getImageThumbnailAttribute()
    {
        return asset('/storage/thumbnail/posts/' . $this->getRawOriginal('image'));
    }

    protected function getCreatedAtFormattedAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->created_at)->format($this->dateFormat);
    }

    protected function getUpdatedAtFormattedAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->updated_at)->format($this->dateFormat);
    }

}

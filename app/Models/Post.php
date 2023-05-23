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

    /**
     * fillable
     * 
     * @var array
     */
    protected $fillable = [
        'image',
        'latitude',
        'longitude',
    ];

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

}

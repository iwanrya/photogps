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
        'modified_at_formatted'
    ];

    protected function getImageAttribute($value)
    {
        return asset('/storage/posts/' . $value);
    }

    public function getImageThumbnailAttribute()
    {
        return asset('/storage/thumbnail/posts/' . $this->getRawOriginal('image'));
    }

    public function getCreatedAtFormattedAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->getRawOriginal('created_at'))->format($this->dateFormat);
    }

    public function getUpdatedAtFormattedAttribute()
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->getRawOriginal('updated_at'))->format($this->dateFormat);
    }

}

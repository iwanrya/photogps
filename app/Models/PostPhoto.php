<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;

class PostPhoto extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'post_id',
        'image',
        'latitude',
        'longitude',
        'shoot_datetime',
        'create_user_id',
    ];

    protected $appends = [
        'photo_original',
        'photo',
        'thumbnail',
        'shoot_datetime_formatted',
        'created_at_formatted',
        'updated_at_formatted'
    ];

    protected function getShootDatetimeFormattedAttribute() {
        if (!empty($this->updated_at)) {
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->shoot_datetime)->format($this->dateFormat);
        } else {
            return '';
        }
    }

    protected function getImageAttribute($value)
    {
        return asset('/storage/posts/' . $value);
    }

    protected function getPhotoAttribute()
    {
        return asset('/storage/posts/' . $this->getRawOriginal('image'));
    }

    protected function getPhotoOriginalAttribute()
    {
        return URL::to('/photo/original_image/' . $this->id);
    }

    protected function getThumbnailAttribute()
    {
        return asset('/storage/thumbnail/posts/' . $this->getRawOriginal('image'));
    }

    protected function getLatitudeAttribute($value)
    {
        return $value !== null ? floatval($value) : null;
    }

    protected function getLongitudeAttribute($value)
    {
        return $value !== null ? floatval($value) : null;
    }
}

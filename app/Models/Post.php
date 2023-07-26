<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Post extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'image',
        'latitude',
        'longitude',
        'shoot_datetime',
        'photographer',
        'photographer_username',
        'create_user_id',
    ];

    protected $appends = [
        'original',
        'photo',
        'thumbnail',
        'created_at_formatted',
        'updated_at_formatted'
    ];

    public function postComment(): HasMany
    {
        return $this->hasMany(PostComment::class, 'post_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'create_user_id', 'id');
    }

    protected function getPhotographerAttribute($value)
    {
        return Str::title($value);
    }

    protected function getImageAttribute($value)
    {
        return asset('/storage/posts/' . $value);
    }

    protected function getPhotoAttribute()
    {
        return asset('/storage/posts/' . $this->getRawOriginal('image'));
    }

    protected function getOriginalAttribute()
    {
        // return asset('/storage/posts/' . $this->getRawOriginal('image'));
    }

    protected function getThumbnailAttribute()
    {
        return asset('/storage/thumbnail/posts/' . $this->getRawOriginal('image'));
    }

    protected function getLatitudeAttribute($value)
    {
        return floatval($value);
    }

    protected function getLongitudeAttribute($value)
    {
        return floatval($value);
    }
}

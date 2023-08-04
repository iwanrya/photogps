<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\URL;
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
        'project_id',
        'customer_id',
        'status',
    ];

    protected $appends = [
        'photo_original',
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

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }

    public function statusItem(): BelongsTo
    {
        return $this->belongsTo(Status::class, 'status', 'id');
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

    protected function getProjectIdAttribute($value)
    {
        return $value != null ? intval($value) : null;
    }

    protected function getCustomerIdAttribute($value)
    {
        return $value != null ? intval($value) : null;
    }

    protected function getStatusAttribute($value)
    {
        return $value != null ? intval($value) : null;
    }
}

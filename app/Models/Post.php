<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        'area_id',
        'project_id',
        'customer_id',
        'company_id',
        'status',
    ];

    protected $appends = [
        'zip_photo_original',
        'zip_photo',
        'photo_original',
        'photo',
        'thumbnail',
        'shoot_datetime_formatted',
        'created_at_formatted',
        'updated_at_formatted'
    ];

    public function postComment(): HasMany
    {
        return $this->hasMany(PostComment::class, 'post_id', 'id');
    }

    public function postPhoto(): HasMany
    {
        return $this->hasMany(PostPhoto::class, 'post_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'create_user_id', 'id');
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class, 'area_id', 'id');
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
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

    protected function getShootDatetimeFormattedAttribute()
    {
        if (!empty($this->shoot_datetime)) {
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

    protected function getZIPPhotoOriginalAttribute()
    {
        return URL::to('/photo/original_images/' . $this->id);
    }

    protected function getZIPPhotoAttribute()
    {
        return URL::to('/photo/images/' . $this->id);
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

    public function scopeRead(
        Builder $builder,
        User $user,
        array $photographers = [],
        array $companies = [],
        array $projects = [],
        array $areas = [],
        array $status = [],
        string $shoot_date_start = '',
        string $shoot_date_end = '',
        string $comment = ''
    ): void {
        Post::with(['postComment', 'postPhoto', 'company', 'project', 'statusItem']);
        if (!empty($photographers)) {
            $builder->whereIn('create_user_id', $photographers);
        }

        if (!empty($areas)) {
            $builder->whereIn('area_id', $areas);
        }


        if ($user->companyUser->userAuth->is_system_owner == false) {
            $builder->where('company_id', $user->companyUser->company_id);
        } else {
            if (!empty($companies)) {
                $builder->whereIn('company_id', $companies);
            }
        }

        if (!empty($projects)) {
            $builder->whereIn('project_id', $projects);
        }

        if (!empty($status)) {
            $builder->whereIn('status', $status);
        }

        if (!empty($shoot_date_start)) {
            $builder->whereRelation('postPhoto', 'shoot_datetime', '>=', $shoot_date_start);
        }

        if (!empty($shoot_date_end)) {
            $builder->whereRelation('postPhoto', 'shoot_datetime', '<=', $shoot_date_end . ' 23:59:59.9999');
        }

        if (!empty($comment)) {
            $builder->whereRelation('postComment', 'comment', 'like', "%{$comment}%");
        }
    }
}

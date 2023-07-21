<?php

namespace App\Models;

use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Post extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'image',
        'latitude',
        'longitude',
        'shoot_datetime',
        'photographer',
        'photographer_username',
    ];

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

    /**
     * @return Builder $builder
     */
    public static function read($photographers, $shoot_date_start, $shoot_date_end, $comment)
    {
        //find post by image name
        $builder = DB::table('posts', 'p')->join('post_comments as pc', 'p.post_id', '=', 'pc.post_id');

        if(!empty($photographers)) {
            $builder->whereIn('p.photographer', $photographers);
        }

        if(!empty($shoot_date_start)) {
            $builder->where('p.shoot_datetime', '>=', $shoot_date_start);
        }

        if(!empty($shoot_date_end)) {
            $builder->where('p.shoot_datetime', '<=', $shoot_date_end);
        }

        if(!empty($comment)) {
            $builder->where('pc.comment', 'like', "%{$comment}%");
        }

        return $builder;
    }
}

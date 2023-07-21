<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class PostComment extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'comment',
    ];

    protected $appends = [
    ];
}

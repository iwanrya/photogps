<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostComment extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'comment',
        'create_user_id',
    ];

    protected $appends = [
        'created_at_formatted',
        'updated_at_formatted'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'post_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'create_user_id', 'id');
    }
}

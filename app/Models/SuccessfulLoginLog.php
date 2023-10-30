<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class SuccessfulLoginLog extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'create_user_id',
        'username',
    ];

    protected $appends = [
        'created_at_formatted',
    ];

}

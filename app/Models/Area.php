<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Area extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = [
        'created_at_formatted',
        'updated_at_formatted'
    ];
}

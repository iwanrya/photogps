<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'company_id',
        'name',
        'create_user_id',
    ];

    protected $appends = [
        'created_at_formatted',
        'updated_at_formatted'
    ];

}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAuth extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name',
        'create_user_id',
        'is_system_owner',
    ];

    protected $appends = [
        'created_at_formatted',
        'updated_at_formatted'
    ];

    public function scopeHideHidden($query)
    {
        return $query->where('is_hidden', '=', false);
    }

    protected function getIsSystemOwnerAttribute($value)
    {
        return $value || $value == 1;
    }

}

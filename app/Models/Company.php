<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Company extends BaseModel
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

    public function companyUser(): HasMany
    {
        return $this->hasMany(CompanyUser::class, 'company_id', 'id');
    }

    public function createUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'create_user_id', 'id');
    }

    protected function getIsSystemOwnerAttribute($value)
    {
        return $value || $value == 1;
    }

}

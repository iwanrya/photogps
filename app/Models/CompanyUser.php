<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanyUser extends BaseModel
{
    use HasFactory;

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userAuth(): BelongsTo
    {
        return $this->belongsTo(UserAuth::class, 'auth', 'id');
    }

    protected $fillable = [
        'company_id',
        'user_id',
        'auth',
    ];

    public $timestamps = false;
}

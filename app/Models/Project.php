<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }

    public function scopeRead(
        Builder $builder,
        User $user,
        array $companies = [],
        string $name = ''
    ): void {
        Project::with(['company']);
        
        if ($user->companyUser->userAuth->is_system_owner == false) {
            $builder->where('company_id', $user->companyUser->company_id);
        } else {
            if (!empty($companies)) {
                $builder->whereIn('company_id', $companies);
            }
        }

        if (!empty($name)) {
            $builder->where('name', 'like', "%{$name}%");
        }
    }

}

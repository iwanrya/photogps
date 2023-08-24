<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Support\Str;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasFactory;
    use SoftDeletes;

    public $timestamps = true;

    protected $dateFormat = 'Y/m/d H:i:s';

    public function companyUser(): HasOne
    {
        return $this->hasOne(CompanyUser::class, 'user_id', 'id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    public function isSystemOwner(): bool {
        return $this->companyUser->userAuth->is_system_owner;
    }

    protected function getNameAttribute($value)
    {
        return Str::title($value);
    }

    protected function getEmailVerifiedAtFormattedAttribute()
    {
        if (!empty($this->email_verified_at)) {
            return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $this->email_verified_at)->format($this->dateFormat);
        } else {
            return '';
        }
    }

    function hideInternalFields()
    {
        $this->makeHidden([
            'created_at',
            'updated_at',
            'email_verified_at',
            'created_at_formatted',
            'updated_at_formatted',
            'email_verified_at_formatted',
            'deleted_at',
            'create_user_id'
        ]);
    }

    function hideUnformattedInternalFields()
    {
        $this->makeHidden([
            'created_at',
            'updated_at',
            'email_verified_at',
            'email_verified_at_formatted',
            'deleted_at',
            'create_user_id'
        ]);
    }
}

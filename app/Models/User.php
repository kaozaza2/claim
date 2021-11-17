<?php

namespace App\Models;

use App\Contracts\Nameable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements Nameable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    const SEX_NONE = 0;
    const SEX_MALE = 1;
    const SEX_FEMALE = 2;

    /**
     * @var string[]
     */
    protected $fillable = [
        'title',
        'name',
        'username',
        'last_name',
        'sex',
        'identification',
        'department_id',
        'sub_department_id',
        'email',
        'password',
    ];

    /**
     * @var string[]
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * @var array<string, class-string<\datetime>>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * @var string[]
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function isAdmin(): bool
    {
        return Str::contains($this->role, 'admin');
    }

    /**
     * @return string
     */
    protected function getFullnameAttribute()
    {
        return \sprintf('%s %s %s', $this->title, $this->name, $this->last_name);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function scopeAdmin(Builder $query)
    {
        return $query->where('role', 'admin')
            ->orWhere('role', 'superadmin');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function scopeMember(Builder $query)
    {
        return $query->where('role', 'member');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subDepartment()
    {
        return $this->belongsTo(SubDepartment::class, 'sub_department_id');
    }

    public function getName()
    {
        return $this->fullname;
    }

    /**
     * @return string[]
     */
    public static function roles(): array
    {
        return ['admin', 'member'];
    }

    /**
     * @return string[]
     */
    public static function sexes(): array
    {
        return [
            self::SEX_NONE => 'none',
            self::SEX_MALE => 'male',
            self::SEX_FEMALE => 'female',
        ];
    }
}

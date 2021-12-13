<?php

namespace App\Models;

use App\Contracts\Nameable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements Nameable
{
    use Concerns\WithSearchableColumns;
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    const SEX_NONE = 0;
    const SEX_MALE = 1;
    const SEX_FEMALE = 2;

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

    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $excludes = [
        'department_id',
        'sub_department_id',
        'email_verified_at',
        'profile_photo_url',
        'profile_photo_path',
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function isAdmin(): bool
    {
        return Str::contains($this->role, 'admin');
    }

    protected function getFullnameAttribute(): string
    {
        return implode(' ', [
            $this->getAttribute('title'),
            $this->getAttribute('name'),
            $this->getAttribute('last_name'),
        ]);
    }

    protected function scopeAdmin(Builder $query): Builder
    {
        return $query->where('role', 'admin')
            ->orWhere('role', 'superadmin');
    }

    protected function scopeMember(Builder $query): Builder
    {
        return $query->where('role', 'member');
    }

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    public function subDepartment(): BelongsTo
    {
        return $this->belongsTo(SubDepartment::class, 'sub_department_id');
    }

    public function getName()
    {
        return $this->fullname;
    }

    public static function roles(): array
    {
        return ['admin', 'member'];
    }

    public static function sexes(): array
    {
        return [
            self::SEX_NONE => 'none',
            self::SEX_MALE => 'male',
            self::SEX_FEMALE => 'female',
        ];
    }
}

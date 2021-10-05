<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    protected $fillable = [
        'title',
        'name',
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

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'profile_photo_url',
    ];

    public function isAdmin(): bool
    {
        return Str::contains($this->role, ['admin', 'superadmin']);
    }

    public function isSuperAdmin(): bool
    {
        return Str::contains($this->role, 'superadmin');
    }

    protected function getFullnameAttribute()
    {
        return sprintf('%s %s %s', $this->title, $this->name, $this->last_name);
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function sub_department()
    {
        return $this->belongsTo(SubDepartment::class, 'sub_department_id');
    }
}

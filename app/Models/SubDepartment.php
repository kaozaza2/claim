<?php

namespace App\Models;

use App\Contracts\Nameable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubDepartment extends Model implements Nameable
{
    use Concerns\WithSearchableColumns;
    use HasFactory;

    protected $excludes = [
        'department_id',
    ];

    public function scopeWhereDepartment(Builder $query, $departmentId) : Builder
    {
        return $query->where('department_id', $departmentId);
    }

    public function department(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(User::class);
    }

    public function getName()
    {
        return $this->name;
    }
}

<?php

namespace App\Models;

use App\Contracts\Nameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Model;

class Department extends Model implements Nameable
{
    use Concerns\WithSearchableColumns;
    use HasFactory;

    public function subs(): HasMany
    {
        return $this->hasMany(SubDepartment::class);
    }

    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, SubDepartment::class);
    }

    public function getName(): string
    {
        return $this->name;
    }
}

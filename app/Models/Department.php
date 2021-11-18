<?php

namespace App\Models;

use App\Contracts\Nameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model implements Nameable
{
    use HasFactory;

    public function subs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(SubDepartment::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(User::class, SubDepartment::class);
    }

    public function getName()
    {
        return $this->name;
    }
}

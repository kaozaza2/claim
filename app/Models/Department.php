<?php

namespace App\Models;

use App\Contracts\Nameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model implements Nameable
{
    use HasFactory;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subs()
    {
        return $this->hasMany(SubDepartment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function users()
    {
        return $this->hasManyThrough(User::class, SubDepartment::class);
    }

    public function getName()
    {
        return $this->name;
    }
}

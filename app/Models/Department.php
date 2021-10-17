<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    public function subs()
    {
        return $this->hasMany(SubDepartment::class);
    }

    public function users()
    {
        return $this->hasManyThrough(User::class, SubDepartment::class);
    }
}

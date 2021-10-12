<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'from_sub_department_id',
        'to_sub_department_id',
        'user_id',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class, 'equipment_id');
    }

    public function fromSub()
    {
        return $this->belongsTo(SubDepartment::class, 'from_sub_department_id');
    }

    public function toSub()
    {
        return $this->belongsTo(SubDepartment::class, 'to_sub_department_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

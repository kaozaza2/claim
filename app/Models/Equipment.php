<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    protected $fillable = [
        'name',
        'serial_number',
        'detail',
    ];

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function preClaims()
    {
        return $this->hasMany(PreClaim::class);
    }

    public function oldSubDepartment()
    {
        return $this->belongsTo(SubDepartment::class, 'old_sub_department_id');
    }

    public function subDepartment()
    {
        return $this->belongsTo(SubDepartment::class, 'sub_department_id');
    }

    protected function scopeWhereSubDepartment($query, $subId = null)
    {
        return $query->where('sub_department_id', $subId ?: Auth::user()->subDepartment->id);
    }

    protected function getPictureUrlAttribute()
    {
        if ($this->pucture) {
            return Storage::url($this->pucture);
        }

        return asset('images/no_image.jpg');
    }
}

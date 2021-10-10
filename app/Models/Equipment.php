<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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

    public function getPictureUrlAttribute()
    {
        if ($this->pucture) {
            return Storage::url($this->pucture);
        }

        return asset('images/no_image.jpg');
    }
}

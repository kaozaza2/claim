<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreClaim extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'user_id',
        'admin_id',
        'problem',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user()
    {
        return$this->belongsTo(User::class, 'user_id');
    }

    public function admin()
    {
        return$this->belongsTo(User::class, 'admin_id');
    }
}

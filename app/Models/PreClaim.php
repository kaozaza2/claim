<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreClaim extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'equipment_id',
        'user_id',
        'problem',
    ];

    public function equipment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return$this->belongsTo(User::class, 'user_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Claim extends Model
{
    use Concerns\WithSearchableColumns;
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'user_id',
        'admin_id',
        'problem',
        'status',
        'complete',
    ];

    protected $excludes = [
        'equipment_id',
        'user_id',
        'admin_id',
    ];

    protected $casts = [
        'complete' => 'boolean',
    ];

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}

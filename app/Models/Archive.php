<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = [
        'archiver',
        'reason'
    ];

    public function archive(): MorphTo
    {
        return $this->morphTo();
    }

    public function archiver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'archiver');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Support\Facades\Auth;

class PreClaim extends Model
{
    use Concerns\WithSearchableColumns;
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'user_id',
        'problem',
    ];

    protected $excludes = [
        'equipment_id',
        'user_id',
    ];

    protected function scopeCurrentUser(Builder $query): Builder
    {
        return $query->where('user_id', Auth::user()->id);
    }

    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user(): BelongsTo
    {
        return$this->belongsTo(User::class, 'user_id');
    }

    public function archive(): MorphOne
    {
        return $this->morphOne(Archive::class, 'archive');
    }
}

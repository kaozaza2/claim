<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    protected function scopeWithCompleted(Builder $query, $complete = true) : Builder
    {
        return $query->where('complete', $complete ? 1 : 0);
    }

    protected function scopeSubDepartmentId(Builder $query, $id = null) : Builder
    {
        return $query->whereHas('equipment', function (Builder $query) use ($id): Builder {
            return $query->where('sub_department_id', $id ?: Auth::user()->sub_department_id);
        });
    }

    protected function scopeOrSubDepartmentId(Builder $query, $id = null) : Builder
    {
        return $query->orWhereHas('equipment', function (Builder $query) use ($id): Builder {
            return $query->where('sub_department_id', $id ?: Auth::user()->sub_department_id);
        });
    }

    protected function scopeUserId(Builder $query, $id = null) : Builder
    {
        return $query->where('user_id', $id ?: Auth::user()->id);
    }

    protected function scopeOrUserId(Builder $query, $id = null) : Builder
    {
        return $query->orWhere('user_id', $id ?: Auth::user()->id);
    }

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

    public function isCompleted(): bool
    {
        return (bool) $this->complete;
    }
}

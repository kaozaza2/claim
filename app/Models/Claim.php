<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Claim extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'equipment_id',
        'user_id',
        'admin_id',
        'problem',
        'status',
        'complete',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'complete' => 'boolean',
    ];

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function scopeWithCompleted(Builder $query, $complete = true) : Builder
    {
        return $query->where('complete', $complete ? 1 : 0);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function scopeSubDepartmentId(Builder $query, $id = null) : Builder
    {
        return $query->whereHas('equipment', function (Builder $query) use ($id) {
            return $query->where('sub_department_id', $id ?: Auth::user()->sub_department_id);
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function scopeOrSubDepartmentId(Builder $query, $id = null) : Builder
    {
        return $query->orWhereHas('equipment', function (Builder $query) use ($id) {
            return $query->where('sub_department_id', $id ?: Auth::user()->sub_department_id);
        });
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function scopeUserId(Builder $query, $id = null) : Builder
    {
        return $query->where('user_id', $id ?: Auth::user()->id);
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function scopeOrUserId(Builder $query, $id = null) : Builder
    {
        return $query->orWhere('user_id', $id ?: Auth::user()->id);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function isCompleted()
    {
        return $this->complete;
    }
}

<?php

namespace App\Models;

use App\Models\Casts\UserCastor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Archive extends Model
{
    use HasFactory;

    protected $fillable = [
        'archiver',
        'reason'
    ];

    protected $casts = [
        'archiver' => UserCastor::class,
    ];

    public function archive(): MorphTo
    {
        return $this->morphTo();
    }
}

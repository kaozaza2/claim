<?php

namespace App\Models;

use App\Contracts\Nameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Equipment extends Model implements Nameable
{
    use Concerns\WithSearchableColumns;
    use HasFactory;

    protected $table = 'equipments';

    protected $appends = [
        'picture_url',
        'sub_department',
    ];

    protected $excludes = [
        'picture_url',
        'sub_department_id',
    ];

    public function updatePicture(UploadedFile $picture): void
    {
        \tap($this->picture, function ($previous) use ($picture): void {
            $this->forceFill([
                'picture' => $picture->storePublicly(
                    'equipment-photos', ['disk' => $this->pictureStorageDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->pictureStorageDisk())->delete($previous);
            }
        });

    }

    public function deletePicture(): void
    {
        if ($this->picture) {
            Storage::disk($this->pictureStorageDisk())->delete($this->picture);
        }
    }

    protected function pictureStorageDisk(): string
    {
        return 'public';
    }

    public function claims(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Claim::class);
    }

    public function preClaims(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(PreClaim::class);
    }

    public function oldSubDepartment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SubDepartment::class, 'old_sub_department_id');
    }

    public function subDepartment(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(SubDepartment::class, 'sub_department_id');
    }

    protected function scopeWhereSubDepartment($query, $subId = null)
    {
        return $query->where('sub_department_id', $subId ?: Auth::user()->subDepartment->id);
    }

    protected function getPictureUrlAttribute()
    {
        if ($this->picture) {
            return Storage::disk($this->pictureStorageDisk())->url($this->picture);
        }

        return asset('images/no_image.jpg');
    }

    protected function getFullDetailsAttribute()
    {
        return implode(' : ', [
            $this->name,
            $this->brand,
            $this->category,
            $this->serial_number,
        ]);
    }

    protected function getSubDepartmentAttribute()
    {
        return optional(
            $this->subDepartment()->first()
        )->getName();
    }

    public function getName()
    {
        return $this->name;
    }
}

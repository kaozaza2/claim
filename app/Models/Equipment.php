<?php

namespace App\Models;

use App\Contracts\Nameable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
    ];

    protected $excludes = [
        'sub_department_id',
    ];

    public function updatePicture(UploadedFile $picture): void
    {
        tap($this->picture, function ($previous) use ($picture) {
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

    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }

    public function preClaims(): HasMany
    {
        return $this->hasMany(PreClaim::class);
    }

    public function transfers(): HasMany
    {
        return $this->hasMany(Transfer::class);
    }

    public function oldSubDepartment(): BelongsTo
    {
        return $this->belongsTo(SubDepartment::class, 'old_sub_department_id');
    }

    public function subDepartment(): BelongsTo
    {
        return $this->belongsTo(SubDepartment::class, 'sub_department_id');
    }

    protected function getPictureUrlAttribute(): string
    {
        if ($this->picture) {
            return Storage::disk($this->pictureStorageDisk())->url($this->picture);
        }

        return asset('images/no_image.jpg');
    }

    protected function getFullDetailsAttribute(): string
    {
        return implode(' : ', [
            $this->name, $this->brand, $this->category, $this->serial_number
        ]);
    }

    public function getName(): string
    {
        return $this->name;
    }
}

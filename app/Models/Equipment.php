<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class Equipment extends Model
{
    use HasFactory;

    protected $table = 'equipments';

    public function updatePicture(UploadedFile $picture)
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

    public function deletePicture()
    {
        if ($this->picture) {
            Storage::disk($this->pictureStorageDisk())->delete($this->picture);
        }
    }

    protected function pictureStorageDisk(): string
    {
        return 'public';
    }

    public function claims()
    {
        return $this->hasMany(Claim::class);
    }

    public function preClaims()
    {
        return $this->hasMany(PreClaim::class);
    }

    public function oldSubDepartment()
    {
        return $this->belongsTo(SubDepartment::class, 'old_sub_department_id');
    }

    public function subDepartment()
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
}

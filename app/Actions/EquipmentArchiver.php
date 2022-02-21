<?php

namespace App\Actions;

use App\Contracts\EquipmentsArchivers;
use App\Models\Equipment;
use Illuminate\Support\Facades\Auth;

class EquipmentArchiver implements EquipmentsArchivers
{
    public function archive(Equipment $equipment)
    {
        $archiver = Auth::id();
        $equipment->archive()->create([
            'archiver' => $archiver,
        ]);

        if ($equipment->claims()->exists()) {
            foreach ($equipment->claims as $claim) {
                $claim->archive()->create([
                    'archiver' => $archiver,
                ]);
            }
        }

        if ($equipment->preClaims()->exists()) {
            foreach ($equipment->preClaims as $claim) {
                $this->deleteIfNotArchived($claim);
            }
        }

        if ($equipment->transfers()->exists()) {
            foreach ($equipment->transfers as $transfer) {
                $this->deleteIfNotArchived($transfer);
            }
        }
    }

    private function deleteIfNotArchived($model)
    {
        if (!$model->archive()->exists()) {
            $model->delete();
        }
    }

    public function recover(Equipment $equipment)
    {
        $equipment->archive()->delete();

        if ($equipment->claims()->exists()) {
            foreach ($equipment->claims as $claim) {
                $claim->archive()->delete();
            }
        }
    }
}

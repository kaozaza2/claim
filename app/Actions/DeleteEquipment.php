<?php

namespace App\Actions;

use App\Contracts\DeletesEquipments;
use App\Models\Equipment;

class DeleteEquipment implements DeletesEquipments
{
    public function delete(Equipment $equipment): void
    {
        $equipment->claims()->delete();
        $equipment->deletePicture();
        $equipment->delete();
    }
}

<?php

namespace App\Contracts;

use App\Models\Equipment;

interface DeletesEquipments
{
    public function delete(Equipment $equipment);
}

<?php

namespace App\Contracts;

use App\Models\Equipment;

interface UpdatesEquipments
{
    public function update(Equipment $equipment, array $input);
}

<?php

namespace App\Contracts;

use App\Models\Equipment;

interface UpdatesEquipmentsInformation
{
    public function update(Equipment $equipment, array $input);
}

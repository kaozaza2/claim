<?php

namespace App\Contracts;

use App\Models\Equipment;

interface EquipmentsArchivers
{
    public function archive(Equipment $equipment);

    public function recover(Equipment $equipment);
}

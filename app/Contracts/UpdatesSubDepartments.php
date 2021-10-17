<?php

namespace App\Contracts;

use App\Models\SubDepartment;

interface UpdatesSubDepartments
{
    public function update(SubDepartment $sub, array $input);
}

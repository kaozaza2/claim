<?php

namespace App\Contracts;

use App\Models\Department;

interface UpdatesDepartments
{
    public function update(Department $department, array $input);
}

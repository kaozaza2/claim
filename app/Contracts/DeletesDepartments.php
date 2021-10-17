<?php

namespace App\Contracts;

use App\Models\Department;

interface DeletesDepartments
{
    public function delete(Department $department);
}

<?php

namespace App\Actions;

use App\Contracts\DeletesDepartments;
use App\Models\Department;

class DeleteDepartment implements DeletesDepartments
{
    public function delete(Department $department): void
    {
        $department->subs()->delete();
        $department->delete();
    }
}

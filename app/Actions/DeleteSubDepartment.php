<?php

namespace App\Actions;

use App\Contracts\DeletesSubDepartments;
use App\Models\SubDepartment;

class DeleteSubDepartment implements DeletesSubDepartments
{
    public function delete(SubDepartment $sub)
    {
        $sub->delete();
    }
}

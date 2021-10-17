<?php

namespace App\Contracts;

use App\Models\SubDepartment;

interface DeletesSubDepartments
{
    public function delete(SubDepartment $sub);
}

<?php

namespace App\Actions;

use App\Contracts\CreatesSubDepartments;
use App\Models\SubDepartment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateSubDepartment implements CreatesSubDepartments
{
    public function create(array $input): void
    {
        Validator::make($input, [
            'department_id' => [
                'required',
                Rule::exists('departments', 'id'),
            ],
            'name' => [
                'required',
                Rule::unique('sub_departments'),
            ],
        ])->validate();

        (new SubDepartment)->forceFill([
            'department_id' => $input['department_id'],
            'name' => $input['name'],
        ])->save();
    }
}

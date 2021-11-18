<?php

namespace App\Actions;

use App\Contracts\CreatesDepartments;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateDepartment implements CreatesDepartments
{
    public function create(array $input): void
    {
        Validator::make($input, [
            'name' => [
                'required',
                Rule::unique('departments')
            ],
        ], [
            'required' => 'จำเป็นต้องใส่ชื่อ',
            'unique' => 'ชื่อหน่วยงานนี้มีอยู่แล้ว'
        ]);

        (new Department)->forceFill([
            'name' => $input['name'],
        ])->save();
    }
}

<?php

namespace App\Actions;

use App\Contracts\UpdatesDepartments;
use App\Models\Department;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateDepartment implements UpdatesDepartments
{
    public function update(Department $department, array $input): void
    {
        Validator::make($input, [
            'name' => [
                'required',
                Rule::unique('departments')->ignore($input['id'])
            ],
        ], [
            'required' => 'จำเป็นต้องใส่ชื่อ',
            'unique' => 'ชื่อหน่วยงานนี้มีอยู่แล้ว'
        ]);

        $department->forceFill([
            'name' => $input['name'],
        ])->save();
    }
}

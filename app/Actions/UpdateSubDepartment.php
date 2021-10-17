<?php

namespace App\Actions;

use App\Contracts\UpdatesSubDepartments;
use App\Models\SubDepartment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateSubDepartment implements UpdatesSubDepartments
{
    public function update(SubDepartment $sub, array $input)
    {
        Validator::make($input, [
            'name' => [
                'required',
                Rule::unique('sub_departments')->ignore($input['id'])
            ],
        ])->validate();

        $sub->forceFill([
            'name' => $input['name'],
        ])->save();
    }
}

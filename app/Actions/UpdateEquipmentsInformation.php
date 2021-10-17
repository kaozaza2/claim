<?php

namespace App\Actions;

use App\Contracts\UpdatesEquipmentsInformation;
use App\Models\Equipment;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateEquipmentsInformation implements UpdatesEquipmentsInformation
{
    public function update(Equipment $equipment, array $input)
    {
        Validator::make($input, [
            'name' => 'required',
            'serial_number' => 'nullable',
            'detail' => 'nullable',
            'brand' => 'nullable',
            'category' => 'nullable',
            'sub_department_id' => [
                'required',
                Rule::exists('sub_departments', 'id')
            ],
        ], [
            'name.required' => 'จำเป็นต้องใส่',
            'sub_department_id.required' => 'ต้องเลือกแผนกสำหรับจัดเก็บอุปกรณ์',
            'sub_department_id.exists' => 'ไม่พบแผนกที่เลือก',
        ])->validate();

        if (isset($input['picture'])) {
            $equipment->updatePicture($input['picture']);
        }

        $equipment->forceFill([
            'name' => $input['name'],
            'serial_number' => $input['serial_number'],
            'detail' => $input['detail'],
            'brand' => $input['brand'],
            'category' => $input['category'],
            'sub_department_id' => $input['sub_department_id'],
        ])->save();
    }
}

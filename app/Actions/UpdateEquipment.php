<?php

namespace App\Actions;

use App\Contracts\UpdatesEquipments;
use App\Models\Equipment;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class UpdateEquipment implements UpdatesEquipments
{
    public function update(Equipment $equipment, array $input): Equipment
    {
        validator($input, [
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

        if (array_key_exists('picture', $input) && $input['picture'] instanceof UploadedFile) {
            $equipment->updatePicture($picture);
        }

        $equipment->forceFill([
            'name' => $input['name'],
            'serial_number' => $input['serial_number'],
            'detail' => $input['detail'],
            'brand' => $input['brand'],
            'category' => $input['category'],
            'sub_department_id' => $input['sub_department_id'],
        ])->save();

        return $equipment;
    }
}

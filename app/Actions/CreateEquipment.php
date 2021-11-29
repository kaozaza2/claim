<?php

namespace App\Actions;

use App\Contracts\CreatesEquipments;
use App\Models\Equipment;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;

class CreateEquipment implements CreatesEquipments
{
    public function create(array $input): Equipment
    {
        validator($input ,[
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

        $equipment = tap(new Equipment, function ($equipment) use ($input): void {
            $equipment->forceFill([
                'name' => $input['name'],
                'serial_number' => $input['serial_number'] ?? null,
                'detail' => $input['detail'] ?? null,
                'brand' => $input['brand'] ?? null,
                'category' => $input['category'] ?? null,
                'sub_department_id' => $input['sub_department_id'],
            ])->save();
        });

        if (array_key_exists('picture', $input) && $input['picture'] instanceof UploadedFile) {
            $equipment->updatePicture($input['picture']);
        }

        return $equipment;
    }
}

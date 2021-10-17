<?php

namespace App\Actions;

use App\Contracts\CreatesEquipments;
use App\Models\Equipment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateEquipments implements CreatesEquipments
{
    public function create(array $input)
    {
        Validator::make($input ,[
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

        $equipment = tap(new Equipment, function ($equipment) use ($input) {
            $equipment->forceFill([
                'name' => $input['name'],
                'serial_number' => $input['serial_number'] ?? null,
                'detail' => $input['detail'] ?? null,
                'brand' => $input['brand'] ?? null,
                'category' => $input['category'] ?? null,
                'sub_department_id' => $input['sub_department_id'],
            ])->save();
        });

        if (isset($input['picture'])) {
            $equipment->updatePicture($input['picture']);
        }
    }
}

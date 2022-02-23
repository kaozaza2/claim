<?php

namespace App\Exports;

use App\Models\Claim;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class InClaimExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $take, $skip, $equipment;

    public function query()
    {
        return Claim::query()
            ->doesntHave('archive')
            ->where('complete', false)
            ->when($this->equipment, fn($q, $e) => $q->where('equipment_id', $e))
            ->when($this->take, fn($q, $t) => $q->take($t))
            ->when($this->skip, fn($q, $s) => $q->skip($s));
    }

    public function headings(): array
    {
        return [
            'ลำดับ',
            'ครุภัณฑ์',
            'อาการที่พบ',
            'แจ้งโดย',
            'รับเรื่องโดย',
            'เวลา',
            'วันที่',
        ];
    }

    public function map($equip): array
    {
        return [
            $equip->id,
            $equip->equipment->full_details,
            $equip->problem,
            $equip->user->fullname,
            $equip->archive->archiver->fullname,
            $equip->archive->created_at->format('H:i'),
            $equip->archive->created_at->format('d-m-Y'),
        ];
    }
}

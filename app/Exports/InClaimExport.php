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

    protected $take, $start, $equipment;

    public function query()
    {
        return Claim::query()
            ->doesntHave('archive')
            ->when($this->equipment, fn($q, $e) => $q->where('equipment_id', $e))
            ->when($this->take, fn($q, $t) => $q->take($t));
    }

    public function when($value, $callable)
    {
        return $value ? $this->{$callable}($value) : $this;
    }

    public function equipment($equipment)
    {
        $this->equipment = $equipment;

        return $this;
    }

    public function take($size)
    {
        $this->take = $size;

        return $this;
    }

    public function headings(): array
    {
        return [
            'เลขที่เคลม',
            'ครุภัณฑ์',
            'เลขครุภัณฑ์',
            'อาการที่พบ',
            'ผู้แจ้งเรื่อง',
            'ผู้รับเรื่อง',
            'สถานะ',
            'ซ่อมแล้ว',
        ];
    }

    public function map($claim): array
    {
        return [
            $claim->id,
            collect([
                $claim->equipment->id,
                "[{$claim->equipment->category}]",
                $claim->equipment->name,
                $claim->equipment->brand,
            ])->join(' '),
            $claim->equipment->serial_number,
            $claim->problem,
            $claim->user->fullname,
            $claim->admin->fullname,
            $claim->status,
            $claim->complete ? 'yes' : 'no',
        ];
    }
}

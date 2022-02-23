<?php

namespace App\Exports;

use App\Models\Equipment;
use App\Models\SubDepartment;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EquipmentExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $query;

    protected $sub, $take, $skip, $latest;

    public function __construct()
    {
        $this->latest = true;
    }

    public function sub($sub)
    {
        $this->sub = ($sub instanceof SubDepartment)
            ? $sub->id : $sub;

        return $this;
    }

    public function when($value, $callable)
    {
        if ($value) {
            $this->$callable($value);
        }

        return $this;
    }

    public function take($size)
    {
        $this->take = $size;

        return $this;
    }

    public function latest($latest)
    {
        $this->latest = $latest;

        return $this;
    }

    public function skip($size)
    {
        $this->skip = $size;

        return $this;
    }

    public function query()
    {
        return Equipment::query()
            ->when($this->sub, fn($q, $s) => $q->where('sub_department_id', $s))
            ->when($this->take, fn($q, $t) => $q->take($t))
            ->when($this->skip, fn($q, $s) => $q->skip($s))
            ->{$this->latest ? 'latest' : 'oldest'}();
    }

    public function headings(): array
    {
        return [
            'ลำดับ',
            'ครุภัณฑ์',
            'ยี่ห้อ',
            'ประเภท',
            'เลขครุภัณฑ์',
            'แผนก',
            'รายละเอียด',
        ];
    }

    public function map($claim): array
    {
        return [
            $claim->id,
            $claim->name,
            $claim->brand,
            $claim->category,
            $claim->serial_number,
            $claim->subDepartment->name,
            $claim->archive ? 'จำหน่าย' : $claim->detail,
        ];
    }
}

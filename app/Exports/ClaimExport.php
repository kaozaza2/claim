<?php

namespace App\Exports;

use App\Models\PreClaim;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ClaimExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $start, $end;

    public function __construct($start, $end)
    {
        $this->start = $start;
        $this->end = $end;
    }

    public function query()
    {
        return PreClaim::whereHas('archive', function ($query) {
            $query->where('created_at', '>=', $this->start)
                ->where('created_at', '<=', $this->end);
        });
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

    public function map($claim): array
    {
        return [
            $claim->id,
            $claim->equipment->full_details,
            $claim->problem,
            $claim->user->fullname,
            $claim->archive->archiver->fullname,
            $claim->archive->created_at->format('H:i'),
            $claim->archive->created_at->format('d-m-Y'),
        ];
    }
}

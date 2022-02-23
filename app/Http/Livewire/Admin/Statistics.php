<?php

namespace App\Http\Livewire\Admin;

use App\Models\Claim;
use App\Models\Equipment;
use App\Models\PreClaim;
use App\Models\Transfer;
use Livewire\Component;

class Statistics extends Component
{
    public array $stats;

    public function mount()
    {
        $this->stats = [
            [
                'name' => 'รายการส่งเคลม',
                'desc' => '🔌 รายการส่งเคลมทั้งหมดในระบบ',
                'count' => Claim::all()->count(),
                'download' => [
                    'link' => 'statistics-claim-download',
                ],
            ], [
                'name' => 'จำนวนครุภัณฑ์',
                'desc' => '🖥️ จำนวนครุภัณฑ์ที่ลงทะเบียนแล้ว',
                'count' => Equipment::doesntHave('archive')->count(),
                'download' => [
                    'link' => 'statistics-equipment-download',
                ],
            ], [
                'name' => 'รายการที่รอดำเนินการ',
                'desc' => '🔀 รายการแจ้งซ่อม/ย้ายที่รอดำเนินการ',
                'count' => PreClaim::doesntHave('archive')->count() + Transfer::doesntHave('archive')->count()
            ],
        ];
    }

    public function render()
    {
        return view('livewire.admin.statistics')
            ->layout('layouts.admin');
    }
}

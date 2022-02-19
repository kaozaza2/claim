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
                'count' => Claim::all()->count()
            ], [
                'name' => 'จำนวนครุภัณฑ์',
                'desc' => '🖥️ จำนวนครุภัณฑ์ที่ลงทะเบียนแล้ว',
                'count' => Equipment::all()->count()
            ], [
                'name' => 'รายการที่รอดำเนินการ',
                'desc' => '🔀 รายการแจ้งซ่อม/ย้ายที่รอดำเนินการ',
                'count' => PreClaim::all()->count() + Transfer::all()->count()
            ],
        ];
    }

    public function render()
    {
        return view('livewire.admin.statistics')
            ->layout('layouts.admin');
    }
}

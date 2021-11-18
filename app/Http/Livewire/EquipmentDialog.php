<?php

namespace App\Http\Livewire;

use App\Models\Equipment;
use Livewire\Component;

class EquipmentDialog extends Component
{
    protected $listeners = [
        'showEquipmentDetail',
    ];

    private ?Equipment $equipment = null;

    public bool $showingEquipmentDetail = false;

    public function showEquipmentDetail(int $equipmentId): void
    {
        $this->equipment = Equipment::find($equipmentId);
        $this->showingEquipmentDetail = true;
    }

    public function render()
    {
        return view('livewire.equipment-dialog', [
            'equipment' => optional($this->equipment),
        ]);
    }
}

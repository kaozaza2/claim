<?php

namespace App\Http\Livewire;

use App\Models\Equipment;
use Illuminate\View\View;
use Livewire\Component;

class EquipmentDialog extends Component
{
    protected $listeners = [
        'show-equipment-detail' => 'dialog',
    ];

    public Equipment $equipment;

    public bool $showing = false;

    public function mount(): void
    {
        $this->equipment = Equipment::firstOrNew();
    }

    public function dialog(int $equipmentId): void
    {
        $this->equipment = Equipment::find($equipmentId);
        $this->showing = true;
    }

    public function render(): View
    {
        return view('livewire.equipment-dialog');
    }
}

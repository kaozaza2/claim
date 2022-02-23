<?php

namespace App\Http\Livewire\Admin\Statistics;

use App\Exports\EquipmentExport;
use App\Models\Department;
use Illuminate\Support\Arr;
use Livewire\Component;

class Equipments extends Component
{
    public $showing = false;

    public array $state = [];

    public $departments;

    protected $listeners = [
        'statistics-equipment-download' => 'show',
    ];

    public function mount()
    {
        $this->departments = Department::with('subs')->get();
    }

    public function show()
    {
        $this->resetErrorBag();
        $this->state['latest'] = true;
        $this->showing = true;
    }

    public function download()
    {
        $this->validate([
            'state.sub' => 'nullable',
            'state.take' => 'nullable',
            'state.skip' => 'nullable',
        ]);

        $this->showing = false;

        return (new EquipmentExport())
            ->when(Arr::get($this->state,  'sub'), 'sub')
            ->when(Arr::get($this->state,  'take'), 'take')
            ->when(Arr::get($this->state,  'skip'), 'skip')
            ->latest(Arr::get($this->state, 'latest'))
            ->download('equipments_' . now()->format('Y-m-d_H:i') . '.xlsx');
    }

    public function render()
    {
        return view('livewire.admin.statistics.equipments');
    }
}

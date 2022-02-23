<?php

namespace App\Http\Livewire\Admin\Statistics;

use App\Exports\InClaimExport;
use App\Models\Equipment;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use Livewire\Component;

class InClaims extends Component
{
    public $equipments;

    public $showing = false;

    public $state = [];

    protected $listeners = [
        'statistics-claim-download' => 'show',
    ];

    public function mount()
    {
        $this->equipments = Equipment::query()
            ->has('claims')
            ->get();
    }

    public function show()
    {
        $this->resetErrorBag();
        $this->showing = true;
    }

    public function download()
    {
        $equipments = Equipment::has('claims')->get()->map(fn($e) => $e->id);
        $this->validate([
            'state.equipment' => ['nullable', Rule::in($equipments)],
            'state.take' => 'nullable',
        ]);

        $this->showing = false;

        return (new InClaimExport)
            ->when(Arr::get($this->state, 'equipment'), 'equipment')
            ->when(Arr::get($this->state, 'take'), 'take')
            ->download('claims_' . now()->format('Y-m-d_H:i') . '.xlsx');
    }

    public function render()
    {
        return view('livewire.admin.statistics.in-claims');
    }
}

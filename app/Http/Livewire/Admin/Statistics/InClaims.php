<?php

namespace App\Http\Livewire\Admin\Statistics;

use App\Models\Equipment;
use Livewire\Component;

class InClaims extends Component
{
    public $equipments;

    public $showing = false;

    protected $listeners = [
        'statistics-claim-download' => 'show',
    ];

    public function show()
    {
        $this->showing = true;
    }

    public function mount()
    {
        $this->equipments = Equipment::query()
            ->has('claims')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.statistics.in-claims');
    }
}

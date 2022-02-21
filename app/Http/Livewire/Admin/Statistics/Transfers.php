<?php

namespace App\Http\Livewire\Admin\Statistics;

use App\Models\Transfer;
use Livewire\Component;

class Transfers extends Component
{
    public $transfers;

    public function mount()
    {
        $this->transfers = Transfer::has('archive')
            ->orderByDesc('id')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.statistics.transfers');
    }
}

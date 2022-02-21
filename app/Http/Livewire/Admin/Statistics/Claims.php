<?php

namespace App\Http\Livewire\Admin\Statistics;

use App\Models\PreClaim;
use Livewire\Component;

class Claims extends Component
{
    public $claims;

    public function mount()
    {
        $this->claims = PreClaim::has('archive')
            ->orderByDesc('id')
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.statistics.claims');
    }
}

<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class ClaimReport extends Component
{
    protected $listeners = [
        'showClaimReport',
    ];

    public bool $showingClaimReport = false;

    public function showClaimReport()
    {
        $this->showingClaimReport = true;
    }

    public function storePreClaim()
    {
        $this->showingClaimReport = false;
    }

    public function render()
    {
        return view('livewire.user.claim-report');
    }
}

<?php

namespace App\Http\Livewire\User;

use App\Models\PreClaim;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PreClaimTable extends Component
{
    public Collection $preClaims;

    protected $listeners = [
        'reloadPreClaimTable' => '$refresh',
    ];

    public function loadPreClaims()
    {
        $this->preClaims = PreClaim::where('user_id', Auth::user()->id)->get();
    }

    public function render()
    {
        $this->loadPreClaims();
        return view('livewire.user.pre-claim-table');
    }
}

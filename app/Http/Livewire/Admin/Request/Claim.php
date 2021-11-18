<?php

namespace App\Http\Livewire\Admin\Request;

use App\Contracts\PreClaimsAccepter;
use App\Models\PreClaim;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Claim extends Component
{
    public Collection $claims;

    protected $listeners = [
        'acceptClaim'
    ];

    public function mount()
    {
        $this->claims = PreClaim::all();
    }

    public function acceptClaim(PreClaimsAccepter $accepter, int $index)
    {
        $claim = $this->claims->pull($index);
        $accepter->accept($claim, Auth::user());
    }

    public function render()
    {
        return view('livewire.admin.request.claim');
    }
}

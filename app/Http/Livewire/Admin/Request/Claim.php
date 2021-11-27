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
        'accept-claim' => 'dialog',
        'accept-claim-callback' => 'accepted',
    ];

    public function mount(): void
    {
        $this->claims = PreClaim::all();
    }

    public function dialog(int $index): void
    {
        $claim = $this->claims->get($index);
        $this->emit(
            'show-confirm-dialog',
            __('app.modal.title-accept-claim'),
            __('app.modal.msg-accept-claim', [
                'eq' => $claim->equipment->getName(),
                'by' => $claim->user->getName(),
            ]), [
                'emitter' => 'accept-claim-callback',
                'params' => [$index],
            ],
        );
    }

    public function accepted(PreClaimsAccepter $accepter, int $index): void
    {
        $claim = $this->claims->pull($index);
        $accepter->accept($claim, Auth::user());
    }

    public function render()
    {
        return view('livewire.admin.request.claim');
    }
}

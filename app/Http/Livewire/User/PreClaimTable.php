<?php

namespace App\Http\Livewire\User;

use App\Models\PreClaim;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PreClaimTable extends Component
{
    public Collection $preClaims;
    public ?PreClaim $selected = null;

    public bool $confirmingCancel = false;

    protected $listeners = [
        'reloadPreClaimTable' => '$refresh',
    ];

    public function loadPreClaims()
    {
        $this->preClaims = PreClaim::where('user_id', Auth::user()->id)
            ->whereNull('admin_id')
            ->get();
        if (!isset($this->selected) && $this->preClaims->isNotEmpty()) {
            $this->selected = $this->preClaims->first();
        }
    }

    public function render()
    {
        $this->loadPreClaims();
        return view('livewire.user.pre-claim-table', [
            'preClaims' => $this->preClaims,
            'selected' => $this->selected,
        ]);
    }

    public function showCancel(string $id)
    {
        $this->selected = $this->preClaims->firstWhere('id', $id);
        $this->confirmingCancel = true;
    }

    public function confirmCancel()
    {
        $this->selected->delete();
        $this->confirmingCancel = false;
    }
}

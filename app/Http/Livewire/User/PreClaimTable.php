<?php

namespace App\Http\Livewire\User;

use App\Models\PreClaim;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class PreClaimTable extends Component
{
    /**
     * @var mixed|null
     */
    public Collection $preClaims;

    public ?PreClaim $selected = null;

    /**
     * @var bool
     */
    public bool $confirmingCancel = false;

    /**
     * @var array<string, string>
     */
    protected $listeners = [
        'reloadPreClaimTable' => '$refresh',
    ];

    public function loadPreClaims()
    {
        $this->preClaims = PreClaim::where('user_id', Auth::user()->id)->get();
        if (!isset($this->selected) && $this->preClaims->isNotEmpty()) {
            $this->selected = $this->preClaims->first();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
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

<?php

namespace App\Http\Livewire\User;

use App\Models\Claim;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ClaimTable extends Component
{
    public Collection $claims;

    public function mount()
    {
        $this->claims = Claim::whereHas('equipment', fn($q) => $q->where('sub_department_id', Auth::user()->sub_department_id))
            ->get()
            ->keyBy('id');
    }

    public function render()
    {
        return view('livewire.user.claim-table');
    }
}
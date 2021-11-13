<?php

namespace App\Http\Livewire\User;

use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ClaimTable extends Component
{
    use WithPagination;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $claims = Claim::whereHas('equipment', fn ($q) => $q->where('sub_department_id', Auth::user()->sub_department_id))
            ->orWhere('user_id', Auth::user()->id)
            ->paginate(10);
        return \view('livewire.user.claim-table', [
            'claims' => $claims,
        ]);
    }
}

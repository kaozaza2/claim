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
        $completed = false;
        $user = Auth::user();
        $claims = Claim::userId($user->id)
            ->withCompleted($completed)
            ->orSubDepartmentId($user->sub_department_id)
            ->withCompleted($completed)
            ->paginate(10);
        return view('livewire.user.claim-table', [
            'claims' => $claims,
        ]);
    }
}

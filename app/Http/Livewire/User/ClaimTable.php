<?php

namespace App\Http\Livewire\User;

use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ClaimTable extends Component
{
    use WithPagination;

    public function render(): View
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

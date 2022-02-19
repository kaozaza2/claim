<?php

namespace App\Http\Livewire\User;

use App\Models\Claim;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class ClaimTable extends Component
{
    use WithPagination;

    public function render()
    {
        $user = Auth::user();
        $claims = Claim::whereComplete(0)
            ->where(function (Builder $query) use ($user) {
                $query->whereUserId($user->id)->orWhereHas('equipment', function ($query) use ($user) {
                    $query->whereSubDepartmentId($user->sub_department_id);
                });
            })
            ->doesntHave('archive')
            ->paginate(10);

        return view('livewire.user.claim-table', [
            'claims' => $claims,
        ]);
    }
}

<?php

namespace App\Http\Livewire\User;

use App\Models\Claim;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class ClaimTable extends Component
{
    use WithPagination;

    public function render(): View
    {
        $user = Auth::user();
        $claims = Claim::where(function (Builder $query) use ($user) {
            $query->whereUserId($user->id)->whereComplete(0);
        })->orWhere(function (Builder $query) use ($user) {
            $query->whereSubDepartmentId($user->sub_department_id)->whereComplete(0);
        })->paginate(10);
        return view('livewire.user.claim-table', [
            'claims' => $claims,
        ]);
    }
}

<?php

namespace App\Http\Livewire\User;

use App\Models\Claim;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\View\View;

class Dashboard extends Component
{
    public function render(): View
    {
        return view('livewire.user.dashboard');
    }

    public function isAuditAvailable(): bool
    {
        return Claim::whereUserId(Auth::user()->id)->whereComplete(1)->exists();
    }
}

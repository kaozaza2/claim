<?php

namespace App\Http\Livewire\User;

use App\Models\Claim;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Component;

class Audit extends Component
{
    public Collection $claims;

    public function mount(): void
    {
        $this->claims = Claim::whereUserId(Auth::user()->id)->whereComplete(1)->get();
    }

    public function render(): View
    {
        return view('livewire.user.audit');
    }
}

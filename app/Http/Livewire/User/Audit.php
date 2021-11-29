<?php

namespace App\Http\Livewire\User;

use App\Models\Claim;
use Illuminate\Support\Collection;
use Livewire\Component;

class Audit extends Component
{
    public Collection $claims;

    public function mount(): void
    {
        $this->claims = Claim::userId()->withCompleted()->get();
    }

    public function render()
    {
        return view('livewire.user.audit');
    }
}

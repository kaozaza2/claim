<?php

namespace App\Http\Livewire\User;

use Livewire\Component;
use Illuminate\View\View;

class Dashboard extends Component
{
    public function render(): View
    {
        return view('livewire.user.dashboard');
    }
}

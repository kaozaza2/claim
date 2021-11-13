<?php

namespace App\Http\Livewire\User;

use App\Models\Claim;
use Livewire\Component;
use Illuminate\Http\Request;

class Dashboard extends Component
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return \view('livewire.user.dashboard');
    }
}

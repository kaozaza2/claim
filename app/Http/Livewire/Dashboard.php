<?php

namespace App\Http\Livewire;

use App\Models\Claim;
use Livewire\Component;
use Illuminate\Http\Request;

class Dashboard extends Component
{
    public $claims;

    public function mount(Request $request)
    {
        $this->claims = Claim::where('user_id', $request->user()->id)->get();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}

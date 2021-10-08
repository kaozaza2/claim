<?php

namespace App\Http\Livewire\Admin;

use App\Models\Claim;
use Livewire\Component;

class Claims extends Component
{
    public $claims;

    public function mount()
    {
        $this->claims = Claim::all();
    }

    public function render()
    {
        return view('livewire.admin.claims')
            ->layout('layouts.admin');
    }
}

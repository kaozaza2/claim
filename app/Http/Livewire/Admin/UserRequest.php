<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class UserRequest extends Component
{
    public function render()
    {
        return view('livewire.admin.user-request')
            ->layout('layouts.admin');
    }
}

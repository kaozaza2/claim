<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Accounts extends Component
{
    protected $listeners = [
        'showAccounts',
    ];

    public bool $showingWarningDialog = false;

    public function showAccounts()
    {
        $this->showingWarningDialog = true;
    }

    public function render()
    {
        return view('livewire.admin.accounts');
    }
}

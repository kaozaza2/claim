<?php

namespace App\Http\Livewire\Admin;

use Livewire\Component;

class Accounts extends Component
{
    /**
     * @var string[]
     */
    protected $listeners = [
        'showAccounts',
    ];

    /**
     * @var bool
     */
    public bool $showingWarningDialog = false;

    public function showAccounts()
    {
        $this->showingWarningDialog = true;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return \view('livewire.admin.accounts');
    }
}

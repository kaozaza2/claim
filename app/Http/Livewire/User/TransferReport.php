<?php

namespace App\Http\Livewire\User;

use Livewire\Component;

class TransferReport extends Component
{
    protected $listeners = [
        'showTransferReport'
    ];

    public bool $showingTransferReport = false;

    public ?string $equipment_id = null;
    public ?string $sub_department_id = null;
    public ?string $user_id = null;

    public function showTransferReport()
    {
        $this->showingTransferReport = true;
    }

    public function storeTransfer()
    {
        $this->showingTransferReport = false;
    }

    public function render()
    {
        return view('livewire.user.transfer-report');
    }
}

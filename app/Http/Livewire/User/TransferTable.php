<?php

namespace App\Http\Livewire\User;

use App\Models\Transfer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransferTable extends Component
{
    public Collection $transfers;

    protected $listeners = [
        'reloadTransferTable' => '$refresh',
    ];

    public function loadTransfers()
    {
        $this->transfers = Transfer::where('user_id', Auth::user()->id)->get();
    }

    public function render()
    {
        $this->loadTransfers();
        return view('livewire.user.transfer-table');
    }
}

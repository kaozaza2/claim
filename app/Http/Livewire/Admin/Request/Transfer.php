<?php

namespace App\Http\Livewire\Admin\Request;

use App\Contracts\TransfersAccepter;
use App\Models\Transfer as TransferModel;
use Illuminate\Support\Collection;
use Livewire\Component;

class Transfer extends Component
{
    public Collection $transfers;

    protected $listeners = [
        'acceptTransfer'
    ];

    public function mount()
    {
        $this->transfers = TransferModel::all();
    }

    public function acceptTransfer(TransfersAccepter $accepter, int $index)
    {
        $accepter->accept($this->transfers->pull($index));
    }

    public function render()
    {
        return view('livewire.admin.request.transfer');
    }
}

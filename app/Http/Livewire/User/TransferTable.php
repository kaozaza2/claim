<?php

namespace App\Http\Livewire\User;

use App\Models\Transfer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class TransferTable extends Component
{
    public Collection $transfers;
    public ?Transfer $selected = null;

    public bool $confirmingCancel = false;

    protected $listeners = [
        'reloadTransferTable' => '$refresh',
    ];

    public function loadTransfers()
    {
        $this->transfers = Transfer::where('user_id', Auth::user()->id)
            ->whereNull('admin_id')
            ->get();
        if (!isset($this->selected) && $this->transfers->isNotEmpty()) {
            $this->selected = $this->transfers->first();
        }
    }

    public function render()
    {
        $this->loadTransfers();
        return view('livewire.user.transfer-table', [
            'transfers' => $this->transfers,
            'selected' => $this->selected,
        ]);
    }

    public function showCancel(string $id)
    {
        $this->selected = $this->transfers->firstWhere('id', $id);
        $this->confirmingCancel = true;
    }

    public function confirmCancel()
    {
        $this->selected->delete();
        $this->confirmingCancel = false;
    }
}

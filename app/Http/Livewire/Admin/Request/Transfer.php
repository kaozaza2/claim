<?php

namespace App\Http\Livewire\Admin\Request;

use App\Contracts\TransfersAccepter;
use App\Models\Transfer as Transfers;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Transfer extends Component
{
    public Collection $transfers;

    public $user;

    protected $listeners = [
        'accept-transfer' => 'dialog',
        'accept-transfer-callback' => 'accepted',
    ];

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->transfers = Transfers::doesntHave('archive')->get();
    }

    public function dialog(int $index): void
    {
        $transfer = $this->transfers->get($index);
        $this->emit(
            'show-confirm-dialog',
            __('app.modal.title-accept-transfer'),
            __('app.modal.msg-accept-transfer', [
                'eq' => $transfer->equipment->getName(),
                'fm' => $transfer->from->getName(),
                'to' => $transfer->to->getName(),
                'by' => $transfer->user->getName(),
            ]), [
                'emitter' => 'accept-transfer-callback',
                'params' => [$index],
            ],
        );
    }

    public function accepted(TransfersAccepter $accepter, int $index): void
    {
        $accepter->accept($transfer = $this->transfers->pull($index));
    }

    public function render()
    {
        return view('livewire.admin.request.transfer');
    }
}

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
        'accept-transfer' => 'dialog',
        'accept-transfer-callback' => 'accepted',
    ];

    public function mount(): void
    {
        $this->transfers = TransferModel::all();
    }

    public function dialog(int $index): void
    {
        $transfer = $this->transfers->get($index);
        $this->emit(
            'show-confirm-dialog',
            __('app.modal.title-accept-transfer'),
            __('app.modal.msg-accept-transfer', [
                'eq' => $transfer->equipment->getName(),
                'fm' => $transfer->fromSub->getName(),
                'to' => $transfer->toSub->getName(),
                'by' => $transfer->user->getName(),
            ]), [
                'emitter' => 'accept-transfer-callback',
                'params' => [$index],
            ],
        );
    }

    public function accepted(TransfersAccepter $accepter, int $index): void
    {
        $accepter->accept($this->transfers->pull($index));
    }

    public function render()
    {
        return view('livewire.admin.request.transfer');
    }
}

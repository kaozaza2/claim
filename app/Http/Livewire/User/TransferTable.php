<?php

namespace App\Http\Livewire\User;

use App\Models\Transfer;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class TransferTable extends Component
{
    public Collection $transfers;

    protected $listeners = [
        'user-transfer-refresh' => 'load',
        'user-transfer-cancel' => 'confirm',
        'user-transfer-cancel-submit' => 'destroy',
    ];

    public function mount(): void
    {
        $this->load();
    }

    public function render(): View
    {
        return view('livewire.user.transfer-table');
    }

    public function load(): void
    {
        $this->transfers = Transfer::currentUser()->get();
    }

    public function confirm(int $index): void
    {
        $transfer = $this->transfers->get($index);
        $this->emit(
            'show-confirm-dialog',
            __('app.modal.title-cancel-transfer'),
            __('app.modal.msg-cancel-transfer', [
                'eq' => $transfer->equipment->getName(),
                'fm' => $transfer->fromSub->getName(),
                'to' => $transfer->toSub->getName(),
            ]), [
                'emitter' => 'user-transfer-cancel-submit',
                'params' => [$index],
            ],
        );
    }

    public function destroy(int $index): void
    {
        $this->transfers->pull($index)->delete();
    }
}

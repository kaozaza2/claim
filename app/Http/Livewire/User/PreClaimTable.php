<?php

namespace App\Http\Livewire\User;

use App\Models\PreClaim;
use Illuminate\Support\Collection;
use Illuminate\View\View;
use Livewire\Component;

class PreClaimTable extends Component
{
    public Collection $pending;

    protected $listeners = [
        'user-claim-refresh' => 'load',
        'user-claim-cancel' => 'confirm',
        'user-claim-cancel-submit' => 'destroy',
    ];

    public function mount(): void
    {
        $this->load();
    }

    public function render(): View
    {
        return view('livewire.user.pre-claim-table');
    }

    public function load(): void
    {
        $this->pending = PreClaim::currentUser()->get();
    }

    public function confirm(int $index): void
    {
        $pending = $this->pending->get($index);
        $this->emit(
            'show-confirm-dialog',
            __('app.modal.title-cancel-claim'),
            __('app.modal.msg-cancel-claim', [
                'eq' => $pending->equipment->getName(),
            ]), [
                'emitter' => 'user-claim-cancel-submit',
                'params' => [$index],
            ],
        );
    }

    public function destroy(int $index): void
    {
        $this->pending->pull($index)->delete();
    }
}

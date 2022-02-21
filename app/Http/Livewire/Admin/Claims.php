<?php

namespace App\Http\Livewire\Admin;

use App\Contracts\ClaimsManager;
use App\Models\Claim;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Claims extends Component
{
    public $state = [];

    public $index = -1;

    public $claims;

    public $search = '';

    public $user;

    public $showingClaimCreate = false;

    public $showingClaimUpdate = false;

    protected $listeners = [
        'claim-table-create' => 'showCreateDialog',
        'claim-table-update' => 'showUpdateDialog',
        'claim-table-delete' => 'showDeleteDialog',
        'claim-table-toggle' => 'toggleCompleteState',
        'claim-table-delete-accept' => 'destroy',
    ];

    public function mount(): void
    {
        $this->user = Auth::user();
        $this->claims = Claim::doesntHave('archive')
            ->get()
            ->sortByDesc('id');
    }

    public function toggleCompleteState(int $index): void
    {
        $claim = $this->claims->get($index);
        $claim->update([
            'complete' => !$claim->complete,
        ]);
    }

    public function updatedSearch()
    {
        $claims = Claim::with(['equipment', 'user', 'admin'])
            ->doesntHave('archive')
            ->get();
        if (filled($search = $this->search)) {
            $claims = $claims->filter(function ($item) use ($search) {
                return $item->searchAuto($search);
            });
        }

        $this->claims = $claims->sortByDesc('id');
    }

    public function showCreateDialog(): void
    {
        $this->state = [
            'equipment_id' => Equipment::first()->id,
            'user_id' => User::member()->first()->id,
            'admin_id' => Auth::user()->id,
            'status' => 'กำลังรับเรื่อง',
        ];
        $this->showingClaimCreate = true;
    }

    public function showUpdateDialog(int $index): void
    {
        $this->index = $index;
        $claim = $this->claims->get($index);
        $this->state = $claim->attributesToArray();
        $this->showingClaimUpdate = true;
    }

    public function showDeleteDialog(int $index): void
    {
        $this->index = $index;
        $claim = $this->claims->get($index);
        $this->emit(
            'show-confirm-dialog',
            __('app.modal.title-claim-delete'),
            __('app.modal.msg-claim-delete', [
                'claim' => $claim->id,
            ]), [
                'emitter' => 'claim-table-delete-accept',
            ],
        );
    }

    public function store(ClaimsManager $manager): void
    {
        $this->claims->prepend(
            $manager->store($this->state)
        );
        $this->showingClaimCreate = false;
    }

    public function update(ClaimsManager $manager): void
    {
        $claim = $manager->update(
            $this->claims->pull($this->index),
            $this->state
        );
        $this->claims->prepend($claim);
        $this->showingClaimUpdate = false;
    }

    public function destroy(ClaimsManager $manager): void
    {
        $manager->destroy(
            $this->claims->pull($this->index)
        );
    }

    public function render()
    {
        return view('livewire.admin.claims')
            ->layout('layouts.admin');
    }
}

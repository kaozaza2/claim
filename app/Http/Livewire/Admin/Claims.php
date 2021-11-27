<?php

namespace App\Http\Livewire\Admin;

use App\Contracts\ClaimsManager;
use App\Models\Claim;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class Claims extends Component
{
    public $state = [];

    public $index = -1;

    public $claims;

    public $search = '';

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
        $this->claims = Claim::all()->sortByDesc('id');
    }

    public function toggleCompleteState(int $index): void
    {
        tap($this->claims->get($index), function ($claim) {
            $claim->complete = !$claim->complete;
            $claim->save();
        });
    }

    public function updatedSearch()
    {
        $claims = Claim::with(['equipment', 'user', 'admin'])->get();
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

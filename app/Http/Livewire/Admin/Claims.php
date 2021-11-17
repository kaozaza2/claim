<?php

namespace App\Http\Livewire\Admin;

use App\Models\Claim;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Livewire\Component;

class Claims extends Component
{
    /** @var \Illuminate\Database\Eloquent\Collection&\App\Models\Claim[]|null */
    public Collection $claims;

    /**
     * @var mixed|null
     */
    public Claim $selected;

    /**
     * @var mixed|null
     */
    public Equipment $equipment;

    /**
     * @var bool
     */
    public bool $confirmingClaimDeletion = false;

    /**
     * @var bool
     */
    public bool $showingEquipmentDetail = false;

    /**
     * @var bool
     */
    public bool $showingClaimCreate = false;

    /**
     * @var bool
     */
    public bool $showingClaimUpdate = false;

    public ?string $search = null;

    public ?string $equipment_id = null;

    public ?string $user_id = null;

    public ?string $admin_id = null;

    public ?string $problem = null;

    public ?string $status = null;

    public function render()
    {
        $this->loadClaims();
        return \view('livewire.admin.claims')
            ->layout('layouts.admin');
    }

    public function loadClaims()
    {
        $claims = Claim::all();
        if ($this->search) {
            $search = $this->search;
            $claims = $claims->filter(function ($item) use ($search) {
                return Str::any([
                    $item->equipment->name,
                    $item->equipment->brand,
                    $item->equipment->category,
                    $item->equipment->serial_number,
                    $item->problem,
                    $item->id,
                    $item->status,
                    $item->user->name,
                    $item->admin->name,
                ], fn($s) => Str::contains($s, $search));
            });
        }

        $this->claims = $claims->sortByDesc('id');
    }

    public function showEquipment(string $id)
    {
        $this->equipment = Equipment::find($id);
        $this->showingEquipmentDetail = true;
    }

    public function showCreate()
    {
        $this->reset('equipment_id', 'user_id', 'admin_id', 'problem');
        $this->fill([
            'equipment_id' => Equipment::first()->id,
            'user_id' => User::member()->first()->id,
            'admin_id' => Auth::user()->id,
            'status' => 'กำลังรับเรื่อง',
        ]);
        $this->showingClaimCreate = true;
    }

    public function storeClaim()
    {
        $validatedData = $this->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'user_id' => 'required|exists:users,id',
            'admin_id' => 'required|exists:users,id',
            'problem' => 'nullable',
            'status' => 'required',
        ]);

        Claim::create($validatedData);
        $this->showingClaimCreate = false;
    }

    public function showUpdate(string $id)
    {
        $claim = $this->claims->firstWhere('id', $id);
        $this->fill(
            $claim->only('equipment_id', 'user_id', 'admin_id', 'problem', 'status')
        );
        $this->selected = $claim;
        $this->showingClaimUpdate = true;
    }

    public function setCompleted($claimId, bool $complete)
    {
        if ($claim = Claim::find($claimId)) {
            $claim->update(['complete' => $complete]);
        }
    }

    public function updateClaim()
    {
        $validatedData = $this->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'user_id' => 'required|exists:users,id',
            'admin_id' => 'required|exists:users,id',
            'problem' => 'nullable',
            'status' => 'required',
        ]);

        $this->selected->update($validatedData);
        $this->showingClaimUpdate = false;
    }

    public function confirmDeletion(string $id)
    {
        $this->selected = $this->claims->firstWhere('id', $id);
        $this->confirmingClaimDeletion = true;
    }

    public function deleteClaim()
    {
        $this->selected->delete();
        $this->confirmingClaimDeletion = false;
    }
}

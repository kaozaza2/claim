<?php

namespace App\Http\Livewire\Admin;

use App\Models\Claim;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Livewire\Component;

class Claims extends Component
{
    /** @var Collection<Claim> */
    public Collection $claims;
    public Claim $selected;
    public Equipment $equipment;

    public bool $confirmingClaimDeletion = false;
    public bool $showingEquipmentDetail = false;
    public bool $showingClaimCreate = false;
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
        return view('livewire.admin.claims')
            ->layout('layouts.admin');
    }

    public function loadClaims()
    {
        $claims = Claim::all();
        if ($this->search) {
            $search = $this->search;
            $claims = $claims->filter(function ($item) use ($search) {
                return Str::contains($item->equipment->name, $search)
                    || Str::contains($item->equipment->serial_number, $search)
                    || Str::contains($item->problem, $search)
                    || Str::contains($item->id, $search)
                    || Str::contains($item->status, $search)
                    || Str::contains($item->user->name, $search)
                    || Str::contains($item->admin->name, $search);
            });
        }
        $this->claims = $claims->keyBy('id');
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
            'admin_id' => Auth::user()->isSuperAdmin() ? User::admin()->first()->id : Auth::user()->id,
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

        $claim = Claim::create($validatedData);
        $this->notify($claim);
        $this->showingClaimCreate = false;
    }

    public function showUpdate(string $id)
    {
        $this->selected = Claim::find($id);
        $this->fill([
            'equipment_id' => $this->selected->equipment_id,
            'user_id' => $this->selected->user_id,
            'admin_id' => $this->selected->admin_id,
            'problem' => $this->selected->problem,
            'status' => $this->selected->status,
        ]);
        $this->showingClaimUpdate = true;
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
        $this->notify($this->selected);
        $this->showingClaimUpdate = false;
    }

    public function confirmDeletion(string $id)
    {
        $this->selected = Claim::find($id);
        $this->confirmingClaimDeletion = true;
    }

    public function deleteClaim()
    {
        $this->selected->delete();
        $this->confirmingClaimDeletion = false;
    }

    private function notify(Claim $claim)
    {
        $message = "เลขที่เคลม: $claim->id\n"
            . "อุปกรณ์ที่เคลม: [{$claim->equipment->id}] {$claim->equipment->name}\n"
            . "เลขครุภัณฑ์: {$claim->equipment->serial_number}\n"
            . "อาการเสีย: $claim->problem\n"
            . "ผู้แจ้งเคลม: {$claim->user->fullname}\n"
            . "ผู้รับเรื่อง: {$claim->admin->fullname}\n"
            . "สถานะ: $claim->status";

        Http::withToken(config('line.token'))
            ->asForm()
            ->post( 'https://notify-api.line.me/api/notify', [
                'message' => $message,
            ]);
    }
}

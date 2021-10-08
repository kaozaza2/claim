<?php

namespace App\Http\Livewire\Admin;

use App\Models\Equipment;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class Equipments extends Component
{
    /** @var Collection<Equipment> */
    public Collection $equipments;
    public Equipment $selected;

    public bool $confirmingEquipmentDeletion = false;
    public bool $showingEquipmentUpdate = false;
    public bool $showingEquipmentCreate = false;
    public bool $showingEquipmentPicture = false;

    public ?string $name = null;
    public ?string $detail = null;
    public ?string $search = null;

    public function render()
    {
        $this->loadEquipments();
        return view('livewire.admin.equipments')
            ->layout('layouts.admin');
    }

    private function loadEquipments()
    {
        $equipments = Equipment::all();
        if ($this->search != null) {
            $search = $this->search;
            $equipments = $equipments->filter(function ($item) use ($search) {
                return Str::contains($item->name, $search)
                    || Str::contains($item->detail, $search)
                    || Str::contains($item->id, $search);
            });
        }
        $this->equipments = $equipments->keyBy('id');
    }

    public function showPicture(string $id)
    {
        $this->selected = Equipment::find($id);
        $this->showingEquipmentPicture = true;
    }

    public function showCreate()
    {
        $this->showingEquipmentCreate = true;
        $this->reset('name', 'detail');
    }

    public function storeEquipment()
    {
        $validateData = $this->validate([
            'name' => 'required',
            'detail' => 'nullable',
        ]);

        Equipment::create($validateData);
        $this->showingEquipmentCreate = false;
    }

    public function showUpdate(string $id)
    {
        $this->selected = Equipment::find($id);
        $this->name = $this->selected->name;
        $this->detail = $this->selected->detail;
        $this->resetErrorBag();
        $this->showingEquipmentUpdate = true;
    }

    public function updateEquipment()
    {
        $validateData = $this->validate([
            'name' => 'required',
            'detail' => 'nullable',
        ]);

        $this->selected->update($validateData);
        $this->showingEquipmentUpdate = false;
    }

    public function confirmDeletion(string $id)
    {
        $this->selected = Equipment::find($id);
        $this->confirmingEquipmentDeletion = true;
    }

    public function deleteEquipment()
    {
        $this->selected->claim()->delete();
        $this->selected->delete();
        $this->confirmingEquipmentDeletion = false;
    }
}

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
    public ?string $serial_number = null;
    public ?string $detail = null;
    public ?string $brand = null;
    public ?string $category = null;
    public ?string $search = null;

    public function render()
    {
        $this->loadEquipments();
        return view('livewire.admin.equipments', [
            'equipments' => $this->equipments->take(10),
        ])->layout('layouts.admin');
    }

    private function loadEquipments()
    {
        $equipments = Equipment::all();
        if ($this->search != null) {
            $search = $this->search;
            $equipments = $equipments->filter(function ($item) use ($search) {
                return Str::any([
                    $item->name,
                    $item->detail,
                    $item->serial_number,
                    $item->id,
                ], fn($s) => Str::contains($s, $search));
            });
        }
        $this->equipments = $equipments;
    }

    public function showPicture(string $id)
    {
        $this->selected = $this->equipments->firstWhere('id', $id);
        $this->showingEquipmentPicture = true;
    }

    public function showCreate()
    {
        $this->showingEquipmentCreate = true;
        $this->reset('name', 'serial_number', 'detail', 'brand', 'category');
    }

    public function storeEquipment()
    {
        $validateData = $this->validate([
            'name' => 'required',
            'serial_number' => 'nullable',
            'detail' => 'nullable',
            'brand' => 'nullable',
            'category' => 'nullable',
        ]);

        Equipment::create($validateData);
        $this->showingEquipmentCreate = false;
    }

    public function showUpdate(string $id)
    {
        $this->selected = $this->equipments->firstWhere('id', $id);
        $this->fill([
            'name' => $this->selected->name,
            'serial_number' => $this->selected->serial_number,
            'detail' => $this->selected->detail,
            'brand' => $this->selected->brand,
            'category' => $this->selected->category,
        ]);
        $this->resetErrorBag();
        $this->showingEquipmentUpdate = true;
    }

    public function updateEquipment()
    {
        $validateData = $this->validate([
            'name' => 'required',
            'serial_number' => 'nullable',
            'detail' => 'nullable',
            'brand' => 'nullable',
            'category' => 'nullable',
        ]);

        $this->selected->update($validateData);
        $this->showingEquipmentUpdate = false;
    }

    public function confirmDeletion(string $id)
    {
        $this->selected = $this->equipments->firstWhere('id', $id);
        $this->confirmingEquipmentDeletion = true;
    }

    public function deleteEquipment()
    {
        $this->selected->claim()->delete();
        $this->selected->delete();
        $this->confirmingEquipmentDeletion = false;
    }
}

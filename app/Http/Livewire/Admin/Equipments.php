<?php

namespace App\Http\Livewire\Admin;

use App\Contracts\CreatesEquipments;
use App\Contracts\DeletesEquipments;
use App\Contracts\UpdatesEquipmentsInformation;
use App\Models\Equipment;
use App\Models\SubDepartment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

class Equipments extends Component
{
    use WithFileUploads;

    public Collection $equipments;

    public bool $confirmingEquipmentDeletion = false;
    public bool $showingEquipmentUpdate = false;
    public bool $showingEquipmentCreate = false;
    public bool $showingEquipmentPicture = false;

    public ?string $selectedId = null;
    public array $state = [];
    /** @var UploadedFile|string|null */
    public $picture;

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

        if (!$this->selectedId) {
            $equipment = $this->equipment;
            $this->selectedId = $equipment->id;
            $this->state = $equipment->withoutRelations()->toArray();
        }
    }

    public function showPicture(string $id)
    {
        $this->selectedId = $id;
        $this->showingEquipmentPicture = true;
    }

    public function showCreate()
    {
        $this->state = [];
        $this->showingEquipmentCreate = true;
    }

    public function storeEquipment(CreatesEquipments $creator)
    {
        $creator->create(
            $this->picture
                ? array_merge($this->state, ['picture' => $this->picture])
                : $this->state
        );
        $this->showingEquipmentCreate = false;
    }

    public function getEquipmentProperty()
    {
        return Equipment::find($this->selectedId)
            ?: Equipment::first();
    }

    public function getSubDepartmentsProperty()
    {
        return SubDepartment::all();
    }

    public function showUpdate(string $id)
    {
        $this->selectedId = $id;
        $this->state = $this->equipment->withoutRelations()->toArray();
        $this->resetErrorBag();
        $this->showingEquipmentUpdate = true;
    }

    public function updateEquipment(UpdatesEquipmentsInformation $updater)
    {
        $updater->update(
            $this->equipment,
            $this->picture
                ? array_merge($this->state, ['picture' => $this->picture])
                : $this->state
        );

        $this->showingEquipmentUpdate = false;
    }

    public function confirmDeletion(string $id)
    {
        $this->selectedId = $id;
        $this->confirmingEquipmentDeletion = true;
    }

    public function deleteEquipment(DeletesEquipments $deleter)
    {
        $deleter->delete($this->equipment);
        $this->confirmingEquipmentDeletion = false;
    }
}

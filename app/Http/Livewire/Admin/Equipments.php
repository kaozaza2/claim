<?php

namespace App\Http\Livewire\Admin;

use App\Contracts\CreatesEquipments;
use App\Contracts\DeletesEquipments;
use App\Contracts\UpdatesEquipments;
use App\Models\Equipment;
use App\Models\SubDepartment;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;

/**
 * @property Collection<SubDepartment> $sub_departments
 */
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
    public $picture = null;

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
                    $item->brand,
                    $item->category,
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
        return optional(Equipment::find($this->selectedId));
    }

    public function getSubDepartmentsProperty()
    {
        return SubDepartment::all();
    }

    public function showUpdate(string $id)
    {
        $equipment = Equipment::find($id);
        $this->selectedId = $id;
        $this->state = $equipment->withoutRelations()->toArray();
        $this->resetErrorBag();
        $this->showingEquipmentUpdate = true;
    }

    public function updateEquipment(UpdatesEquipments $updater)
    {
        $updater->update(
            Equipment::find($this->selectedId),
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
        $deleter->delete(Equipment::find($this->selectedId));
        $this->confirmingEquipmentDeletion = false;
    }
}

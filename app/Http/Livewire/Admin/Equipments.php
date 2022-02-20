<?php

namespace App\Http\Livewire\Admin;

use App\Contracts\CreatesEquipments;
use App\Contracts\DeletesEquipments;
use App\Contracts\EquipmentsArchivers;
use App\Contracts\UpdatesEquipments;
use App\Models\Equipment;
use App\Models\SubDepartment;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithFileUploads;

class Equipments extends Component
{
    use WithFileUploads;

    public Collection $equipments;

    public Collection $subs;

    public bool $updating = false;

    public bool $creating = false;

    public int $index = 0;

    public array $state = [];

    public ?string $search = null;

    protected $listeners = [
        'admin-equipment-create' => 'create',
        'admin-equipment-update' => 'show',
        'admin-equipment-delete' => 'delete',
        'admin-equipment-archive' => 'showArchive',
        'admin-equipment-delete-confirm' => 'destroy',
        'admin-equipment-archive-accept' => 'archive',
    ];

    public function render()
    {
        return view('livewire.admin.equipments')
            ->layout('layouts.admin');
    }

    public function mount(): void
    {
        $this->subs = SubDepartment::all();
        $this->load();
    }

    public function load(): void
    {
        $equipments = Equipment::doesntHave('archive')->get();
        if (filled($search = $this->search)) {
            $equipments = $equipments->filter(function ($item) use ($search) {
                return $item->searchAuto($search);
            });
        }
        $this->equipments = $equipments;
    }

    public function updatedSearch(): void
    {
        $this->load();
    }

    public function create(): void
    {
        $this->state = [];
        $this->creating = true;
    }

    public function store(CreatesEquipments $creator): void
    {
        $this->equipments->prepend(
            $creator->create($this->state)
        );
        $this->creating = false;
    }

    public function show(int $index): void
    {
        $this->resetErrorBag();
        $equipment = $this->equipments->get(
            $this->index = $index
        );
        $this->state = $equipment->attributesToArray();
        $this->updating = true;
    }

    public function update(UpdatesEquipments $updater): void
    {
        $updater->update(
            $this->equipments->get($this->index), $this->state
        );
        $this->load();
        $this->updating = false;
    }

    public function showArchive($index)
    {
        $this->emit('show-confirm-dialog', __('app.retirement'), __('app.retirement.message'), [
            'emitter' => 'admin-equipment-archive-accept',
            'params' => [$index],
        ]);
    }

    public function archive(EquipmentsArchivers $archiver, $index): void
    {
        $archiver->archive(
            $this->equipments->pull($index)
        );
    }

    public function delete(int $index): void
    {
        $equipment = $this->equipments->get($index);
        $this->emit(
            'show-confirm-dialog',
            __('app.modal.title-delete', [
                'name' => $equipment->name,
            ]),
            __('app.modal.msg-delete', [
                'name' => $equipment->full_details,
            ]), [
            'emitter' => 'admin-equipment-delete-confirm',
            'params' => [$index],
        ],
        );
    }

    public function destroy(DeletesEquipments $deleter, int $index): void
    {
        $deleter->delete(
            $this->equipments->pull($index)
        );
    }
}

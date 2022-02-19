<?php

namespace App\Http\Livewire\Admin;

use App\Contracts\DeletesEquipments;
use App\Contracts\EquipmentsArchivers;
use App\Models\Equipment;
use Livewire\Component;
use Livewire\WithPagination;

class Archives extends Component
{
    use WithPagination;

    public $equipments;

    protected $listeners = [
        'recover', 'delete',
    ];

    public function mount()
    {
        $this->equipments = Equipment::has('archive')->get();
    }

    public function recover(EquipmentsArchivers $archiver, $index)
    {
        $archiver->recover(
            $this->equipments->pull($index)
        );
    }

    public function delete(DeletesEquipments $deleter, $index)
    {
        $deleter->delete(
            $this->equipments->pull($index)
        );
    }

    public function render()
    {
        return view('livewire.admin.archives')
            ->layout('layouts.admin');
    }
}

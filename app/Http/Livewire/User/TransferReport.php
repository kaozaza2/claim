<?php

namespace App\Http\Livewire\User;

use App\Models\Equipment;
use App\Models\SubDepartment;
use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class TransferReport extends Component
{
    protected $listeners = [
        'showTransferReport'
    ];

    public bool $showingTransferReport = false;

    public ?string $equipment_id = null;
    public ?string $to_sub_department_id = null;

    public function showTransferReport()
    {
        $this->equipment_id = Equipment::whereSubDepartment()->first()->id;
        $this->to_sub_department_id = SubDepartment::first()->id;
        $this->showingTransferReport = true;
    }

    public function storeTransfer()
    {
        $validatedData = $this->validate([
            'equipment_id' => [
                'required',
                Rule::exists('equipments', 'id')->where('sub_department_id', Auth::user()->sub_department_id)
            ],
            'to_sub_department_id' => [
                'required',
                Rule::unique('users', 'sub_department_id')->where('id', Auth::user()->id)
            ],
        ], [
            'exists' => Equipment::find($this->equipment_id)->name . ' is not exists',
            'unique' => Equipment::find($this->equipment_id)->name . ' is already in ' . SubDepartment::find($this->to_sub_department_id)->name,
        ]);

        $equipment = Equipment::find($validatedData['equipment_id']);

        Transfer::create([
            'equipment_id' => $validatedData['equipment_id'],
            'to_sub_department_id' => $validatedData['to_sub_department_id'],
            'from_sub_department_id' => $equipment->sub_department_id,
            'user_id' => Auth::user()->id,
        ]);
        $this->showingTransferReport = false;
        $this->emit('reloadTransferTable');
    }

    public function render()
    {
        return view('livewire.user.transfer-report');
    }
}

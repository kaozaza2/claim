<?php

namespace App\Http\Livewire\User;

use App\Jobs\SendLineNotify;
use App\Models\Equipment;
use App\Models\SubDepartment;
use App\Models\Transfer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class TransferReport extends Component
{
    protected $listeners = [
        'showTransferReport'
    ];

    public Collection $equipments;
    public Collection $subDepartments;

    public bool $showingTransferReport = false;

    public ?string $equipment_id = null;
    public ?string $to_sub_department_id = null;

    public function showTransferReport()
    {
        $this->equipment_id = $this->equipments->first()->id;
        $this->to_sub_department_id = SubDepartment::first()->id;
        $this->showingTransferReport = true;
    }

    public function storeTransfer()
    {
        $validatedData = $this->validate([
            'equipment_id' => [
                'required',
                Auth::user()->isAdmin()
                    ? Rule::exists('equipments', 'id')
                    : Rule::exists('equipments', 'id')->where('sub_department_id', Auth::user()->sub_department_id)
            ],
            'to_sub_department_id' => [
                'required',
                Rule::unique('users', 'sub_department_id')->where('id', Auth::user()->id)
            ],
        ], [
            'exists' => Equipment::find($this->equipment_id)->name . ' is not exists',
            'unique' => Equipment::find($this->equipment_id)->name . ' is already in '
                . SubDepartment::find( $this->to_sub_department_id)->name,
        ]);

        $equipment = Equipment::find($validatedData['equipment_id']);

        $transfer = Transfer::create([
            'equipment_id' => $validatedData['equipment_id'],
            'to_sub_department_id' => $validatedData['to_sub_department_id'],
            'from_sub_department_id' => $equipment->sub_department_id,
            'user_id' => Auth::user()->id,
        ]);
        $this->showingTransferReport = false;
        $this->emit('reloadTransferTable');

        $this->sendMessage($transfer);
    }

    public function render()
    {
        if (Auth::user()->isAdmin()) {
            $this->equipments = Equipment::all()->keyBy('id');
        } else {
            $this->equipments = Equipment::whereSubDepartment()->get()
                ->keyBy('id');
        }
        $this->subDepartments = SubDepartment::all()->keyBy('id');
        return view('livewire.user.transfer-report');
    }

    private function sendMessage(Transfer $transfer)
    {
        $message = sprintf(
            "แจ้งย้าย\nอุปกรณ์ที่แจ้ง: %s\nเลขครุภัณฑ์: %s\nแจ้งโดย: %s\nจากแผนก: %s\nไปแผนก: %s",
            $transfer->equipment->name,
            $transfer->equipment->serial_number,
            $transfer->user->name,
            $transfer->fromSub->name,
            $transfer->toSub->name,
        );

        SendLineNotify::dispatch($message);
    }
}

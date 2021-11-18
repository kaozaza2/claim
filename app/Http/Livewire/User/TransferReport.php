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

class   TransferReport extends Component
{
    /**
     * @var string[]
     */
    protected $listeners = [
        'showTransferReport'
    ];

    /**
     * @var \Illuminate\Database\Eloquent\Collection&\App\Models\Equipment[]|mixed|null
     */
    public Collection $equipments;

    /**
     * @var \Illuminate\Database\Eloquent\Collection&\App\Models\SubDepartment[]|mixed|null
     */
    public Collection $subDepartments;

    /**
     * @var bool
     */
    public bool $showingTransferReport = false;

    public ?string $equipment_id = null;

    public ?string $to_sub_department_id = null;

    public function showTransferReport(): void
    {
        if ($this->equipments->isEmpty()) {
            return;
        }

        $this->equipment_id = $this->equipments->first()->id;
        $this->to_sub_department_id = $this->subDepartments
            ? $this->subDepartments->first()->id
            : SubDepartment::first()->id;
        $this->showingTransferReport = true;
    }

    public function storeTransfer(): void
    {
        $validatedData = $this->validate([
            'equipment_id' => [
                'required',
                Auth::user()->isAdmin()
                    ? Rule::exists('equipments', 'id')
                    : Rule::exists('equipments', 'id')->where('sub_department_id', Auth::user()->sub_department_id),
                Rule::unique('transfers')->where('user_id', Auth::user()->id)->whereNull('admin_id'),
            ],
            'to_sub_department_id' => [
                'required',
                Rule::unique('equipments', 'sub_department_id')->where('id', $this->equipment_id)
            ],
        ], [
            'equipment_id.exists' => 'ไม่พบ ' . $this->equipments->firstWhere('id', $this->equipment_id)->name,
            'equipment_id.unique' => $this->equipments->firstWhere('id', $this->equipment_id)->name . ' แจ้งย้ายไว้แล้ว',
            'to_sub_department_id.unique' => $this->equipments->firstWhere('id', $this->equipment_id)->name . ' อยู่ในแผนก '
                . SubDepartment::find($this->to_sub_department_id)->name . ' อยู่แล้ว',
        ]);

        $equipment = $this->equipments->firstWhere('id', $validatedData['equipment_id']);

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

    public function updated($propertyName): void
    {
        if ($propertyName == 'equipment_id') {
            $equipment = $this->equipments->firstWhere('id', $this->equipment_id);
            $this->subDepartments = SubDepartment::where('id', '!=', $equipment->sub_department_id)->get();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        $this->equipments = Auth::user()->isAdmin()
            ? Equipment::all()
            : Equipment::whereSubDepartment()->get();
        if (!isset($this->subDepartments)) {
            $this->subDepartments = SubDepartment::all();
        }

        return \view('livewire.user.transfer-report');
    }

    private function sendMessage(Transfer $transfer): void
    {
        $message = \sprintf(
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

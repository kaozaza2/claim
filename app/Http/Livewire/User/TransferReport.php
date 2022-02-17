<?php

namespace App\Http\Livewire\User;

use App\Jobs\SendLineNotify;
use App\Models\Equipment;
use App\Models\SubDepartment;
use App\Models\Transfer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class TransferReport extends Component
{
    protected $listeners = [
        'user-transfer-create' => 'dialog',
    ];

    public Collection $equipments;

    public Collection $subs;

    public bool $showing = false;

    public array $state = [];

    public function mount(): void
    {
        $this->load();
    }

    public function load(): void
    {
        $this->subs = SubDepartment::all();
        
        if (($user = Auth::user())->isAdmin()) {
            $this->equipments = Equipment::all()->keyBy('id');
            return;
        }

        $this->equipments = Equipment::whereSubDepartmentId(
            $user->sub_department_id
        )->get()->keyBy('id');
    }

    public function dialog(): void
    {
        if (filled($this->equipments)) {
            $this->state = [
                'equipment' => $this->equipments->first()->id,
                'to' => $this->subs->first()->id
            ];
            $this->showing = true;
        }
    }

    public function store(): void
    {
        $equipment = Equipment::find($this->state['equipment']);
        $validated = validator($this->state, [
            'equipment' => [
                'required',
                Auth::user()->isAdmin()
                    ? Rule::exists('equipments', 'id')
                    : Rule::exists('equipments', 'id')
                        ->where('sub_department_id', Auth::user()->sub_department_id),
                Rule::unique('transfers', 'equipment_id')
                    ->where('user_id', Auth::user()->id),
            ],
            'to' => [
                'required',
                Rule::unique('equipments', 'sub_department_id')
                    ->where('id', $this->state['equipment']),
            ],
        ], [
            'equipment.exists' => 'ไม่พบครุภัณฑ์',
            'equipment.unique' => 'ครุภัณฑ์ได้ถูกแจ้งย้ายไว้ก่อนแล้ว',
            'to.unique' => 'ครุภัณฑ์อยู่ในแผนกดังกล่าวอยู่แล้ว',
        ])->validated();

        $transfer = (new Transfer)->forceFill([
            'equipment_id' => $validated['equipment'],
            'to_sub_department_id' => $validated['to'],
            'from_sub_department_id' => $equipment->sub_department_id,
            'user_id' => Auth::user()->id,
        ]);
        $transfer->save();

        $this->showing = false;
        $this->emit('user-transfer-refresh');
        $this->sendMessage($transfer);
    }

    public function updatedStateEquipment(): void
    {
        $equipment = Equipment::find($this->state['equipment']);
        $this->subs = SubDepartment::with('department')->where('id', '!=', $equipment->sub_department_id)->get();
        if (array_key_exists('to', $this->state) && $this->state['to'] === $equipment->sub_department_id) {
            $this->state['to'] = $this->subs->first()->id;
        }
    }

    public function render(): View
    {
        return view('livewire.user.transfer-report');
    }

    private function sendMessage(Transfer $transfer): void
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

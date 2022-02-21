<?php

namespace App\Http\Livewire\User;

use App\Jobs\SendLineNotify;
use App\Models\Equipment;
use App\Models\PreClaim;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class ClaimReport extends Component
{
    public Collection $equipments;
    public bool $showing = false;
    public array $state = [];
    protected $listeners = [
        'user-claim-create' => 'dialog',
    ];

    public function mount(): void
    {
        $this->load();
    }

    public function load(): void
    {
        if (($user = Auth::user())->isAdmin()) {
            $this->equipments = Equipment::all();
            return;
        }

        $this->equipments = Equipment::whereSubDepartmentId(
            $user->sub_department_id
        )->get();
    }

    public function dialog(): void
    {
        if (filled($this->equipments)) {
            $this->state = ['equipment' => $this->equipments->first()->id];
            $this->showing = true;
        }
    }

    public function store(): void
    {
        $user = Auth::user();
        $equipment = $this->equipments->firstWhere('id', $this->state['equipment']);
        $validated = validator($this->state, [
            'equipment' => [
                'required',
                Rule::exists('equipments', 'id')->where(function ($query) use ($user) {
                    if (!$user->isAdmin()) {
                        $query->where('sub_department_id', $user->sub_department_id);
                    }
                }),
                Rule::notIn(
                    PreClaim::doesntHave('archive')
                        ->currentUser()
                        ->get()
                        ->map(function ($claim) {
                            return $claim->equipment_id;
                        })
                ),
            ],
            'problem' => ['nullable'],
        ], [
            'equipment.exists' => __('app.validation.equipment.exists', ['eq' => $equipment->name]),
            'equipment.not_in' => __('app.validation.equipment.unique', ['eq' => $equipment->name]),
        ])->validated();

        $claim = (new PreClaim)->forceFill([
            'equipment_id' => $validated['equipment'],
            'problem' => $validated['problem'] ?? null,
            'user_id' => $user->id,
        ]);
        $claim->save();

        $this->showing = false;
        $this->emit('user-claim-refresh');
        $this->sendMessage($claim);
    }

    private function sendMessage(PreClaim $claim): void
    {
        $message = sprintf(
            "แจ้งซ่อม\nอุปกรณ์ที่แจ้ง: %s\nเลขครุภัณฑ์: %s\nแจ้งโดย: %s\nอาการเสีย: %s",
            $claim->equipment->name,
            $claim->equipment->serial_number,
            $claim->user->name,
            $claim->problem,
        );

        SendLineNotify::dispatch($message);
    }

    public function render(): View
    {
        return view('livewire.user.claim-report');
    }
}

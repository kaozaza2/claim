<?php

namespace App\Http\Livewire\User;

use App\Jobs\SendLineNotify;
use App\Models\Equipment;
use App\Models\PreClaim;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ClaimReport extends Component
{
    protected $listeners = [
        'showClaimReport',
    ];

    public Collection $equipments;

    public bool $showingClaimReport = false;

    public ?string $equipment_id = null;
    public ?string $problem = null;

    public function showClaimReport()
    {
        $this->equipment_id = $this->equipments->first()->id;
        $this->showingClaimReport = true;
    }

    public function storePreClaim()
    {
        $validatedData = $this->validate([
            'equipment_id' => [
                'required',
                Auth::user()->isAdmin()
                    ? Rule::exists('equipments', 'id')
                    : Rule::exists('equipments', 'id')->where('sub_department_id', Auth::user()->sub_department_id),
            ],
            'problem' => ['nullable'],
        ], [
            'exists' => Equipment::find($this->equipment_id)->name . ' is not exists',
        ]);

        $claim = PreClaim::create([
            'equipment_id' => $validatedData['equipment_id'],
            'problem' => $validatedData['problem'],
            'user_id' => Auth::user()->id,
        ]);
        $this->showingClaimReport = false;
        $this->emit('reloadPreClaimTable');

        $this->sendMessage($claim);
    }

    public function render()
    {
        $this->equipments = Auth::user()->isAdmin()
            ? Equipment::all()->keyBy('id')
            : Equipment::whereSubDepartment()->get()->keyBy('id');
        return view('livewire.user.claim-report');
    }

    private function sendMessage(PreClaim $claim)
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
}

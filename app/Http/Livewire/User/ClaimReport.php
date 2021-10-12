<?php

namespace App\Http\Livewire\User;

use App\Models\Equipment;
use App\Models\PreClaim;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ClaimReport extends Component
{
    protected $listeners = [
        'showClaimReport',
    ];

    public bool $showingClaimReport = false;

    public ?string $equipment_id = null;
    public ?string $problem = null;

    public function showClaimReport()
    {
        $this->equipment_id = Equipment::whereSubDepartment()->first()->id;
        $this->showingClaimReport = true;
    }

    public function storePreClaim()
    {
        $validatedData = $this->validate([
            'equipment_id' => [
                'required',
                Rule::exists('equipments', 'id')->where('sub_department_id', Auth::user()->sub_department_id),
            ],
            'problem' => ['nullable'],
        ], [
            'exists' => Equipment::find($this->equipment_id)->name . ' is not exists',
        ]);

        PreClaim::create([
            'equipment_id' => $validatedData['equipment_id'],
            'problem' => $validatedData['problem'],
            'user_id' => Auth::user()->id,
        ]);
        $this->showingClaimReport = false;
        $this->emit('reloadPreClaimTable');
    }

    public function render()
    {
        return view('livewire.user.claim-report');
    }
}

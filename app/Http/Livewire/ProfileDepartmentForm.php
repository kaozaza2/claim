<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\SubDepartment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Livewire\Component;

class ProfileDepartmentForm extends Component
{
    public array $state = [];

    public function mount(): void
    {
        $user = Auth::user();
        $this->state = [
            'department' => $user->subDepartment->department->id,
            'sub_department' => $user->subDepartment->id,
        ];
    }

    public function updatedStateDepartment(): void
    {
        if ($sub = SubDepartment::whereDepartment($this->state['department'])->first()) {
            $this->state['sub_department'] = $sub->id;
        }
    }

    public function render(): View
    {
        return view('profile.profile-department-form');
    }

    public function updateDepartment(): void
    {
        validator($this->state, [
            'department' => [
                'required',
                Rule::exists('departments', 'id'),
            ],
            'sub_department' => [
                'required',
                Rule::exists('sub_departments', 'id')->where('department_id', $this->state['department']),
            ],
        ])->validated();

        Auth::user()->update([
            'sub_department_id' => $this->state['sub_department'],
        ]);

        $this->emit('saved');
    }
}

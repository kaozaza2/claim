<?php

namespace App\Http\Livewire;

use App\Models\Department;
use App\Models\SubDepartment;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Livewire\Component;

class ProfileDepartmentForm extends Component
{
    public $state = [];

    public function mount()
    {
        $user = Auth::user();
        $this->state = [
            'department' => $user->subDepartment->department->id,
            'sub_department' => $user->subDepartment->id,
        ];
    }

    public function updated($property)
    {
        if ($property == 'state.department') {
            if ($sub = SubDepartment::whereDepartment($this->state['department'])->first()) {
                $this->state['sub_department'] = $sub->id;
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function render()
    {
        return \view('profile.profile-department-form');
    }

    public function updateDepartment()
    {
        \validator($this->state, [
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

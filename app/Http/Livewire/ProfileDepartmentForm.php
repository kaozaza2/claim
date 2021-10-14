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
    public Collection $departments;
    public Collection $subDepartments;

    public $department;
    public $sub_department_id;

    public function mount()
    {
        $depId = Auth::user()->subDepartment->department->id;
        $this->departments = Department::all();
        $this->subDepartments = SubDepartment::whereHas('department', function ($query) use ($depId) {
            $query->where('department_id', $depId);
        })->get();
        $this->department = $depId;
        $this->sub_department_id = Auth::user()->sub_department_id;
    }

    public function updated($propertyName)
    {
        if ($propertyName == 'department') {
            $depId = $this->department;
            $this->subDepartments = SubDepartment::whereHas('department', function ($query) use ($depId) {
                $query->where('department_id', $depId);
            })->get();
        }
    }

    public function render()
    {
        return view('profile.profile-department-form', [
            'departments' => $this->departments,
            'subDepartments' => $this->subDepartments,
        ]);
    }

    public function updateDepartment()
    {
        $this->validate([
            'department' => [
                'required',
                Rule::exists('departments', 'id'),
            ],
            'sub_department_id' => [
                'required',
                Rule::exists('sub_departments', 'id')->where('department_id', $this->department),
            ],
        ]);

        Auth::user()->update([
            'sub_department_id' => $this->sub_department_id,
        ]);

        $this->emit('saved');
    }
}

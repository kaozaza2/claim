<?php

namespace App\Http\Livewire\Admin;

use App\Models\Department;
use App\Models\SubDepartment;
use Illuminate\Support\Collection;
use Livewire\Component;

class Departments extends Component
{
    /** @var Collection<Department> */
    public Collection $departments;
    public Department $selected;
    public SubDepartment $subSelected;

    public bool $confirmingDepartmentDeletion = false;

    public function render()
    {
        $this->loadDepartments();
        return view('livewire.admin.departments')
            ->layout('layouts.admin');
    }

    private function loadDepartments()
    {
        $this->departments = Department::all();
    }

    public function confirmDeletion(string $id)
    {
        $this->selected = Department::find($id);
        $this->confirmingDepartmentDeletion = true;
    }

    public function deleteDepartment()
    {
        $this->selected->subs()->delete();
        $this->selected->delete();
        $this->confirmingDepartmentDeletion = false;
    }
}

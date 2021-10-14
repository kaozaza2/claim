<?php

namespace App\Http\Livewire\Admin;

use App\Models\Department;
use App\Models\SubDepartment;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;

class Departments extends Component
{
    /** @var Collection<Department> */
    public Collection $departments;
    public Department $selected;
    public SubDepartment $subSelected;

    public bool $showingErrorMessage = false;
    public bool $showingDepartmentCreate = false;
    public bool $showingSubDepartmentCreate = false;
    public bool $showingDepartmentUpdate = false;
    public bool $showingSubDepartmentUpdate = false;
    public bool $confirmingDepartmentDeletion = false;
    public bool $confirmingSubDepartmentDeletion = false;

    public ?string $errorMessage = null;
    public ?string $name = null;
    public ?string $department_id = null;
    public ?string $search = null;

    public function render()
    {
        $this->loadDepartments();
        return view('livewire.admin.departments')
            ->layout('layouts.admin');
    }

    private function loadDepartments()
    {
        $departments = Department::all();
        if ($this->search != null) {
            $search = $this->search;
            $departments = $departments->filter(function ($i) use ($search) {
                return Str::contains($i->id, $search)
                    || Str::contains($i->name, $search)
                    || $i->subs->contains(function ($s) use ($search) {
                        return Str::contains($s->id, $search)
                            || Str::contains($s->name, $search);
                    });
            });
        }
        $this->departments = $departments;
    }

    public function showErrorMessage(string $message)
    {
        $this->errorMessage = $message;
        $this->showingErrorMessage = true;
    }

    public function confirmDeletion(string $id)
    {
        $this->selected = $this->departments->firstWhere('id', $id);
        if ($this->selected->subs->contains(function ($s) {
            return $s->users->isNotEmpty();
        })) {
            $this->showErrorMessage('ไม่สามารถลบได้เนื่องจากถูกใช้งานอยู่');
            return;
        }
        $this->confirmingDepartmentDeletion = true;
    }

    public function deleteDepartment()
    {
        $this->selected->subs()->delete();
        $this->selected->delete();
        $this->confirmingDepartmentDeletion = false;
    }

    public function confirmSubDeletion(string $id)
    {
        $this->subSelected = SubDepartment::find($id);
        if ($this->subSelected->users->isNotEmpty()) {
            $this->showErrorMessage('ไม่สามารถลบได้เนื่องจากถูกใช้งานอยู่');
            return;
        }
        $this->confirmingSubDepartmentDeletion = true;
    }

    public function deleteSubDepartment()
    {
        $this->subSelected->delete();
        $this->confirmingSubDepartmentDeletion = false;
    }

    public function showCreate()
    {
        $this->reset('name');
        $this->showingDepartmentCreate = true;
    }

    public function storeDepartment()
    {
        $validatedData = $this->validate([
            'name' => 'required',
        ]);

        Department::create($validatedData);
        $this->showingDepartmentCreate = false;
    }

    public function showSubCreate(string $id)
    {
        $this->reset('name');
        $this->department_id = $id;
        $this->showingSubDepartmentCreate = true;
    }

    public function storeSubDepartment()
    {
        $validatedData = $this->validate([
            'name' => 'required',
            'department_id' => 'required|exists:departments,id',
        ]);

        SubDepartment::create($validatedData);
        $this->showingSubDepartmentCreate = false;
    }

    public function showUpdate(string $id)
    {
        $this->reset('name');
        $this->selected = $this->departments->firstWhere('id', $id);
        $this->name = $this->selected->name;
        $this->showingDepartmentUpdate = true;
    }

    public function updateDepartment()
    {
        $validatedData = $this->validate([
            'name' => 'required',
        ]);

        $this->selected->update($validatedData);
        $this->showingDepartmentUpdate = false;
    }

    public function showSubUpdate(string $id)
    {
        $this->reset('name', 'department_id');
        $this->subSelected = SubDepartment::find($id);
        $this->name = $this->subSelected->name;
        $this->showingSubDepartmentUpdate = true;
    }

    public function updateSubDepartment()
    {
        $validatedData = $this->validate([
            'name' => 'required',
        ]);

        $this->subSelected->update($validatedData);
        $this->showingSubDepartmentUpdate = false;
    }
}

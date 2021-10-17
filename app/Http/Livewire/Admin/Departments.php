<?php

namespace App\Http\Livewire\Admin;

use App\Contracts\CreatesDepartments;
use App\Contracts\CreatesSubDepartments;
use App\Contracts\DeletesDepartments;
use App\Contracts\DeletesSubDepartments;
use App\Contracts\UpdatesDepartments;
use App\Contracts\UpdatesSubDepartments;
use App\Models\Department;
use App\Models\SubDepartment;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Livewire\Component;


/**
 * @property Department $department
 * @property SubDepartment sub_department
 */
class Departments extends Component
{
    public Collection $departments;

    public ?string $selectedId = null;
    public ?string $selectedSubId = null;

    public array $state = [];

    public bool $showingDepartmentCreate = false;
    public bool $showingSubDepartmentCreate = false;
    public bool $showingDepartmentUpdate = false;
    public bool $showingSubDepartmentUpdate = false;
    public bool $confirmingDepartmentDeletion = false;
    public bool $confirmingSubDepartmentDeletion = false;

    public ?string $search = null;

    public function render()
    {
        $this->loadDepartments();
        return view('livewire.admin.departments')
            ->layout('layouts.admin');
    }

    public function getDepartmentProperty()
    {
        return Department::find($this->selectedId);
    }

    public function getSubDepartmentProperty()
    {
        return SubDepartment::find($this->selectedSubId);
    }

    private function loadDepartments()
    {
        $departments = Department::all();
        if ($this->search != null) {
            $search = $this->search;
            $departments = $departments->map(function ($i) use ($search) {
                $i->subs = $i->subs->filter(function ($f) use ($search) {
                    return Str::any([$f->id, $f->name], fn($s) => Str::contains($s, $search));
                });
                return $i;
            })->reject(function ($i) use ($search) {
                return !Str::any([$i->id, $i->name], fn($s) => Str::contains($s, $search)) && $i->subs->isEmpty();
            });
        }
        $this->departments = $departments;
    }

    public function showCreate()
    {
        $this->state = [];
        $this->showingDepartmentCreate = true;
    }

    public function storeDepartment(CreatesDepartments $creator)
    {
        $creator->create($this->state);
        $this->showingDepartmentCreate = false;
    }

    public function showUpdate(string $id)
    {
        $dep = Department::find($id);
        $this->selectedId = $dep->id;
        $this->state = $dep->withoutRelations()->toArray();
        $this->showingDepartmentUpdate = true;
    }

    public function updateDepartment(UpdatesDepartments $updater)
    {
        $updater->update(Department::find($this->selectedId), $this->state);
        $this->showingDepartmentUpdate = false;
    }

    public function confirmDeletion(string $id)
    {
        $dep = Department::find($id);
        if ($dep->users()->exists()) {
            $this->showErrorInUseModal();
            return;
        }

        $this->selectedId = $dep->id;
        $this->confirmingDepartmentDeletion = true;
    }

    public function deleteDepartment(DeletesDepartments $deleter)
    {
        $deleter->delete(Department::find($this->selectedId));
        $this->confirmingDepartmentDeletion = false;
    }

    public function showSubCreate(string $id)
    {
        $this->state = ['department_id' => $id];
        $this->showingSubDepartmentCreate = true;
    }

    public function storeSubDepartment(CreatesSubDepartments $creator)
    {
        $creator->create($this->state);
        $this->showingSubDepartmentCreate = false;
    }

    public function showSubUpdate(string $id)
    {
        $sub = SubDepartment::find($id);
        $this->selectedSubId = $sub->id;
        $this->state = $sub->withoutRelations()->toArray();
        $this->showingSubDepartmentUpdate = true;
    }

    public function updateSubDepartment(UpdatesSubDepartments $updater)
    {
        $updater->update(SubDepartment::find($this->selectedSubId), $this->state);
        $this->showingSubDepartmentUpdate = false;
    }

    public function confirmSubDeletion(string $id)
    {
        $sub = SubDepartment::find($id);
        if ($sub->users()->exists()) {
            $this->showErrorInUseModal();
            return;
        }

        $this->selectedSubId = $id;
        $this->confirmingSubDepartmentDeletion = true;
    }

    public function deleteSubDepartment(DeletesSubDepartments $deleter)
    {
        $deleter->delete(SubDepartment::find($this->selectedSubId));
        $this->confirmingSubDepartmentDeletion = false;
    }

    private function showErrorInUseModal()
    {
        $this->emit('show-error-modal', [
            'message' => 'ไม่สามารถลบได้เนื่องจากถูกใช้งานอยู่',
        ]);
    }
}

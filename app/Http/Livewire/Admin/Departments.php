<?php

namespace App\Http\Livewire\Admin;

use App\Contracts\CreatesDepartments;
use App\Contracts\CreatesSubDepartments;
use App\Contracts\DeletesDepartments;
use App\Contracts\DeletesSubDepartments;
use App\Contracts\UpdatesDepartments;
use App\Contracts\UpdatesSubDepartments;
use App\Models\Department;
use Illuminate\Support\Collection;
use Livewire\Component;

class Departments extends Component
{
    public Collection $departments;

    public $department;

    public $sub_department;

    public array $state = [];

    public bool $showingDepartmentCreate = false;

    public bool $showingSubDepartmentCreate = false;

    public bool $showingDepartmentUpdate = false;

    public bool $showingSubDepartmentUpdate = false;

    public bool $confirmingDepartmentDeletion = false;

    public bool $confirmingSubDepartmentDeletion = false;

    public ?string $search = null;

    public function mount(): void
    {
        $this->load();
    }

    public function render()
    {
        return view('livewire.admin.departments')
            ->layout('layouts.admin');
    }

    public function updatedSearch(): void
    {
        $this->load();
    }

    public function load(): void
    {
        $departments = Department::all();
        if (filled($search = str_replace(':', '', $this->search))) {
            $departments = $departments->map(function ($d) use ($search) {
                $d->subs = $d->subs->filter(function ($s) use ($search) {
                    return $s->searchInColumn('name', $search);
                });
                return $d;
            })->reject(function ($d) use ($search) {
                return !$d->searchInColumn('name', $search) && $d->subs->isEmpty();
            });
        }
        $this->departments = $departments;
    }

    public function showCreate(): void
    {
        $this->state = [];
        $this->showingDepartmentCreate = true;
    }

    public function storeDepartment(CreatesDepartments $creator): void
    {
        $creator->create($this->state);
        $this->load();
        $this->showingDepartmentCreate = false;
    }

    public function showUpdate(int $index): void
    {
        $this->department = $this->departments->get($index);
        $this->state = $this->department->attributesToArray();
        $this->showingDepartmentUpdate = true;
    }

    public function updateDepartment(UpdatesDepartments $updater): void
    {
        $updater->update(
            $this->department, $this->state
        );
        $this->load();
        $this->showingDepartmentUpdate = false;
    }

    public function confirmDeletion(int $index): void
    {
        $department = $this->departments->get($index);
        if ($department->users()->exists()) {
            $this->showErrorInUseModal();
            return;
        }

        $this->department = $department;
        $this->confirmingDepartmentDeletion = true;
    }

    public function deleteDepartment(DeletesDepartments $deleter): void
    {
        $deleter->delete($this->department);
        $this->load();
        $this->confirmingDepartmentDeletion = false;
    }

    public function showSubCreate(int $department): void
    {
        $this->state = ['department_id' => $department];
        $this->showingSubDepartmentCreate = true;
    }

    public function storeSubDepartment(CreatesSubDepartments $creator): void
    {
        $creator->create($this->state);
        $this->load();
        $this->showingSubDepartmentCreate = false;
    }

    public function showSubUpdate(int $index, int $subIndex): void
    {
        $sub_department = $this->departments->get($index)
            ->subs->get($subIndex);
        $this->sub_department = $sub_department;
        $this->state = $sub_department->attributesToArray();
        $this->showingSubDepartmentUpdate = true;
    }

    public function updateSubDepartment(UpdatesSubDepartments $updater): void
    {
        $updater->update(
            $this->sub_department, $this->state
        );
        $this->load();
        $this->showingSubDepartmentUpdate = false;
    }

    public function confirmSubDeletion(int $index, int $subIndex): void
    {
        $sub_department = $this->departments->get($index)->subs->get($subIndex);
        if ($sub_department->users()->exists()) {
            $this->showErrorInUseModal();
            return;
        }

        $this->sub_department = $sub_department;
        $this->confirmingSubDepartmentDeletion = true;
    }

    public function deleteSubDepartment(DeletesSubDepartments $deleter): void
    {
        $deleter->delete($this->sub_department);
        $this->load();
        $this->confirmingSubDepartmentDeletion = false;
    }

    private function showErrorInUseModal(): void
    {
        $this->emit('show-error-modal', [
            'message' => __('app.modal.msg-error-inuse'),
        ]);
    }
}

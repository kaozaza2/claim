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
    /**
     * @var \Illuminate\Support\Collection|null
     */
    public Collection $departments;

    public ?string $selectedId = null;

    /**
     * @var mixed|string|null
     */
    public ?string $selectedSubId = null;

    /**
     * @var mixed[]|array<string, string>|mixed
     */
    public array $state = [];

    /**
     * @var bool
     */
    public bool $showingDepartmentCreate = false;

    /**
     * @var bool
     */
    public bool $showingSubDepartmentCreate = false;

    /**
     * @var bool
     */
    public bool $showingDepartmentUpdate = false;

    /**
     * @var bool
     */
    public bool $showingSubDepartmentUpdate = false;

    /**
     * @var bool
     */
    public bool $confirmingDepartmentDeletion = false;

    /**
     * @var bool
     */
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
        if (filled($search = $this->search)) {
            $search = str_replace(':', '', $search);
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
        $this->showingDepartmentCreate = false;
    }

    public function showUpdate(string $id): void
    {
        $dep = Department::find($id);
        $this->selectedId = $dep->id;
        $this->state = $dep->withoutRelations()->toArray();
        $this->showingDepartmentUpdate = true;
    }

    public function updateDepartment(UpdatesDepartments $updater): void
    {
        $updater->update(Department::find($this->selectedId), $this->state);
        $this->showingDepartmentUpdate = false;
    }

    public function confirmDeletion(string $id): void
    {
        $dep = Department::find($id);
        if ($dep->users()->exists()) {
            $this->showErrorInUseModal();
            return;
        }

        $this->selectedId = $dep->id;
        $this->confirmingDepartmentDeletion = true;
    }

    public function deleteDepartment(DeletesDepartments $deleter): void
    {
        $deleter->delete(Department::find($this->selectedId));
        $this->confirmingDepartmentDeletion = false;
    }

    public function showSubCreate(string $id): void
    {
        $this->state = ['department_id' => $id];
        $this->showingSubDepartmentCreate = true;
    }

    public function storeSubDepartment(CreatesSubDepartments $creator): void
    {
        $creator->create($this->state);
        $this->showingSubDepartmentCreate = false;
    }

    public function showSubUpdate(string $id): void
    {
        $sub = SubDepartment::find($id);
        $this->selectedSubId = $sub->id;
        $this->state = $sub->attributesToArray();
        $this->showingSubDepartmentUpdate = true;
    }

    public function updateSubDepartment(UpdatesSubDepartments $updater): void
    {
        $updater->update(SubDepartment::find($this->selectedSubId), $this->state);
        $this->showingSubDepartmentUpdate = false;
    }

    public function confirmSubDeletion(string $id): void
    {
        $sub = SubDepartment::find($id);
        if ($sub->users()->exists()) {
            $this->showErrorInUseModal();
            return;
        }

        $this->selectedSubId = $id;
        $this->confirmingSubDepartmentDeletion = true;
    }

    public function deleteSubDepartment(DeletesSubDepartments $deleter): void
    {
        $deleter->delete(SubDepartment::find($this->selectedSubId));
        $this->confirmingSubDepartmentDeletion = false;
    }

    private function showErrorInUseModal(): void
    {
        $this->emit('show-error-modal', [
            'message' => __('app.modal.msg-error-inuse'),
        ]);
    }
}

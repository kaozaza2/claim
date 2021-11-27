<?php

namespace App\Http\Livewire\Admin;

use App\Contracts\DeletesUsers;
use App\Contracts\PromotesUsers;
use App\Contracts\UpdatesUsers;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Accounts extends Component
{
    protected $listeners = [
        'promote-accept' => 'promotePromptAccept',
        'delete-account' => 'deleteUserAccount',
    ];

    public array $state = [];
    public string $filter = '';
    public string $verify = '';
    public ?User $user = null;
    public bool $showingPromotePromptDialog = false;
    public bool $showingUpdateUserDialog = false;
    public bool $showingDeleteUserDialog = false;

    public function showUpdateUserDialog(int $userId): void
    {
        if ($this->user = User::find($userId)) {
            $this->state['user'] = $this->user->attributesToArray();
            $this->showingUpdateUserDialog = true;
        }
    }

    public function updateUserInformation(UpdatesUsers $updater): void
    {
        $updater->update($this->user, $this->state['user']);
        $this->showingUpdateUserDialog = false;
    }

    public function showDeleteUserDialog(int $userId): void
    {
        if ($this->user = User::find($userId)) {
            $this->dispatchBrowserEvent('confirming-delete-user');
            $this->showingDeleteUserDialog = true;
        }
    }

    public function deleteUserAccount(DeletesUsers $deleter): void
    {
        if ($this->user->isAdmin()) {
            $this->confirmPasswordValidated();
        }

        $deleter->delete($this->user);
        $this->showingDeleteUserDialog = false;
    }

    public function promotePrompt(int $userId): void
    {
        $this->user = User::find($userId);
        $this->verify = '';
        $this->dispatchBrowserEvent('confirming-promote-user');
        $this->showingPromotePromptDialog = true;
    }

    public function promotePromptAccept(PromotesUsers $promoter): void
    {
        if (!$this->user->isAdmin()) {
            $this->confirmPasswordValidated();
        }

        $this->verify = '';
        $promoter->promote($this->user, $this->user->isAdmin() ? 'member' : 'admin');
        $this->showingPromotePromptDialog = false;
    }

    public function render()
    {
        return view('livewire.admin.accounts', [
            'accounts' => $this->filteredUsers(),
        ])->layout('layouts.admin');
    }

    private function filteredUsers() {
        $user = User::with(['claims', 'subDepartment'])->get();
        if (filled($filter = $this->filter)) {
            return $user->filter(function ($user) use ($filter): bool {
                return $user->searchAuto($filter);
            });
        }
        return $user;
    }

    private function confirmPasswordValidated()
    {
        if (!Hash::check($this->verify, Auth::user()->password)) {
            throw ValidationException::withMessages([
                'verify' => [__('app.validation.wrong-password')],
            ]);
        }
    }
}

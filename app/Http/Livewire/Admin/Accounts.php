<?php

namespace App\Http\Livewire\Admin;

use App\Contracts\DeletesUsers;
use App\Contracts\PromotesUsers;
use App\Contracts\UpdatesUsers;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Accounts extends Component
{
    public array $state = [];
    public string $filter = '';
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
            $this->showingDeleteUserDialog = true;
        }
    }

    public function deleteUserAccount(DeletesUsers $deleter): void
    {
        $deleter->delete($this->user);
        $this->showingDeleteUserDialog = false;
    }

    public function promotePrompt(int $userId): void
    {
        $user = User::find($userId);
        $this->state['confirm'] = null;
        Session::put('user', $user);
        $this->dispatchBrowserEvent('confirming-promote-user');
        $this->showingPromotePromptDialog = true;
    }

    public function promotePromptAccept(): void
    {
        if (!Session::get('user')->isAdmin() && !Hash::check($this->state['confirm'], Auth::user()->password)) {
            throw ValidationException::withMessages([
                'confirm' => [__('app.validation.wrong-password')],
            ]);
        }

        $this->state['confirm'] = null;
        $user = Session::pull('user');
        app(PromotesUsers::class)->promote($user, $user->isAdmin() ? 'member' : 'admin');
        $this->showingPromotePromptDialog = false;
    }

    public function render()
    {
        return view('livewire.admin.accounts', [
            'accounts' => $this->filteredUsers(),
        ])->layout('layouts.admin');
    }

    private function filteredUsers() {
        if (filled($this->filter)) {
            $needle = '%'.$this->filter.'%';
            return User::where(function (Builder $query) use ($needle): void {
                $query->where('name', 'like', $needle)
                    ->orWhere('last_name', 'like', $needle)
                    ->orWhere('identification', 'like', $needle)
                    ->orWhere('email', 'like', $needle)
                    ->orWhere('title', 'like', $needle)
                    ->orWhere('username', 'like', $needle)
                    ->orWhere('id', 'like', $needle);
            })->get();
        }
        return User::all();
    }
}

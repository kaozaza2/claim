<?php

namespace App\Http\Livewire\Admin;

use App\Contracts\PromotesUsers;
use App\Contracts\UpdatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Accounts extends Component
{
    /**
     * @var mixed[]
     */
    public array $state = [];

    public $user;

    /**
     * @var bool
     */
    public bool $showingPromotePromptDialog = false;
    public bool $showingUpdateUserDialog = false;

    public function showUpdateUserDialog(int $userId)
    {
        if ($this->user = User::find($userId)) {
            $this->state['user'] = $this->user->attributesToArray();
            $this->showingUpdateUserDialog = true;
        }
    }

    public function updateUserInformation(UpdatesUsers $updater)
    {
        $updater->update($this->user, $this->state['user']);
        $this->showingUpdateUserDialog = false;
    }

    public function promotePrompt(int $userId)
    {
        $user = User::find($userId);
        $this->state['confirm'] = null;
        Session::put('user', $user);
        $this->dispatchBrowserEvent('confirming-promote-user');
        $this->showingPromotePromptDialog = true;
    }

    /**
     * @throws ValidationException
     */
    public function promotePromptAccept()
    {
        if (!Session::get('user')->isAdmin() && !Hash::check($this->state['confirm'], Auth::user()->password)) {
            throw ValidationException::withMessages([
                'confirm' => [\__('app.validation.wrong-password')],
            ]);
        }

        $this->state['confirm'] = null;
        $user = Session::pull('user');
        \app(PromotesUsers::class)->promote($user, $user->isAdmin() ? 'member' : 'admin');
        $this->showingPromotePromptDialog = false;
    }

    public function render()
    {
        return \view('livewire.admin.accounts', [
            'accounts' => User::all(),
        ])->layout('layouts.admin');
    }
}

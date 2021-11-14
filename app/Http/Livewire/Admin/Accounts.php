<?php

namespace App\Http\Livewire\Admin;

use App\Contracts\PromotesUsers;
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

    /**
     * @var bool
     */
    public bool $showingPromotePromptDialog = false;

    public function promotePrompt(int $userId, string $role)
    {
        $user = User::find($userId);
        if ($role !== 'admin') {
            $this->promote($user, $role);
            return;
        }

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
        if (!Hash::check($this->state['confirm'], Auth::user()->password)) {
            throw ValidationException::withMessages([
                'confirm' => [\__('app.validation.wrong-password')],
            ]);
        }

        $this->promote(Session::pull('user'), 'admin');
        $this->showingPromotePromptDialog = false;
    }

    private function promote(User $user, string $role)
    {
        \app(PromotesUsers::class)->promote($user, $role);
    }

    public function render()
    {
        return \view('livewire.admin.accounts', [
            'accounts' => User::all()->reject(function (User $user) {
                return Auth::user()->is($user);
            }),
        ])->layout('layouts.admin');
    }
}

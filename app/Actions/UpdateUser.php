<?php

namespace App\Actions;

use App\Contracts\UpdatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUser implements UpdatesUsers
{
    use Authorized;

    /**
     * @return bool|mixed
     */
    public function update(User $user, array $input)
    {
        if (!$this->authorized()) {
            return false;
        }

        $validated = Validator::make($input, [
            'title' => ['string'],
            'name' => ['string', 'max:255'],
            'last_name' => ['string', 'max:255'],
            'email' => ['string', 'email', 'max:255', 'unique:users'],
            'username' => ['string', 'max:255', 'unique:users'],
            'role' => [Rule::in(['admin', 'member'])],
            'sex' => ['string'],
            'identification' => ['identified'],
            'sub_department_id' => ['exists:sub_departments,id'],
        ])->validated();

        return \tap($user, function ($user) use ($validated) {
            $user->update($validated);
        });
    }
}

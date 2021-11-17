<?php

namespace App\Actions;

use App\Contracts\UpdatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UpdateUser implements UpdatesUsers
{
    /**
     * @return bool|mixed
     */
    public function update(User $user, array $input)
    {
        $validated = Validator::make($input, [
            'title' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($input['id']),
            ],
            // Be careful username must not change after registerd.
            'username' => [
                'required',
                'string',
                'max:255',
                Rule::unique('users')->ignore($input['id']),
            ],
            'role' => ['required', Rule::in(['admin', 'member'])],
            'sex' => ['required'],
            'identification' => [
                'required',
                'identified',
                Rule::unique('users')->ignore($input['id']),
            ],
            'sub_department_id' => [
                'required',
                Rule::exists('sub_departments', 'id'),
            ],
        ])->validated();

        return \tap($user, function ($user) use ($validated) {
            $user->update($validated);
        });
    }
}

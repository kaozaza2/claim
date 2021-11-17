<?php

namespace App\Actions;

use App\Actions\Fortify\PasswordValidationRules;
use App\Contracts\CreatesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CreateUser implements CreatesUsers
{
    use PasswordValidationRules;

    /**
     * @return bool|mixed
     */
    public function create(array $input)
    {
        $validated = Validator::make($input, [
            'title' => ['required', 'string'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'role' => ['required', Rule::in(['admin', 'member'])],
            'password' => $this->passwordRules(),
            'sex' => ['required'],
            'identification' => ['required', 'identified'],
            'sub_department_id' => ['required', 'exists:sub_departments,id'],
        ])->validated();

        return User::create($validated);
    }
}

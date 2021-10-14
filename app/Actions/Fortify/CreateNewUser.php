<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\Identification;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'title' => ['required'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'sex' => ['required'],
            'identification' => ['required', new Identification()],
            'sub_department_id' => ['required', 'exists:sub_departments,id'],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return User::create([
            'title' => $input['title'],
            'name' => $input['name'],
            'username' => $input['username'],
            'last_name' => $input['last_name'],
            'sex' => $input['sex'],
            'identification' => $input['identification'],
            'sub_department_id' => $input['sub_department_id'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}

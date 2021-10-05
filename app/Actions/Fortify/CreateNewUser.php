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
            'password' => $this->passwordRules(),
            'sex' => ['required'],
            'identification' => ['required', new Identification()],
            'department' => ['required', 'exists:departments,id'],
            'sub_department' => ['required', 'exists:sub_departments,id,department_id,' . $input['department']],
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return User::create([
            'title' => $input['title'],
            'name' => $input['name'],
            'last_name' => $input['last_name'],
            'sex' => $input['sex'],
            'identification' => $input['identification'],
            'department_id' => $input['department'],
            'sub_department_id' => $input['sub_department'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}

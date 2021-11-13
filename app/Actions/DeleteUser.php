<?php

namespace App\Actions;

use App\Contracts\DeletesUsers;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DeleteUser implements DeletesUsers
{
    use Authorized;

    /**
     * @return bool|null
     */
    public function delete(User $user)
    {
        if (!$this->authorized()) {
            return false;
        }

        return $user->delete();
    }
}

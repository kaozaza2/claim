<?php

namespace App\Actions;

use App\Contracts\DeletesUsers;
use App\Models\User;

class DeleteUser implements DeletesUsers
{
    /**
     * @return bool|null
     */
    public function delete(User $user)
    {
        return $user->delete();
    }
}

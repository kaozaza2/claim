<?php

namespace App\Actions;

use App\Contracts\DeletesUsers;
use App\Models\User;

class DeleteUser implements DeletesUsers
{
    public function delete(User $user): ?bool
    {
        return $user->delete();
    }
}

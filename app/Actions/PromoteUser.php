<?php

namespace App\Actions;

use App\Contracts\PromotesUsers;
use App\Models\User;

class PromoteUser implements PromotesUsers
{
    /**
     * @return bool
     */
    public function promote(User $target, string $role)
    {
        if (\in_array($role, User::roles())) {
            return $target->forceFill(['role' => $role])->save();
        }

        return false;
    }
}

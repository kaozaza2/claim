<?php

namespace App\Actions;

use App\Contracts\PromotesUsers;
use App\Models\User;

class PromoteUser implements PromotesUsers
{
    use Authorized;

    /**
     * @return bool
     */
    public function promote(User $target, string $role)
    {
        if ($this->authorized() && \in_array($role, User::roles())) {
            return $target->update(['role' => $role]);
        }

        return false;
    }
}

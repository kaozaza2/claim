<?php

namespace App\Contracts;

use App\Models\User;

interface PromotesUsers
{
    public function promote(User $target, string $role);
}

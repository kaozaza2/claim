<?php

namespace App\Contracts;

use App\Models\User;

interface UpdatesUsers
{
    public function update(User $user, array $input);
}

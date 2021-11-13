<?php

namespace App\Contracts;

use App\Models\User;

interface DeletesUsers
{
    public function delete(User $user);
}

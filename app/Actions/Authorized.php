<?php

namespace App\Actions;

use Illuminate\Support\Facades\Auth;

trait Authorized
{
    protected function authorized(): bool
    {
        return (bool) \optional(Auth::user())->isAdmin();
    }
}

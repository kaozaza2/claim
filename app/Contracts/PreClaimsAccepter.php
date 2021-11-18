<?php

namespace App\Contracts;

use App\Models\PreClaim;
use App\Models\User;

interface PreClaimsAccepter
{
    public function accept(PreClaim $claim, User $who);
}

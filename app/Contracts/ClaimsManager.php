<?php

namespace App\Contracts;

use App\Models\Claim;

interface ClaimsManager
{
    public function store(array $input);

    public function update(Claim $claim, array $input);

    public function destroy(Claim $claim);
}

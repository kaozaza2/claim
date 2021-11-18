<?php

namespace App\Contracts;

use App\Models\Transfer;

interface TransfersAccepter
{
    public function accept(Transfer $transfer);
}

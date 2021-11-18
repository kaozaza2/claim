<?php

namespace App\Actions;

use App\Contracts\TransfersAccepter;
use App\Models\Equipment;
use App\Models\Transfer;

class TransferAccepter implements TransfersAccepter
{
    public function accept(Transfer $transfer)
    {
        tap($transfer->equipment, function (Equipment $equipment) use ($transfer) {
            $equipment->forceFill([
                'sub_department_id' => $transfer->toSub->id,
                'old_sub_department_id' => $transfer->fromSub->id,
            ])->save();

            $transfer->delete();
        });
    }
}

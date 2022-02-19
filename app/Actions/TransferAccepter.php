<?php

namespace App\Actions;

use App\Contracts\TransfersAccepter;
use App\Models\Equipment;
use App\Models\Transfer;
use Illuminate\Support\Facades\Auth;

class TransferAccepter implements TransfersAccepter
{
    public function accept(Transfer $transfer): void
    {
        tap($transfer->equipment, function (Equipment $equipment) use ($transfer) {
            $equipment->forceFill([
                'sub_department_id' => $transfer->to->id,
                'old_sub_department_id' => $transfer->from->id,
            ])->save();

            $transfer->archive()->create([
                'archiver' => Auth::user()->id,
            ]);
        });
    }
}

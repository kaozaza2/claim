<?php

namespace App\Actions;

use App\Contracts\PreClaimsAccepter;
use App\Models\Claim;
use App\Models\PreClaim;
use App\Models\User;

class PreClaimAccepter implements PreClaimsAccepter
{
    public function accept(PreClaim $claim, User $who): void
    {
        tap(new Claim(), function ($new) use ($claim, $who): void {
            $new->forceFill([
                'equipment_id' => $claim->equipment_id,
                'user_id' => $claim->user_id,
                'admin_id' => $who->id,
                'problem' => $claim->problem,
                'status' => 'กำลังรับเรื่อง',
                'complete' => false,
            ])->save();

            $claim->delete();
        });
    }
}

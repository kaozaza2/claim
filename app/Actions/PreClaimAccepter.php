<?php

namespace App\Actions;

use App\Contracts\PreClaimsAccepter;
use App\Models\Claim;
use App\Models\PreClaim;
use App\Models\User;

class PreClaimAccepter implements PreClaimsAccepter
{
    public function accept(PreClaim $claim, User $who)
    {
        tap(new Claim(), function ($new) use ($claim, $who) {
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

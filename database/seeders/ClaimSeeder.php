<?php

namespace Database\Seeders;

use App\Models\Claim;
use App\Models\Equipment;
use App\Models\PreClaim;
use App\Models\SubDepartment;
use App\Models\Transfer;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClaimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (User::member()->get() as $member) {
            $equipment = Equipment::factory()
                ->count(6)
                ->for($member->subDepartment, 'subDepartment')
                ->for($member->subDepartment, 'oldSubDepartment')
                ->create();

            foreach ($equipment->shift(2) as $equip) {
                PreClaim::factory()
                    ->for($member, 'user')
                    ->for($equip, 'equipment')
                    ->create();
            }

            $sub = SubDepartment::whereHas('users', function ($query) use ($member) {
                $query->where('role', 'member')
                    ->where('id', '!=', $member->id);
            })->first();

            foreach ($equipment->shift(2) as $equip) {
                Transfer::factory()
                    ->for($member, 'user')
                    ->for($member->subDepartment, 'fromSub')
                    ->for($sub, 'toSub')
                    ->for($equip, 'equipment')
                    ->create();
            }

            foreach (User::admin()->get() as $admin) {
                Claim::factory()
                    ->for($member, 'user')
                    ->for($admin, 'admin')
                    ->for($equipment->shift(), 'equipment')
                    ->create();
            }
        }
    }
}

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
                ->for($member->subDepartment, 'subDepartment')
                ->for($member->subDepartment, 'oldSubDepartment');

            PreClaim::factory()
                ->count(2)
                ->for($member, 'user')
                ->for($equipment, 'equipment')
                ->create();

            $sub = SubDepartment::whereHas('users', function ($query) use ($member) {
                $query->where('role', 'member')
                    ->where('id', '!=', $member->id);
            })->first();

            Transfer::factory()
                ->count(2)
                ->for($member, 'user')
                ->for($member->subDepartment, 'fromSub')
                ->for($sub, 'toSub')
                ->for($equipment, 'equipment')
                ->create();

            foreach (User::admin()->get() as $admin) {
                Claim::factory()
                    ->for($member, 'user')
                    ->for($admin, 'admin')
                    ->for($equipment, 'equipment')
                    ->create();
            }
        }
    }
}

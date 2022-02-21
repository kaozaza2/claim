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
                ->for($member->subDepartment, 'oldDepartment');

            $equipment->count(2)
                ->has(PreClaim::factory()
                    ->for($member, 'user'))
                ->create();

            $sub = SubDepartment::whereHas('users', function ($query) use ($member) {
                $query->where('role', 'member')
                    ->where('id', '!=', $member->id);
            })->first();

            $equipment->count(2)
                ->has(Transfer::factory()
                    ->for($member, 'user')
                    ->for($member->subDepartment, 'from')
                    ->for($sub, 'to'))
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

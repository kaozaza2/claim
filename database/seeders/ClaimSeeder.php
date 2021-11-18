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
        $memberSubs = SubDepartment::whereHas('users', function ($q) {
            return $q->where('role', 'member');
        })
            ->get()
            ->map(function ($s) : array {
                return ['sub_department_id' => $s->id];
            });

        $equipments = Equipment::factory()
            ->count(10)
            ->sequence(...$memberSubs)
            ->create()
            ->map(function ($e) : array {
                return ['equipment_id' => $e->id];
            });

        $members = User::member()
            ->get()
            ->map(function ($u) : array {
                return ['user_id' => $u->id];
            });

        PreClaim::factory()
            ->count(4)
            ->sequence(...$members)
            ->sequence(...$equipments)
            ->create();

        $fromEquipments = Equipment::all()
            ->map(function ($e) : array {
                return ['equipment_id' => $e->id, 'from_sub_department_id' => $e->sub_department_id];
            });

        $toSubs = SubDepartment::whereHas('users', function ($q) {
            return $q->where('role', 'admin');
        })
            ->get()
            ->map(function ($s) : array {
                return ['to_sub_department_id' => $s->id];
            });

        Transfer::factory()
            ->count(4)
            ->sequence(...$members)
            ->sequence(...$fromEquipments)
            ->sequence(...$toSubs)
            ->create();

        Claim::factory()
            ->count(10)
            ->sequence(...$members)
            ->sequence(...$equipments)
            ->state(['admin_id' => User::admin()->first()->id])
            ->create();
    }
}

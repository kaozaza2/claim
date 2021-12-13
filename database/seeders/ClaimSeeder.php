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
        $equipments = Equipment::factory()->count(10)->sequence(
            ...User::member()->get()->map(function ($user) {
                return ['sub_department_id' => $user->subDepartment->id];
            })->toArray()
        )->create()->map(function ($equipment) {
            return ['equipment_id' => $equipment['id']];
        })->toArray();

        $members = User::member()->get()->map(function ($user) {
            return ['user_id' => $user->id];
        })->toArray();

        $admins = User::admin()->get()->map(function ($user) {
            return ['admin_id' => $user->id];
        })->toArray();

        PreClaim::factory()->count(4)->sequence(...$members)->sequence(...$equipments)->create();

        Transfer::factory()->count(4)->sequence(...$members)->sequence(
            ...Equipment::all()->map(function ($equipment) {
                return ['equipment_id' => $equipment->id, 'from_sub_department_id' => $equipment->sub_department_id];
            })->toArray()
        )->sequence(
            ...User::admin()->get()->map(function ($user) {
                return ['to_sub_department_id' => $user->subDepartment->id];
            })->toArray()
        )->create();

        Claim::factory()->count(10)->sequence(...$members)->sequence(...$equipments)->sequence(...$admins)->create();
    }
}

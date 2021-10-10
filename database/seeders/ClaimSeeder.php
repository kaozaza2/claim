<?php

namespace Database\Seeders;

use App\Models\Claim;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Database\Seeder;

class ClaimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where('role', 'member')->get()
            ->map(function ($user) {
                return ['user_id' => $user->id];
            });

        Claim::factory()
            ->count(10)
            ->sequence(...$users)
            ->state(['admin_id' => User::admin()->first()->id])
            ->create();
    }
}

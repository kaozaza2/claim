<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\SubDepartment;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dep = Department::factory()->create();

        User::factory()
            ->count(4)
            ->sequence(
                ['sex' => User::SEX_MALE],
                ['sex' => User::SEX_FEMALE],
            )->sequence(
                ['username' => 'admin1', 'email' => 'admin1@email.com', 'role' => 'admin'],
                ['username' => 'admin2', 'email' => 'admin2@email.com', 'role' => 'admin'],
                ['username' => 'user1', 'email' => 'user1@email.com', 'role' => 'member'],
                ['username' => 'user2', 'email' => 'user2@email.com', 'role' => 'member'],
            )->state([
                'password' => '$2y$10$gT9kx/47k8LIyMZdvSVdd.JVi2K4N.5v6JbqNF3RRt4bdS8QtLKuO',
                'sub_department_id' => SubDepartment::factory()->state(['department_id' => $dep->id]),
            ])->create();
    }
}

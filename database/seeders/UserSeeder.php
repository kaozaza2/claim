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
     *
     * @return void
     */
    public function run()
    {
        $dep = Department::factory()->create();

        User::factory()
            ->count(4)
            ->sequence(
                ['name' => 'Super', 'last_name' => 'Admin', 'email' => 'superadmin@email.com', 'role' => 'superadmin'],
                ['email' => 'admin@email.com', 'role' => 'admin'],
                ['email' => 'user1@email.com', 'role' => 'member'],
                ['email' => 'user2@email.com', 'role' => 'member'],
            )->state([
                'password' => '$2y$10$gT9kx/47k8LIyMZdvSVdd.JVi2K4N.5v6JbqNF3RRt4bdS8QtLKuO',
                'sub_department_id' => SubDepartment::factory()->state(['department_id' => $dep->id]),
            ])->create();
    }
}

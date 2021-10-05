<?php

namespace Database\Seeders;

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
        $dep1 = SubDepartment::factory()->create();
        $dep2 = SubDepartment::factory()->create();
        $dep3 = SubDepartment::factory()->create();

        User::factory()
            ->count(4)
            ->sequence(
                ['name' => 'Super Admin', 'email' => 'superadmin@email.com', 'role' => 'superadmin'],
                ['name' => 'Admin', 'email' => 'admin@email.com', 'role' => 'admin'],
                ['name' => 'User1', 'email' => 'user1@email.com', 'role' => 'member'],
                ['name' => 'User2', 'email' => 'user2@email.com', 'role' => 'member'],
            )->sequence(
                ['department_id' => $dep1->department->id, 'sub_department_id' => $dep1->id],
                ['department_id' => $dep2->department->id, 'sub_department_id' => $dep2->id],
                ['department_id' => $dep3->department->id, 'sub_department_id' => $dep3->id],
            )->state(['password' => '$2y$10$gT9kx/47k8LIyMZdvSVdd.JVi2K4N.5v6JbqNF3RRt4bdS8QtLKuO'])
            ->create();
    }
}

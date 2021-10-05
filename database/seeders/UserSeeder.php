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
        $dep = SubDepartment::factory()->create();

        User::factory()
            ->count(3)
            ->sequence(
                ['name' => 'Super Admin', 'email' => 'superadmin@email.com', 'role' => 'superadmin'],
                ['name' => 'Admin', 'email' => 'admin@email.com', 'role' => 'admin'],
                ['name' => 'User', 'email' => 'user@email.com', 'role' => 'member'],
            )->state([
                'password' => '$2y$10$gT9kx/47k8LIyMZdvSVdd.JVi2K4N.5v6JbqNF3RRt4bdS8QtLKuO',
                'department_id' => $dep->department->id,
                'sub_department_id' => $dep->id
            ])->create();
    }
}

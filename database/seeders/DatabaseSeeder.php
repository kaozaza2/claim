<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\SubDepartment;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->has(SubDepartment::factory()
                ->has(Department::factory()
                    ->state(['name' => 'ผู้ดูแลระบบ']))
                ->state(['name' => 'ผู้ดูแลระบบ']))
            ->state([
                'username' => 'admin1',
                'email' => 'admin1@email.com',
                'sex' => User::SEX_MALE,
                'role' => 'admin',
                'password' => '$2y$10$gT9kx/47k8LIyMZdvSVdd.JVi2K4N.5v6JbqNF3RRt4bdS8QtLKuO']) // password
            ->create();
    }
}

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
        User::factory()
            ->count(2)
            ->for(SubDepartment::factory()
                ->for(Department::factory()
                    ->state(['name' => 'ผู้ดูแลระบบ']))
                ->state(['name' => 'ผู้ดูแลระบบ']))
            ->sequence(
                ['username' => 'admin1', 'email' => 'admin1@email.com', 'sex' => User::SEX_MALE],
                ['username' => 'admin2', 'email' => 'admin2@email.com', 'sex' => User::SEX_FEMALE])
            ->state([
                'role' => 'admin',
                'password' => '$2y$10$gT9kx/47k8LIyMZdvSVdd.JVi2K4N.5v6JbqNF3RRt4bdS8QtLKuO']) // password
            ->create();

        SubDepartment::factory()
            ->count(2)
            ->for(Department::factory()
                ->state(['name' => 'หน่วยงาน 1']))
            ->sequence(['name' => 'แผนก 1'], ['name' => 'แผนก 2'])
            ->create()
            ->each(function ($sub_department, $index) {
                User::factory()
                    ->for($sub_department)
                    ->state([
                        'username' => 'user' . ++$index,
                        'email' => "user{$index}@email.com",
                        'role' => 'member',
                        'password' => '$2y$10$gT9kx/47k8LIyMZdvSVdd.JVi2K4N.5v6JbqNF3RRt4bdS8QtLKuO']) // password
                    ->create();
            });
    }
}

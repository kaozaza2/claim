<?php

namespace Database\Seeders;

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
        User::factory()
            ->count(4)
            ->sequence(
                ['name' => 'Super Admin', 'email' => 'superadmin@email.com', 'role' => 'superadmin'],
                ['name' => 'Admin', 'email' => 'admin@email.com', 'role' => 'admin'],
                ['name' => 'User1', 'email' => 'user1@email.com', 'role' => 'member'],
                ['name' => 'User2', 'email' => 'user2@email.com', 'role' => 'member'],
            )->state(['password' => '$2y$10$gT9kx/47k8LIyMZdvSVdd.JVi2K4N.5v6JbqNF3RRt4bdS8QtLKuO'])
            ->create();
    }
}

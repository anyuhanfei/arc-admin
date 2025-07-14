<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['id' => 2, 'username'=> 'developer', 'password'=> '$2y$10$.3oqF4QMCfkfrWUznUTBUOEGhEb3ugd1koclLaG5/qCvJ1EBbxJT.', 'name' => '开发者', 'avatar' => '', 'remember_token' => '', 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'], // developer
        ];

        DB::table('admin_users')->insert($users);
    }
}
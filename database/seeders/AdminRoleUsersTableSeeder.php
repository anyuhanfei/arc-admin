<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRoleUsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roleUsers = [
            ['role_id' => 2, 'user_id'=> 2, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
        ];

        DB::table('admin_role_users')->insert($roleUsers);
    }
}

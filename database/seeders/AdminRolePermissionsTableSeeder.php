<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rolePermissions = [
            ['role_id' => 1, 'permission_id' => 2, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 3, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 4, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 5, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 6, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 20, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 21, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 22, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 23, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 24, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 25, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 26, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 27, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 28, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 30, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 31, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 32, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 33, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 34, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 35, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 36, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 37, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 38, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 39, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 40, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 41, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 42, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 43, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 44, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 45, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 47, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 48, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 49, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 50, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 52, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 53, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 54, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 55, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 56, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 57, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 58, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'permission_id' => 59, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
        ];

        DB::table('admin_role_permissions')->insert($rolePermissions);
    }
}

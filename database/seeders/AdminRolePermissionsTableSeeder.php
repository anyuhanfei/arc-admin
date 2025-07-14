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
            ['role_id' => 2, 'permission_id' => 71, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 2, 'permission_id' => 72, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 2, 'permission_id' => 73, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 2, 'permission_id' => 74, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 2, 'permission_id' => 77, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 2, 'permission_id' => 78, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            
        ];

        DB::table('admin_role_permissions')->truncate();  // 清空表
        DB::table('admin_role_permissions')->insert($rolePermissions);
    }
}

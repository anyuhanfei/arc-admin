<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRoleMenuTableSeeder extends Seeder
{
    public function run(): void
    {
        $role_menus = [
            ['role_id' => 1, 'menu_id' => 1, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'menu_id' => 2, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'menu_id' => 3, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'menu_id' => 4, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'menu_id' => 5, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'menu_id' => 6, 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
            ['role_id' => 1, 'menu_id' => 8, 'created_at' => '2023-10-31 09:58:11', 'updated_at' => '2023-10-31 09:58:11'],
            ['role_id' => 1, 'menu_id' => 9, 'created_at' => '2023-10-31 10:01:18', 'updated_at' => '2023-10-31 10:01:18'],
            ['role_id' => 1, 'menu_id' => 10, 'created_at' => '2023-10-31 10:59:34', 'updated_at' => '2023-10-31 10:59:34'],
            ['role_id' => 1, 'menu_id' => 11, 'created_at' => '2023-10-31 13:24:18', 'updated_at' => '2023-10-31 13:24:18'],
            ['role_id' => 1, 'menu_id' => 12, 'created_at' => '2023-10-31 15:11:58', 'updated_at' => '2023-10-31 15:11:58'],
            ['role_id' => 1, 'menu_id' => 13, 'created_at' => '2023-10-31 15:12:21', 'updated_at' => '2023-10-31 15:12:21'],
            ['role_id' => 1, 'menu_id' => 14, 'created_at' => '2023-11-01 09:24:19', 'updated_at' => '2023-11-01 09:24:19'],
            ['role_id' => 1, 'menu_id' => 15, 'created_at' => '2023-11-01 09:24:37', 'updated_at' => '2023-11-01 09:24:37'],
            ['role_id' => 1, 'menu_id' => 16, 'created_at' => '2023-11-01 09:24:55', 'updated_at' => '2023-11-01 09:24:55'],
            ['role_id' => 1, 'menu_id' => 17, 'created_at' => '2023-11-01 11:28:13', 'updated_at' => '2023-11-01 11:28:13'],
            ['role_id' => 1, 'menu_id' => 18, 'created_at' => '2023-11-01 11:28:35', 'updated_at' => '2023-11-01 11:28:35'],
            ['role_id' => 1, 'menu_id' => 19, 'created_at' => '2023-11-03 10:29:08', 'updated_at' => '2023-11-03 10:29:08'],
            ['role_id' => 1, 'menu_id' => 20, 'created_at' => '2023-11-04 14:21:32', 'updated_at' => '2023-11-04 14:21:32'],
            ['role_id' => 1, 'menu_id' => 21, 'created_at' => '2025-02-08 16:21:22', 'updated_at' => '2025-02-08 16:21:22'],
            ['role_id' => 1, 'menu_id' => 22, 'created_at' => '2025-02-08 16:36:45', 'updated_at' => '2025-02-08 16:36:45'],
        ];

        DB::table('admin_role_menu')->truncate();  // 清空表
        DB::table('admin_role_menu')->insert($role_menus);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRoleMenuTableSeeder extends Seeder
{
    public function run(): void
    {
        $role_menus = [
            ['role_id' => 2, 'menu_id' => 25, 'created_at' => '2025-02-08 16:36:45', 'updated_at' => '2025-02-08 16:36:45'],
            ['role_id' => 2, 'menu_id' => 27, 'created_at' => '2025-02-08 16:36:45', 'updated_at' => '2025-02-08 16:36:45'],
            ['role_id' => 2, 'menu_id' => 28, 'created_at' => '2025-02-08 16:36:45', 'updated_at' => '2025-02-08 16:36:45'],
        ];

        DB::table('admin_role_menu')->truncate();  // 清空表
        DB::table('admin_role_menu')->insert($role_menus);
    }
}
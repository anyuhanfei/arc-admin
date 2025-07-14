<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['id' => 2, 'name' => '开发者', 'slug'=> '开发者', 'created_at' => '2023-10-31 09:58:47', 'updated_at' => '2023-10-31 09:58:47'],
        ];

        DB::table('admin_roles')->insert($roles);
    }
}

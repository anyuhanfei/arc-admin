<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminMenuTableSeeder::class,
            AdminPermissionsTableSeeder::class,
            AdminPermissionMenuTableSeeder::class,
            AdminRolePermissionsTableSeeder::class,
            AdminRoleUsersTableSeeder::class,
            AdminRolesTableSeeder::class,
            AdminUsersTableSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        $this->call([
            AdminPermissionSeeder::class,
            PermissionSeeder::class,
            AdminSeeder::class,
            RolePermissionSeeder::class,
            RoleSeeder::class,
            AdminRoleSeeder::class,
            UserSeeder::class,
            CitySeeder::class,
            InterestSeeder::class,
            FourSquareSeeder::class,
            CmsSeeder::class,
            FilterSeeder::class,
        ]);
    }
}

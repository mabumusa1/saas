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
        $this->call([
            AccountSeeder::class,
            RoleSeeder::class,
            SiteSeeder::class,
            InstallSeeder::class,
            ContactSeeder::class,
            GroupSeeder::class,
        ]);
    }
}

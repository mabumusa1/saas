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
        \App\Models\User::factory(1)->withPersonalTeam()->create([
            'email' => 'email@domain.com',
        ]);
        \App\Models\User::factory(10)->withPersonalTeam()->create();
    }
}

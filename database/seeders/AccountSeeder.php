<?php

namespace Database\Seeders;

use App\Models\Account;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Always make sure we have five test accounts only
        if (Account::count() >= 5) {
            $this->command->info('Accounts exists, skip seeding accounts');
        } else {
            Account::factory()->count(5)->create();
        }
    }
}

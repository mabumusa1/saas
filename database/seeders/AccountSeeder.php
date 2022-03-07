<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;


class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // We need five account for testing with five users for each account
        if (Account::count() >= 5) {
            $this->command->info('Accounts exists, skip seeding accounts');
        } else {
            Account::factory()->count(5)->hasAttached(
                User::factory()->count(5)
                ->sequence(
                    fn ($sequence) => ['email' => "email{$sequence->index}@domain.com"]
                )
            )->sequence(
                fn($sequence) => ['stripe_id' => ($sequence->index % 2 === 0) ? Arr::random(['cus_LGPH3brjCTaQXY', 'cus_LGPH3brjCTaQOP']) : null]
            )
            ->create();
        }
    }
}

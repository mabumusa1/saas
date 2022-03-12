<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
        // We want two customers one with real billing account and the other is an empty account without billing
        if (Account::count() >= 2) {
            $this->command->info('Accounts exists, skip seeding accounts');
        } else {
            Account::factory()->count(2)->hasAttached(
                User::factory()->count(5)
                ->sequence(
                    fn ($sequence) => ['email' => "email{$sequence->index}@domain.com"]
                )
            )->state(new Sequence(
                ['stripe_id' => 'cus_LIGOOQC7OuqyAn', 'pm_type' => 'visa', 'pm_last_four' => 4242],
                ['stripe_id' => null, 'pm_type' => null, 'pm_last_four' => null],
            ))
            ->create();
        }
    }
}

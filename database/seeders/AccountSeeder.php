<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
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
        // We need five account for testing with five users for each account
        if (Account::count() >= 5) {
            $this->command->info('Accounts exists, skip seeding accounts');
        } else {
            Account::factory()->count(5)->hasAttached(
                User::factory()->count(5)
                ->sequence(
                    fn ($sequence) => ['email' => "email{$sequence->index}@domain.com"]
                )
            )//->has(->has(Install::factory()->count(2)))
            ->create();

            //Make the owner email, the billing email
            foreach (Account::all() as $account) {
                $account->billing_email = $account->users()->first()->email;
                $account->save();
            }
        }
    }
}

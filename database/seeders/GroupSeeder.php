<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = Account::all();

        foreach ($accounts as $key => $account) {
            if (! empty($account->stripe_id)) {
                // Create two groups
                if ($account->groups->count() <= 2) {
                    Group::factory()->count(2)->create(['account_id' => $account->id]);
                    $site = $account->sites()->first();
                    $group = $account->groups()->first();
                    $site->groups()->sync([$group->id]);
                }
            }
        }
    }
}

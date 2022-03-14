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
        $account = Account::where('stripe_id', 'cus_LIGOOQC7OuqyAn')->first();
        Group::factory()->count(2)->create(['account_id' => $account->id]);
        $site = $account->sites()->first();
        $group = $account->groups()->first();
        $site->groups()->sync([$group->id]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\Site;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SiteSeeder extends Seeder
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
            if ($account->sites->count() < 2) {
                Site::factory()->count(2)->create(['account_id' => $account->id]);
            }
        }
    }
}

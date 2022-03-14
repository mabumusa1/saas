<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Spatie\Activitylog\Facades\CauserResolver;

class AccountWithoutBillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CauserResolver::setCauser(User::find(7));
        $account = Account::factory()->state(new Sequence(
            ['stripe_id' => null, 'pm_type' => null, 'pm_last_four' => null],
        ))->create();

        $account2Roles = [7=>['role'=>'owner'], 8 => ['role'=>'fb'], 9 => ['role'=>'fnb'], 10 => ['role'=>'pb'], 11 => ['role'=>'pnb']];
        $account->users()->sync($account2Roles);
    }
}

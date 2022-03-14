<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Activitylog\Facades\CauserResolver;
use App\Models\Contact;
use App\Models\Install;
use App\Models\Account;
use App\Models\Site;
use App\Models\User;
use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Sequence;


class AccountWithBillingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CauserResolver::setCauser(User::find(2));
        $account = Account::factory()->state(new Sequence(
            ['stripe_id' => 'cus_LIGOOQC7OuqyAn', 'pm_type' => 'visa', 'pm_last_four' => 4242],
        ))->create();

        $account1Roles = [2=>['role'=>'owner'], 3 => ['role'=>'fb'], 4 => ['role'=>'fnb'], 5 => ['role'=>'pb'], 6 => ['role'=>'pnb']];
        $account->users()->sync($account1Roles);
        $sites = $account->sites()->get();
        foreach ($sites as $key => $site) {
            if ($site->installs->count() < 2) {
                Install::factory()->count(2)->create(['site_id' => $site->id]);
            }
        } 
        $installs = Install::all();
        foreach ($installs as $key => $install) {
            if (empty($install->contact)) {
                Contact::factory()->create(['install_id' => $install->id]);
            }
        }

        Group::factory()->count(2)->create(['account_id' => $account->id]);
        $site = $account->sites()->first();
        $group = $account->groups()->first();
        $site->groups()->sync([$group->id]);
       
    }
}

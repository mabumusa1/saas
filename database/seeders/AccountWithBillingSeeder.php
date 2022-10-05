<?php

namespace Database\Seeders;

use App\Facades\AccountResolver;
use App\Models\Account;
use App\Models\Backup;
use App\Models\Contact;
use App\Models\Domain;
use App\Models\Group;
use App\Models\Install;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Spatie\Activitylog\Facades\CauserResolver;

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
        $account = Account::withoutEvents(function () {
            return Account::factory()->state(new Sequence(
                ['name' => 'Jane Doe', 'stripe_id' => 'cus_MYaek9JzpJVKic', 'pm_type' => 'visa', 'pm_last_four' => 4242, 'email' => 'jane@example.com'],
            ))->create();
        });

        AccountResolver::setAccount($account);

        $account1Roles = [2=>['role'=>'owner'], 3 => ['role'=>'fb'], 4 => ['role'=>'fnb'], 5 => ['role'=>'pb'], 6 => ['role'=>'pnb']];
        $account->users()->sync($account1Roles);

        $sites = $account->sites()->get();
        foreach ($sites as $key => $site) {
            if ($site->installs->count() < 2) {
                Install::withoutEvents(function () use ($site) {
                    return Install::factory()->count(2)->state(new Sequence(
                        ['site_id' => $site->id, 'type' => 'dev'],
                        ['site_id' => $site->id, 'type' => 'prd']
                    ))->create();
                });
            }
        }
        $installs = Install::all();
        foreach ($installs as $key => $install) {
            if (empty($install->contact)) {
                Contact::withoutEvents(function () use ($install) {
                    return Contact::factory()->create(['install_id' => $install->id]);
                });
            }
            if ($install->domains()->count() === 0) {
                Domain::withoutEvents(function () use ($install) {
                    return                 Domain::factory()->count(2)->state(new Sequence(
                        ['install_id' => $install->id, 'name' => $install->cname, 'primary' => true, 'verified_at' => now()],
                        ['install_id' => $install->id, 'primary' => false, 'verified_at' => null]
                    ))->create();
                });
            }

            if ($install->backups()->count() === 0) {
                Backup::withoutEvents(function () use ($install) {
                    Backup::factory()->count(2)->state(new Sequence(
                        ['install_id' => $install->id, 'status' => 'creating'],
                        ['install_id' => $install->id, 'status' => 'restoring'],
                        ['install_id' => $install->id, 'status' => 'ready'],
                        ['install_id' => $install->id, 'status' => 'failed']
                    ))->create();
                });
            }
        }

        Group::withoutEvents(function () use ($account) {
            Group::factory()->count(2)->create(['account_id' => $account->id]);
        });

        $site = $account->sites()->first();
        $group = $account->groups()->first();
        $site->groups()->sync([$group->id]);
    }
}

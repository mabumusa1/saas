<?php

namespace Database\Seeders;

use App\Facades\AccountResolver;
use App\Models\Account;
use App\Models\AccountUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Activitylog\Facades\CauserResolver;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminAccount = Account::create(['name'=>'Admin Account', 'data_center_id' => 1]);
        AccountResolver::setAccount($adminAccount);
        $admin = User::factory()->create(['email' => 'm.abumusa@gmail.com']);
        CauserResolver::setCauser(User::find(1));

        $admin->accounts()->attach($adminAccount->id, ['role' => 'admin']);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;

class RoleSeeder extends Seeder
{
    private function assignRole(int $index)
    {
        $role = 'owner';
        switch ($index) {
            case 0:
                $role = 'owner';
                break;
            case 1:
                $role = 'fb';
                break;
            case 2:
                $role = 'fnb';
                break;
            case 3:
                $role = 'pb';
                break;
            case 4:
                $role = 'pnb';
                break;
        }

        return $role;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Make all the users belong to two accounts
        $roles = ['owner', 'fb', 'fnb', 'pb', 'pnb'];
        $accounts = Account::all();
        $users = User::chunk(5, function ($users) use ($accounts) {
            foreach ($users as $index => $user) {
                $newAccounts = [];
                $newAccountFlag = true;
                $randomId = $accounts->random()->id;
                $currentAccount = $user->accounts->first()->id;

                do {
                    if ($currentAccount == $randomId) {
                        $randomId = $accounts->random()->id;
                        continue;
                    }
                    $newAccounts = [$currentAccount, $randomId];
                    $newAccountFlag = false;
                } while ($newAccountFlag);

                $user->accounts()->sync([$currentAccount => ['role' => $this->assignRole($index)], $randomId => ['role' => $this->assignRole(rand(0, 4))]]);
            }
        });
    }
}

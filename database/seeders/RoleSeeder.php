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
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Users are created in the Accounts Seeders we just need to update their roles in the pivot table
        $accounts = Account::all();
        foreach ($accounts as $account) {
            foreach ($account->users as $index => $user) {
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
                $account->users()->updateExistingPivot($user->id, [
                    'role' => $role,
                ]);
            }
        }

        // Make sure each user has at least two accounts for testing
        $roles = ['owner', 'fb', 'fnb', 'pb', 'pnb'];
        $users = User::all();
        foreach ($users as $user) {
            if ($user->accounts->count() == 1) {
                try {
                    $currentAccount = $user->accounts->first();
                    $currentRole = $currentAccount->pivot->role;
                    $nextId = $currentAccount->id + 1;
                    $nextAccount = Account::findOrFail($nextId);
                    $user->accounts()->syncWithoutDetaching([$nextAccount->id], ['role' => Arr::random($roles)]);
                } catch (\Throwable $th) {
                }
            }
        }
    }
}

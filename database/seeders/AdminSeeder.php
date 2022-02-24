<?php

namespace Database\Seeders;

use App\Models\Account;
use App\Models\AccountUser;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
                    'first_name' =>  'admin',
                    'last_name' => 'admin',
                    'email' =>  'admin@gmail.com',
                    'email_verified_at' => now(),
                    'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
                    'remember_token' => Str::random(10),
                    'phone' => '12345678',
                    'job_title' => 'Developer',
                    'employer' => 'Myself',
                    'experince' => 'I am an expert',
                    'company_name' => 'admin-company',
                ]);

        $account = Account::create([
                    'data_center_id' => 1,
                    'name' => 'Admin',
                    ]);

        AccountUser::create([
            'account_id' => $account->id,
            'user_id' => $user->id,
            'role' => 'admin',
        ]);
    }
}

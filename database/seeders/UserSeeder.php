<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Create 10 Random Users and one unique user.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 15; $i++) {
            $user = null;
            try {
                $user = User::where('email', 'email'.$i.'@domain.com')->firstOrFail();
            } catch (ModelNotFoundException $e) {
                $user = User::factory(1)->withPersonalTeam()->create([
                    'email' => 'email'.$i.'@domain.com',
                ]);
            }
        }
    }
}

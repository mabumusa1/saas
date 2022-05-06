<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::withoutEvents(function () {
            return User::factory()->count(10)
            ->sequence(
                fn ($sequence) => ['email' => "email{$sequence->index}@domain.com"]
            )->create();
        });
    }
}

<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Account>
 */
class AccountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' =>  $this->faker->firstName(),
            'data_center_id' => 1,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        //Create users with all the possible roles
        return $this->afterCreating(function (Account $account) {
            $roles = ['fb', 'fnb', 'pb', 'pnb'];
            User::factory()->owner()->create(['account_id' => $account->id]);
            foreach ($roles as $role) {
                User::factory()->create(['account_id' => $account->id, 'role' => $role]);
            }
        });
    }
}

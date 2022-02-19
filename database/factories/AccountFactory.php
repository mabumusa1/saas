<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;

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
            'name' =>  $this->faker->firstName() . ' Account',
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
        
        return $this->afterCreating(function (Account $account) {
            // Create Sites attached to the account
            Site::factory()->count(5)->create(['account_id' => $account->id]);
        });
    }
}

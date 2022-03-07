<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Cashier\Subscription;
use App\Models\Cashier\SubscriptionItem;
use App\Models\Site;
use App\Models\User;
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
            'name' =>  $this->faker->firstName().' Account',
            'data_center_id' => 1,
            'email' => $this->faker->safeEmail(),
            'phone' => $this->faker->phoneNumber(),
            'line1' => $this->faker->streetAddress(),
            'line2' => $this->faker->streetSuffix(),
            'city'=> $this->faker->city(),
            'state' => $this->faker->state(),
            'country' => $this->faker->country(),
            'postal_code' => $this->faker->postcode(),
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
            if (! empty($account->stripe_id)) {
                Subscription::factory()->count(2)->create(['account_id' => $account->id]);
                foreach ($account->subscriptions as $key => $subscription) {
                    // Create Sites attached to the account
                    Site::factory()->create(['account_id' => $account->id, 'subscription_id' => $subscription->id]);
                    SubscriptionItem::factory()->create(['subscription_id' => $subscription->id]);
                }
            }
        });
    }
}

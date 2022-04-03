<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Cashier\Subscription;
use App\Models\Site;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Support\Facades\DB;

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
            if ($account->stripe_id == 'cus_LIGOOQC7OuqyAn') {
                $subscriptions = [
                    ['account_id' => $account->id, 'name' => 's1', 'stripe_id' => 'sub_1Kbft4JJANQIX4AvXASaiV7R', 'stripe_status' => 'active', 'stripe_price' => 'price_1KYcdZJJANQIX4AvM2ySzZzb', 'quantity' => 1],
                    ['account_id' => $account->id, 'name' => 's5', 'stripe_id' => 'sub_1KbfurJJANQIX4AvVTWFgUVW', 'stripe_status' => 'active', 'stripe_price' => 'price_1KYchzJJANQIX4AvCfLCKqjQ', 'quantity' => 1],
                    ['account_id' => $account->id, 'name' => 's1', 'stripe_id' => 'sub_1KbfwQJJANQIX4AvatnKerTc', 'stripe_status' => 'active', 'stripe_price' => 'price_1KYcdZJJANQIX4AvM2ySzZzb', 'quantity' => 1],
                ];
                foreach ($subscriptions as $subscription) {
                    $m = new Subscription($subscription);
                    $m->save();
                    if ($subscription['stripe_id'] == 'sub_1Kbft4JJANQIX4AvXASaiV7R') {
                        DB::insert('insert into subscription_items (subscription_id, stripe_id, stripe_product, stripe_price, quantity) values (?, ?, ?, ?, ?)', [$m->id, 'si_LIGPEjRwAEbdS8', 'prod_LF6rlbuqYaz6k1', 'price_1KYcdZJJANQIX4AvM2ySzZzb', 1]);
                    } elseif ($subscription['stripe_id'] == 'sub_1KbfurJJANQIX4AvVTWFgUVW') {
                        DB::insert('insert into subscription_items (subscription_id, stripe_id, stripe_product, stripe_price, quantity) values (?, ?, ?, ? ,?)', [$m->id, 'si_LIGRB2xa5SrEdq', 'prod_LF6vLk0UO67X1C', 'price_1KYchzJJANQIX4AvCfLCKqjQ', 1]);
                    } elseif ($subscription['stripe_id'] == 'sub_1KbfwQJJANQIX4AvatnKerTc') {
                        DB::insert('insert into subscription_items (subscription_id, stripe_id, stripe_product, stripe_price, quantity) values (?, ?, ?, ? ,?)', [$m->id, 'si_LIGTYjTvt0jSF8', 'prod_LF6rlbuqYaz6k1', 'price_1KYcdZJJANQIX4AvM2ySzZzb', 1]);
                    }
                    Site::factory()->state(['account_id'=>$account->id, 'subscription_id' => $m->id, 'transferable' => false])->create();
                }
            }
        });
    }
}

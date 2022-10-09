<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Site;
use App\Models\Subscription;
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

    /*
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Account $account) {
            if ($account->stripe_id == 'cus_MYaek9JzpJVKic') {
                $subscriptions = [
                        ['name' => 's1', 'stripe_id' => 'sub_1LpTfLQtw9T5bCK1gBnPinct', 'stripe_status' => 'active', 'stripe_price' => 'price_1LmDwTQtw9T5bCK19IZz3F3M', 'quantity' => 1],
                        ['name' => 's2', 'stripe_id' => 'sub_1LpTduQtw9T5bCK1fPtIMrnK', 'stripe_status' => 'active', 'stripe_price' => 'price_1LmE0IQtw9T5bCK1vLuWjLgn', 'quantity' => 1],
                        ['name' => 's1', 'stripe_id' => 'sub_1LpTXUQtw9T5bCK15I1T5ARP', 'stripe_status' => 'active', 'stripe_price' => 'price_1LmDwTQtw9T5bCK19IZz3F3M', 'quantity' => 1],
                    ];
                foreach ($subscriptions as $subscription) {
                    $m = new Subscription($subscription);
                    $m->save();
                    if ($subscription['stripe_id'] == 'sub_1LpTfLQtw9T5bCK1gBnPinct') {
                        DB::insert('insert into subscription_items (subscription_id, stripe_id, stripe_product, stripe_price, quantity) values (?, ?, ?, ?, ?)', [$m->id, 'si_MYaiaj3zmUzjLu', 'prod_MVEPWB3RPLdOEI', 'price_1LmDwTQtw9T5bCK19IZz3F3M', 1]);
                    } elseif ($subscription['stripe_id'] == 'sub_1LpTduQtw9T5bCK1fPtIMrnK') {
                        DB::insert('insert into subscription_items (subscription_id, stripe_id, stripe_product, stripe_price, quantity) values (?, ?, ?, ? ,?)', [$m->id, 'si_MYapvVAf7iWFO1', 'prod_MVETjTi3IupeLK', 'price_1LmE0IQtw9T5bCK1vLuWjLgn', 1]);
                    } elseif ($subscription['stripe_id'] == 'sub_1LpTXUQtw9T5bCK15I1T5ARP') {
                        DB::insert('insert into subscription_items (subscription_id, stripe_id, stripe_product, stripe_price, quantity) values (?, ?, ?, ? ,?)', [$m->id, 'si_MYardAsDAVX51y', 'prod_MVEPWB3RPLdOEI', 'price_1LmDwTQtw9T5bCK19IZz3F3M', 1]);
                    }
                    $site = Site::factory()->state(['account_id'=>$account->id, 'subscription_id' => $m->id, 'transferable' => false])->create();
                    $m->site_id = $site->id;
                    $m->save();
                }
            }
        });
    }
}

<?php

namespace Database\Factories\Cashier;

use App\Models\Cashier\Subscription;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->randomElement(
                ['Small - 2,500 Leads', 'Small - 5,000 Leads', 'Small - 10,000 Leads', 'Medium - 25,000 Leads', 'Medium - 50,000 Leads', 'Medium - 100,000 Leads',
                'Large - 500,000 Leads', 'Large - 1 Million Leads', 'Large - 1.5 Million Leads', ]
            ),
            'stripe_id' => 'sub_'.$this->faker->regexify('[A-Z]{20}[0-9]{4}'),
            'stripe_status' => $this->faker->randomElement(['active', 'canceled']),
            'stripe_price' => $this->faker->randomElement(['price_1KYcdZJJANQIX4AvM2ySzZzb', 'price_1KYcesJJANQIX4Avxz5hB5bE']),
            'quantity' => rand(1, 5),
            'ends_at' => Carbon::now()->addDays(30),
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterCreating(function (Subscription $subscription) {
        });
    }
}

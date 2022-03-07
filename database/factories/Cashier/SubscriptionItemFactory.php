<?php

namespace Database\Factories\Cashier;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Cashier\SubscriptionItem;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class SubscriptionItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        
        return [
            'stripe_id' => 'si_' . $this->faker->regexify('[A-Z]{10}[0-9]{4}'),
            'stripe_product' =>  'prod_' . $this->faker->regexify('[A-Z]{10}[0-9]{4}'),
            'stripe_price' => 'price_' . $this->faker->regexify('[A-Z]{20}[0-9]{4}'),
            'quantity' => rand(1,5),            
        ];
    }
}

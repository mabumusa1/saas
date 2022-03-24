<?php

namespace Database\Factories;

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
            'name' => 'test',
            'stripe_id' => 'test',
            'stripe_status' => 'test',
            'stripe_price' => 'test',
            'quantity' => 1,
            'trial_ends_at' => null,
            'ends_at' => now(),
        ];
    }
}

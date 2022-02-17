<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' =>  $this->faker->firstName(),
            'last_name' =>  $this->faker->lastName(),
            'email' =>  $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'phone' => $this->faker->phoneNumber(),
            'job_title' => $this->faker->randomElement(['CTO', 'CEO', 'Marketer']),
            'employer' => $this->faker->company(),
            'experince' => $this->faker->randomElement(['Beginner', 'Intermidate', 'Pro']),
            'role' => $this->faker->randomElement(['owner', 'fb', 'fnb', 'pb', 'pnb']),
        ];
    }

    /**
     * Indicate that the user is owner.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function owner()
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => 'owner',
            ];
        });
    }
}

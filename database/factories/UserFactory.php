<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\Sequence;
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
            'job_title' => $this->faker->randomElement(['Developer', 'Marketer', 'Designer', 'Project Manager', 'Billing Manager', 'IT Professional', 'Executive', 'None of these']),
            'employer' => $this->faker->randomElement(['Myself, freelance', 'Myself, full-time', 'Agency', 'Business/In-house']),
            'experince' => $this->faker->randomElement(['I am a beginner', 'I have some experience', 'I feel comfortable with most Mautic-related tasks', 'I am an expert']),
            'company_name' => $this->faker->company(),
        ];
    }
}

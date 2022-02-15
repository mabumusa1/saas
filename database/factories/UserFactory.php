<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->safeEmail,
            'email_verified_at' => $this->faker->dateTime(),
            'password' => $this->faker->password,
            'two_factor_secret' => $this->faker->text,
            'two_factor_recovery_codes' => $this->faker->text,
            'remember_token' => $this->faker->regexify('[A-Za-z0-9]{100}'),
            'current_team_id' => $this->faker->randomNumber(),
            'profile_photo_path' => $this->faker->regexify('[A-Za-z0-9]{2048}'),
            'job_title' => $this->faker->word,
            'employer' => $this->faker->word,
            'experince' => $this->faker->word,
            'company_name' => $this->faker->word,
            'role' => $this->faker->randomElement(['admin', 'staff', 'owner', 'fb', 'fnb', 'pb', 'pnb']),
        ];
    }
}

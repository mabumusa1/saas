<?php

namespace Database\Factories;

use App\Models\Install;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class InstallFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Install::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'site_id' => Site::factory(),
            'name' => $this->faker->name,
            'type' => $this->faker->randomElement(['dev', 'stg', 'prd']),
            'tech_contact_first_name' => $this->faker->word,
            'tech_contact_last_name' => $this->faker->word,
            'tech_contact_email' => $this->faker->word,
            'tech_contact_phone' => $this->faker->word,
        ];
    }
}

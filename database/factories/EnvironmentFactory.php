<?php

namespace Database\Factories;

use App\Models\Environment;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnvironmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Environment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'site_id' => Site::factory(),
            'name' => $this->faker->unique()->company(),
            'type' => $this->faker->randomElement(['prd', 'stg', 'dev']),
        ];
    }
}

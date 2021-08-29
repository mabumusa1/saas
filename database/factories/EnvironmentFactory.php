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
            'name' => $this->faker->unique()->word(),
            'type' => $this->faker->randomElement(['prd', 'stg', 'dev']),
            'php' => $this->faker->randomElement(['7.2', '7.3', '7.4']),
            'storage' => $this->faker->randomElement(['100', '150', '300']),
            'bandwidth' => $this->faker->randomElement(['100', '500', '600']),
            'visits' => $this->faker->randomElement(['1000', '2000', '3000']),
        ];
    }
}

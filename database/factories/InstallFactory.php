<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Install>
 */
class InstallFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' =>  $this->faker->firstName(),
            'type' => $this->faker->randomElement(['prd', 'dev']),
            'locked' => false,
            'status' => $this->faker->randomElement(['creating', 'up', 'down']),
        ];
    }
}

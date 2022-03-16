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
            'name' =>  $this->faker->firstName().' Install',
            'type' => $this->faker->randomElement(['prd', 'stg', 'dev']),
            'owner' => $this->faker->randomElement(['mine', 'transferable']),
            'status' => $this->faker->randomElement(['initiated', 'creating', 'created', 'ready', 'down', 'destroying', 'destroyed']),
        ];
    }
}

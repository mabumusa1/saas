<?php

namespace Database\Factories;

use App\Models\Account;
use App\Models\Datacenter;
use App\Models\Site;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SiteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Site::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'account_id' => Account::factory(),
            'datacenter_id' => Datacenter::factory(),
            'name' => $this->faker->name,
        ];
    }
}

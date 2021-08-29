<?php

namespace Database\Seeders;

use App\Models\Environment;
use App\Models\Site;
use Illuminate\Database\Seeder;

class EnvironmentSeeder extends Seeder
{
    /**
     * Create three Environments for three sites.
     *
     * @return void
     */
    public function run()
    {
        $sites = Site::all()->take(3);
        $types = ['prd', 'stg', 'dev'];
        foreach ($sites as $key => $site) {
            if ($site->environments->count() >= 3) {
                continue;
            }
            foreach ($types as $type) {
                Environment::factory()->count(1)->create(['type' => $type, 'site_id' => $site->id]);
            }
        }
    }
}

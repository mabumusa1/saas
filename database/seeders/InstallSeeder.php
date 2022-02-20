<?php

namespace Database\Seeders;

use App\Models\Install;
use App\Models\Site;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstallSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sites = Site::all();
        foreach ($sites as $key => $site) {
            if ($site->installs->count() < 2) {
                Install::factory()->count(2)->create(['site_id' => $site->id]);
            }
        }
    }
}

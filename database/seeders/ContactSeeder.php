<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Install;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $installs = Install::all();
        foreach ($installs as $key => $install) {
            if (empty($install->contact)) {
                Contact::factory()->create(['install_id' => $install->id]);
            }
        }
    }
}

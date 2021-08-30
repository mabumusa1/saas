<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Site;
use App\Models\Team;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class GroupSiteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * Create three groups for the first five teams.
     * Create three sites for the first five team.
     * No groups or sites are created for the others.
     *
     * @return void
     */
    public function run()
    {
        $teams = Team::all()->take(5);

        foreach ($teams as $team) {
            if ($team->groups->count() == 0) {
                Group::factory()->count(3)->create(['team_id' => $team->id]);
            }
            if ($team->sites->count() == 0) {
                Site::factory()->count(3)->create(['team_id' => $team->id]);
            }

            $team->refresh();
            foreach ($team->sites as $site) {
                try {
                    $site->groups()->attach($team->groups->random());
                } catch (QueryException $e) {
                    continue;
                }
            }
        }
    }
}

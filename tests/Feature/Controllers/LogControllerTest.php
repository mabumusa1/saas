<?php

namespace Tests\Feature\Controllers;

use App\Models\Account;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Activitylog\ActivityLogger;
use Tests\TestCase;

class LogControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        $this->account = Account::factory()->create();

        $this->user = User::factory()->create();
        $this->activities = Activity::factory()->count(5)->create([
            'account_id' => $this->account->id,
        ]);
        $this->actingAs($this->user);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_index_displays_all_logs_for_admins()
    {
        $this->account->users()->attach($this->user->id, ['role' => 'admin']);

        $this->get(route('logs.index', $this->account))
            ->assertOk()
            ->assertViewIs('log.index')
            ->assertViewHas('activities', function (Collection $activities) {
                return $activities->intersect(Activity::all())->count() === $activities->count();
            });
    }

    public function test_index_displays_own_logs_for_users()
    {
        $this->account->users()->attach($this->user->id, ['role' => 'fb']);
        Activity::factory(5)->create();
        $this->get(route('logs.index', $this->account))
            ->assertOk()
            ->assertViewIs('log.index')
            ->assertViewHas('activities', function (Collection $activities) {
                return $activities->intersect(Activity::onAccount($this->account->id)->get())->count() === $this->activities->count();
            });
    }
}

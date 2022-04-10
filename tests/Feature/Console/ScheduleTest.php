<?php

namespace Tests\Feature\Console;

use App\Jobs\VerifyDomain;
use App\Models\Domain;
use App\Models\Install;
use App\Models\Site;
use Illuminate\Console\Events\ScheduledTaskFinished;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::setUpAccount();
        $this->site = Site::factory()->for($this->account)->create();
        $this->install = Install::factory()
        ->for($this->site)
        ->create(['name' => 'domain']);
        $this->domain = Domain::factory()
        ->for($this->install)
        ->create(['name' => 'domain.steercampaign.com', 'primary' => true, 'verified_at' => null]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_activity_clean_tasks_running()
    {
        Event::fake();
        $date = new \Carbon\Carbon();
        $firstOfQuarter = $date->firstOfQuarter();
        $this->travelTo($firstOfQuarter);
        $this->artisan('schedule:run');
        Event::assertDispatched(ScheduledTaskFinished::class, function ($event) {
            return strpos($event->task->command, 'activitylog:clean account') !== false;
        });
    }

    public function test_domain_verification_tasks_running()
    {
        Queue::fake();
        $date = new \Carbon\Carbon();
        $startOfMinute = $date->startOfMinute();
        $this->travelTo($startOfMinute);
        $this->artisan('schedule:run');
        $domain = $this->domain;

        Queue::assertPushed(function (VerifyDomain $job) use ($domain) {
            return $job->domain->id === $domain->id;
        });
    }

    public function test_delete_unverified_users()
    {
        Event::fake();
        $date = new \Carbon\Carbon();
        $firstOfDay = $date->floorDay();
        $this->travelTo($firstOfDay);
        $this->artisan('schedule:run');
        Event::assertDispatched(ScheduledTaskFinished::class, function ($event) {
            return strpos($event->task->command, 'accounts:clean') !== false;
        });
    }
}

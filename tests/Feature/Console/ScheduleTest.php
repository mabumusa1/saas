<?php

namespace Tests\Feature;

use Illuminate\Console\Events\ScheduledTaskFinished;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ScheduleTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_scheduled_tasks_running()
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
}

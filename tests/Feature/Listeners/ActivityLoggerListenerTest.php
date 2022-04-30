<?php

namespace Tests\Feature\Listeners;

use App\Events\ActivityLoggerEvent;
use App\Facades\AccountResolver;
use App\Listeners\ActivityLoggerListener;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityLoggerListenerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        parent::addSite();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_handle()
    {
        $event = new ActivityLoggerEvent([
            'name' =>  __('User Logout'),
            'performedOn' => $this->user,
            'causedBy' => $this->user,
            'withProperties' => [],
            'log' => $this->user->fullName.__(' Logged Out Successfully'),
        ]);
        $listener = new ActivityLoggerListener();

        $listener->handle($event);
        $this->assertDatabaseHas('activity_log', [
            'description' => $this->user->fullName.__(' Logged Out Successfully'),
        ]);
    }
}

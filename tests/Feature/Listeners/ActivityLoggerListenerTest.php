<?php

namespace Tests\Feature\Listeners;

use App\Events\ActivityLoggerEvent;
use App\Listeners\ActivityLoggerListener;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ActivityLoggerListenerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_handle()
    {
        $user = User::factory()->create();
        $event = new ActivityLoggerEvent([
            'name' =>  __('User Logout'),
            'performedOn' => $user,
            'causedBy' => $user,
            'withProperties' => [],
            'log' => $user->fullName.__(' Logged Out Successfully'),
        ]);
        $listener = new ActivityLoggerListener();

        $listener->handle($event);

        $this->assertDatabaseHas('activity_log', [
            'description' => $user->fullName.__(' Logged Out Successfully'),
        ]);
    }
}

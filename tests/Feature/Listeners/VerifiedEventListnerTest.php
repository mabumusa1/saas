<?php

namespace Tests\Feature\Listeners;

use App\Events\ActivityLoggerEvent;
use App\Listeners\VerifiedEventListner;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class VerifiedEventListnerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_handle()
    {
        Event::fake();
        $user = User::factory()->create();
        $event = new Verified($user);
        $listener = new VerifiedEventListner();

        $listener->handle($event);

        Event::assertDispatched(ActivityLoggerEvent::class, function ($e) use ($user) {
            return $e->activity['log'] === __('User Verified');
        });
    }
}

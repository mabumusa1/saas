<?php

namespace Tests\Feature\Listeners;

use App\Events\UserInvitedEvent;
use App\Listeners\UserInvitedListener;
use App\Notifications\InviteNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\AnonymousNotifiable;
use Notification;
use Tests\TestCase;

class UserInvitedListenerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_handle()
    {
        Notification::fake();

        $event = new UserInvitedEvent([
            'email' => 'user@email.com',
            'url' => '',
        ]);
        $listener = new UserInvitedListener();

        $listener->handle($event);

        Notification::assertSentTo(
            new AnonymousNotifiable(),
            InviteNotification::class,
            function ($notification, $channels, $notifiable) {
                return $notifiable->routes['mail'] == 'user@email.com';
            }
        );
    }
}

<?php

namespace Tests\Feature\Listeners;

use App\Events\UserInvitedEvent;
use App\Listeners\UserInvitedListener;
use App\Notifications\InviteNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
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
        Mail::fake();

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
                $mailData = $notification->toMail()->toArray();
                $this->assertEquals('Greetings!', $mailData['greeting']);
                // TODO: Add more assertions to make sure the email is correct
                return $notifiable->routes['mail'] == 'user@email.com';
            }
        );
    }
}

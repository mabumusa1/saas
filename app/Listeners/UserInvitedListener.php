<?php

namespace App\Listeners;

use App\Events\UserInvitedEvent;
use App\Notifications\InviteNotification;
use Notification;

class UserInvitedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserInvitedEvent  $event
     *
     * @return void
     */
    public function handle(UserInvitedEvent $event)
    {
        Notification::route('mail', $event->params['email'])->notify(new InviteNotification($event->params['url']));
    }
}

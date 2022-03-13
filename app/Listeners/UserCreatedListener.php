<?php

namespace App\Listeners;

use App\Events\UserCreatedEvent;
use App\Notifications\UserCreatedNotification;
use Auth;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UserCreatedListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\UserCreatedEvent  $event
     * @return void
     */
    public function handle(UserCreatedEvent $event)
    {
        $event->user->notify(new UserCreatedNotification($event->password));
        $authUser = Auth::user();
        activity(__('New User Added'))
            ->performedOn($event->user)
            ->causedBy($authUser)
            ->withProperties(['account_id' => $account->id])
            ->log('User created by '.$authUser->fullName);
    }
}

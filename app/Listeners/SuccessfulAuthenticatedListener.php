<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Authenticated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SuccessfulAuthenticatedListener
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
     * @param  \Illuminate\Auth\Events\Authenticated  $event
     * @return void
     */
    public function handle(Authenticated $event)
    {
        /*
         $user = $event->user;
        dd($user->accounts->first()->id);
        $accountId = $user->accounts()->wherePivot('role', 'owner')->get()->first()->id;
        session(['deafultAccountId' => $accountId]);
        */
    }
}

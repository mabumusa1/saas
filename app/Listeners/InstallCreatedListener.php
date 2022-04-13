<?php

namespace App\Listeners;

use App\Models\Contact;

class InstallCreatedListener
{
    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Contact::create([
            'install_id' => $event->install->id,
            'first_name' => $event->user->first_name,
            'last_name' => $event->user->last_name,
            'email' => $event->user->email,
        ]);
    }
}

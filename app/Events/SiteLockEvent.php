<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Install;

class SiteLockEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Install $install;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Install $install)
    {
        $this->install = $install;
    }
}

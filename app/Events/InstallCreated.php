<?php

namespace App\Events;

use App\Models\Install;
use App\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InstallCreated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $install;

    public $user;

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

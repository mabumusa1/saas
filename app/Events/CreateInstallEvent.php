<?php

namespace App\Events;

use App\Models\Install;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreateInstallEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The install instance.
     *
     * @var \App\Models\Install
     */
    public $install;

    /**
     * The type of the operation.
     *
     * @var string
     */
    public $operation;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Install $install, String $operation = null)
    {
        $this->install = $install;
        $this->operation = $operation;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}

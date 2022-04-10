<?php

namespace App\Events;

use App\Models\InstallBackup;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RestoreBackupEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $backup;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(InstallBackup $backup)
    {
        $this->backup = $backup;
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

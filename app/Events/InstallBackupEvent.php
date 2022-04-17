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

class InstallBackupEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $install;

    public $source;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Install $install, string $source = 'automated')
    {
        $this->install = $install;
        $this->source = $source;
    }
}

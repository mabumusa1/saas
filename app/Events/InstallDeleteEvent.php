<?php

namespace App\Events;

use App\Models\Install;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InstallDeleteEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    protected $install;

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

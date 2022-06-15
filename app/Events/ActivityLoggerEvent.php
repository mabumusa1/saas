<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityLoggerEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The order instance.
     *
     * @var array
     */
    public $activity;

    /**
     * Create a new event instance.
     *
     * @param array $activity
     *
     * @return void
     */
    public function __construct(array $activity)
    {
        $this->activity = $activity;
    }
}

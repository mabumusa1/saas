<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserInvitedEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * The user instance.
     *
     * @var array
     */
    public $params;

    public $password;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }
}

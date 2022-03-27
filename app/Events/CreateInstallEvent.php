<?php

namespace App\Events;

use App\Models\Install;
use Illuminate\Broadcasting\InteractsWithSockets;
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
    public function __construct(Install $install, ?string $operation = null)
    {
        $this->install = $install;
        $this->operation = $operation;
    }
}

<?php

namespace App\Events;

use App\Models\Domain;
use App\Models\Install;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InstallSetDomain
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $install;

    public $domain;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Install $install, Domain $domain)
    {
        $this->install = $install;
        $this->domain = $domain;
    }
}

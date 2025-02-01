<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserActivation
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    /**
     * @param \App\Models\User $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
}

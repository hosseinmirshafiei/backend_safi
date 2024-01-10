<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TestPrivateEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $Message, $username;

    public function __construct($m, $u)
    {
        $this->Message = $m;
        $this->username = $u;
    }
    
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name.38');
    }
    public function broadcastAs()
    {
        return "CHM";
    }
    public function broadcastWith()
    {
        return [
            'username' => $this->username,
            'message' => $this->Message
        ];
    }
}

<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Ship
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    public $phoneNumber;
    public $shipAddress;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($phoneNumber, $shipAddress)
    {
        $this->phoneNumber = $phoneNumber;
        $this->shipAddress = $shipAddress;

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
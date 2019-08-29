<?php

namespace App\Events;

use App\Model\Dosen;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class StatusEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $dosen;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Dosen $dosen)
    {
        $this->dosen = $dosen;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['channel-status'];
    }

    public function broadcastWith()
    {
        return [
            'data' => $this->dosen
        ];
    }

    public function broadcastAs()
    {
        return 'event-status';
    }

}

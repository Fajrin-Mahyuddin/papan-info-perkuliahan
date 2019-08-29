<?php

namespace App\Events;

use App\Model\PindahJadwal;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class PindahEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $pindah;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(PindahJadwal $pindah)
    {
        $this->pindah = $pindah;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['channel-pindah'];
    }

    public function broadcastWith()
    {
        return [
            'data' => $this->pindah
        ];
    }

    public function broadcastAs()
    {
        return 'event-pindah';
    }

}

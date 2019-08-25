<?php

namespace App\Events;

use App\Model\JadwalKuliah;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class AddJadwal implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $jadwal;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(JadwalKuliah $jadwal)
    {
        $this->jadwal = $jadwal;
    }

    public function broadcastWith()
    {
        return [
            'data' => $jadwal
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    // public function broadcastOn()
    // {
    //     return ['channel-jadwal'];
    // }

    // public function broadcastAs()
    // {
    //     // return new PresenceChannel('channelku');
    //     return 'event-jadwal';
    // }
}

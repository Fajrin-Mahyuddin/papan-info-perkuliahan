<?php

namespace App\Listeners;

use App\Events\JadwalEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class addJadwal
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  JadwalEvent  $event
     * @return void
     */
    public function handle(JadwalEvent $event)
    {
        //
    }
}

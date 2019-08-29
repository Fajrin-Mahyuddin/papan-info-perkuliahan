<?php

namespace App\Console;

use Carbon\Carbon;
use App\Model\Dosen;
use App\Model\JadwalKuliah;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        // $schedule->command(function() {
            // $jam = Carbon::parse(now())->formatLocalized('%H:%I');
            // $jadwal = JadwalKuliah::when('status'  == 'pindah', function($query) {
            //     $query->where('jam_mulai_pindah', $jam);
            // });
        //     Dosen::where('id_dosen', 17)->update(['alamat' => 'perubahan  !']);
        // })->everyMinute();
        $schedule->command('command:expiredJadwal')->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}

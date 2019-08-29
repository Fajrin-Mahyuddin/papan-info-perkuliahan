<?php

namespace App\Console\Commands;

use App\Model\Dosen;
use Illuminate\Console\Command;

class ExpiredCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:expiredJadwal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Dosen::where('id_dosen', 17)->update(['alamat' => 'perubahan menggunakan command !']);
    }
}

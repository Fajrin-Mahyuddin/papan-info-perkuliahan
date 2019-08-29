<?php

namespace App\Providers;

// use App\Model\Semester;
use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        require_once app_path() . '/Helpers/AdminHelper.php';
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // setlocale(LC_TIME, 'id');
        // setlocale(LC_ALL, 'id');
        // config(['app.locale' => 'id']);
        setlocale(LC_ALL, 'id_ID.utf8');
        Carbon::setLocale('id_ID.utf8');
        // Carbon::setLocale('id_ID.utf8');
        date_default_timezone_set('Asia/Singapore');
    }
}

<?php

namespace App\Providers;

use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Redirect;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('REDIRECT', '') != '') {
            Redirect::away(env('REDIRECT', ''))->send();
        }  

        if(env('APP_HTTPS',0) == 1) {
            \URL::forceScheme('https');
        }

        ini_set('memory_limit', '600M');
        ini_set('max_execution_time', 1300);
        Config::set([
            'save_success' => 'Data berhasil disimpan',
            'delete_success' => 'Data berhasil dihapus',
            'delete_confirm' => 'Apakah Anda yakin ingin menghapus data ini?',
        ]);
    }
}
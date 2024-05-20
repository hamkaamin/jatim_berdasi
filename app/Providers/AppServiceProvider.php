<?php

namespace App\Providers;

use Config;
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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if(env('APP_HTTPS',0) == 1) {
            \URL::forceScheme('https');
        }
        Config::set([
            'save_success' => 'Data berhasil disimpan',
            'delete_success' => 'Data berhasil dihapus',
            'delete_confirm' => 'Apakah Anda yakin ingin menghapus data ini?',
        ]);
    }
}
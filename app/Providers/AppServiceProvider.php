<?php

namespace App\Providers;

use Auth;
use Config;
use Illuminate\Contracts\View\View;
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
        Config::set([
            'save_success' => 'Data berhasil disimpan',
            'delete_success' => 'Data berhasil dihapus',
            'delete_confirm' => 'Apakah Anda yakin ingin menghapus data ini?',
        ]);

        view()->composer('*', function (View $view) {
            $role = "-";
            // Otomatis mengubah angka kode role menjadi nama role
            if (Auth::check()) {
                if (Auth::user()->role == 1) {
                    $role = "Super Admin";
                } elseif (Auth::user()->role == 2) {
                    $role = "Verifikator";
                } elseif (Auth::user()->role == 3) {
                    $role = "Admin - Provinsi";
                } elseif (Auth::user()->role == 4) {
                    $role = "Admin - Kab/Kota";
                } elseif (Auth::user()->role == 5) {
                    $role = "OPD";
                } elseif (Auth::user()->role == 6) {
                    $role = "Umum";
                }
            }
            $view->with([
                'role' => $role
            ]);
        });
    }
}

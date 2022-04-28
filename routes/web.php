<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::post('/modal', [App\Http\Controllers\HomeController::class, 'modal'])->name('modal');

    Route::prefix('profil')->name('profil.')->group(function () {
        Route::get('/', [App\Http\Controllers\ProfilController::class, 'index'])->name('index');
        Route::post('/change-password', [App\Http\Controllers\ProfilController::class, 'change_pass'])->name('change-pass');
    });

    Route::prefix('master')->name('master.')->group(function () {
        Route::prefix('indikator')->name('indikator.')->group(function () {
            Route::get('/', [App\Http\Controllers\IndikatorController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\IndikatorController::class, 'save'])->name('save');
            Route::post('/delete', [App\Http\Controllers\IndikatorController::class, 'delete'])->name('delete');
        });
        Route::prefix('tahapan')->name('tahapan.')->group(function () {
            Route::get('/', [App\Http\Controllers\TahapanController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\TahapanController::class, 'save'])->name('save');
            Route::post('/delete', [App\Http\Controllers\TahapanController::class, 'delete'])->name('delete');
        });
        Route::prefix('inisiator')->name('inisiator.')->group(function () {
            Route::get('/', [App\Http\Controllers\InisiatorController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\InisiatorController::class, 'save'])->name('save');
            Route::post('/delete', [App\Http\Controllers\InisiatorController::class, 'delete'])->name('delete');
        });
        Route::prefix('jenis')->name('jenis.')->group(function () {
            Route::get('/', [App\Http\Controllers\JenisController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\JenisController::class, 'save'])->name('save');
            Route::post('/delete', [App\Http\Controllers\JenisController::class, 'delete'])->name('delete');
        });
        Route::prefix('urusan')->name('urusan.')->group(function () {
            Route::get('/', [App\Http\Controllers\UrusanController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\UrusanController::class, 'save'])->name('save');
            Route::post('/delete', [App\Http\Controllers\UrusanController::class, 'delete'])->name('delete');
        });
        Route::prefix('bentuk')->name('bentuk.')->group(function () {
            Route::get('/', [App\Http\Controllers\BentukController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\BentukController::class, 'save'])->name('save');
            Route::post('/delete', [App\Http\Controllers\BentukController::class, 'delete'])->name('delete');
        });
        Route::prefix('jabatan')->name('jabatan.')->group(function () {
            Route::get('/', [App\Http\Controllers\JabatanController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\JabatanController::class, 'save'])->name('save');
            Route::post('/delete', [App\Http\Controllers\JabatanController::class, 'delete'])->name('delete');
        });
        Route::prefix('golongan')->name('golongan.')->group(function () {
            Route::get('/', [App\Http\Controllers\GolonganController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\GolonganController::class, 'save'])->name('save');
            Route::post('/delete', [App\Http\Controllers\GolonganController::class, 'delete'])->name('delete');
        });
        Route::prefix('faq')->name('faq.')->group(function () {
            Route::get('/', [App\Http\Controllers\FaqController::class, 'index'])->name('index');
            Route::post('/', [App\Http\Controllers\FaqController::class, 'save'])->name('save');
            Route::post('/delete', [App\Http\Controllers\FaqController::class, 'delete'])->name('delete');
        });
    });

    Route::prefix('pengguna')->name('pengguna.')->group(function () {
        Route::get('/', [App\Http\Controllers\PenggunaController::class, 'index'])->name('index'); 
    });

    Route::prefix('opd')->name('opd.')->group(function () {
        Route::get('/', [App\Http\Controllers\OpdController::class, 'index'])->name('index'); 
    });
});

Auth::routes();

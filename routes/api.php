<?php

use App\Http\Controllers\Api\ApiSyncController;
use App\Http\Controllers\Api\InovasiController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register',[AuthController::class,'register']);
Route::post('login', [AuthController::class,'login']);
Route::post('refresh', [AuthController::class,'refresh']);
Route::post('logout', [AuthController::class,'logout']);

Route::get('all_opd',[ApiController::class,'all_opd']);
Route::get('indikator_parameter', [InovasiController::class,'indikator_parameter']);

// mengirim data pertama kali
    // dari kab ngehit ke provinsi
    Route::get('kab_hit_data', [ApiSyncController::class,'kab_hit_data']);
    // provinsi menerima hit data
    Route::post('insert_inovasi2', [ApiController::class,'insert_inovasi2']);



// sync status
    // kab ngehit provinsi untuk lihat status terkininya
    Route::get('kab_read_data', [ApiSyncController::class,'kab_read_data']);
    // dari provinsi respon data-data yang sudah pernah dikirim
    Route::post('kab_status_data', [ApiSyncController::class,'kab_status_data']);  

    Route::post('kab_status_data_update', [ApiController::class,'kab_status_data_update']);  
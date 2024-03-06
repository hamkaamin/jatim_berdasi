<?php

use App\Http\Controllers\Api\ApiSyncController;
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
Route::get('kab_hit_data', [ApiSyncController::class,'kab_hit_data']);
Route::post('insert_inovasi', [ApiController::class,'insert_inovasi']);
Route::post('insert_inovasi', [ApiController::class,'insert_inovasi']);
// Route::post('insert_inovasi_list', [ApiController::class,'insert_inovasi_list']);
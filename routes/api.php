<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\Owner\HotelController;
use App\Http\Controllers\Api\V1\Owner\RoomController;
use App\Http\Controllers\Api\V1\public\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These.
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('rooms',RoomController::class);
    Route::apiResource('hotels',HotelController::class);
    Route::post('logout/{user}',[AuthController::class ,'logout']);
});

Route::Post('register',[AuthController::class ,'register']);
Route::Post('login',[AuthController::class ,'login']);


Route::get('search',PublicController::class);

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

Route::get('search', PublicController::class);

Route::controller(AuthController::class)->group(function () {
    //controller group https://laravel.com/docs/10.x/routing#route-groups
    //you used your own auth which is okay but check out laravel breeze, it will give u these routes by default
    //https://laravel.com/docs/10.x/starter-kits#breeze-and-next

    Route::Post('register','register'); 
    //you should stick with the restfull naming conventions for you methods
    //https://laravel.com/docs/10.x/controllers#actions-handled-by-resource-controller

    Route::Post('login', 'login');
    Route::post('logout/{user}','logout');// you don't need the user id in the route binding, you can get the authenticated user via auth()->user()
});

Route::middleware(['auth:sanctum'])->group(function () { //midleware group (check prefix group as well)
                                                        

    Route::get('/user', function (Request $request) { 
        //avoid doing logic here, make an invokable one action controller https://laravel.com/docs/10.x/controllers#single-action-controllers
        //php artisan make:controller UserController --invokable
        return $request->user();//u can do auth()->user() as well
    });

    Route::apiResource('rooms', RoomController::class);

    Route::apiResource('hotels', HotelController::class);

});

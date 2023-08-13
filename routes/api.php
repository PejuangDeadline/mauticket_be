<?php

use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\ApiEventController;
use App\Http\Controllers\API\ApiRegisterController;
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

Route::post('register', [ApiRegisterController::class, 'register']);
Route::post('getToken', [ApiRegisterController::class, 'getToken']);

Route::middleware('auth:api')->group(function () {
    //Auth for FE
    Route::post('signup/store', [ApiAuthController::class, 'storesignup']);
    Route::post('send-token', [ApiAuthController::class, 'sendToken']);
    Route::post('verify-email', [ApiAuthController::class, 'verifemail']);

    //API Event
    Route::post('event/search', [ApiEventController::class, 'eventSearch']);
});

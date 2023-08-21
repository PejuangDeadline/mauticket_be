<?php

use App\Http\Controllers\API\ApiAuthController;
use App\Http\Controllers\API\ApiEventController;
use App\Http\Controllers\API\ApiRegisterController;
use App\Http\Controllers\API\ApiTransactionController;
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
Route::post('e-ticket', [ApiTransactionController::class, 'eTicket']);

Route::middleware('auth:api')->group(function () {
    //Auth for FE
    Route::post('signup/store', [ApiAuthController::class, 'storesignup']);
    Route::post('send-token', [ApiAuthController::class, 'sendToken']);
    Route::post('verify-email', [ApiAuthController::class, 'verifemail']);

    //API Event
    Route::post('event/search', [ApiEventController::class, 'eventSearch']);
    Route::get('event/{id_event}', [ApiEventController::class, 'getByEvent']);
    Route::post('showtime', [ApiEventController::class, 'getByShowtime']);
    Route::get('category/{id_category}', [ApiEventController::class, 'getByCategory']);

    //API Transaction
    Route::post('chart/add', [ApiTransactionController::class, 'chartAdd']);
    Route::get('chart/view/{id_user}', [ApiTransactionController::class, 'chartView']);
    Route::get('chart/delete/{id_chart}', [ApiTransactionController::class, 'chartDelete']);
    Route::post('refcode/check', [ApiTransactionController::class, 'refCodeCheck']);
    Route::post('seats/check', [ApiTransactionController::class, 'seatCheck']);
    Route::post('checkout', [ApiTransactionController::class, 'checkoutStore']);
    Route::post('payment/upload', [ApiTransactionController::class, 'paymentUpload']);
    Route::post('payment/submit', [ApiTransactionController::class, 'paymentSubmit']);
    Route::get('payment/method/{id_event}', [ApiTransactionController::class, 'paymentMethod']);
});

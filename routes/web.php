<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RefCodeController;
use App\Http\Controllers\RulesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\ShowtimeController;
use App\Http\Controllers\MstPartnerController;
use App\Http\Controllers\SeatController;
use App\Http\Controllers\TicketPaymentController;
use App\Http\Controllers\TicketCategoryController;


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
//Login Controller
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/auth/login', [AuthController::class, 'postLogin']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {
    //Home Controller
    Route::get('/home', [HomeController::class, 'index']);

    //Dropdown Controller
    Route::get('/dropdown', [DropdownController::class, 'index']);
    Route::post('/dropdown/store', [DropdownController::class, 'store']);
    Route::patch('/dropdown/update/{id}', [DropdownController::class, 'update']);
    Route::delete('/dropdown/delete/{id}', [DropdownController::class, 'delete']);

    //Rules Controller
    Route::get('/rule', [RulesController::class, 'index']);
    Route::post('/rule/store', [RulesController::class, 'store']);
    Route::patch('/rule/update/{id}', [RulesController::class, 'update']);
    Route::delete('/rule/delete/{id}', [RulesController::class, 'delete']);

    //User Controller
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user/store', [UserController::class, 'store']);
    Route::patch('/user/update/{user}', [UserController::class, 'update']);
    Route::get('/user/revoke/{user}', [UserController::class, 'revoke']);
    Route::get('/user/access/{user}', [UserController::class, 'access']);

    //Partner
    Route::get('/partner', [MstPartnerController::class, 'index']);
    Route::post('/partner/store', [MstPartnerController::class, 'storePartner']);
    Route::post('/partner/update', [MstPartnerController::class, 'StoreUpdatePartner']);
    Route::patch('/partner/active/{id}', [MstPartnerController::class, 'activePartner']);
    Route::patch('/partner/inactive/{id}', [MstPartnerController::class, 'destroyPartner']);
    Route::post('/contract', [MstPartnerController::class, 'storeContract']);
    Route::post('/contract/update', [MstPartnerController::class, 'updateContract']);

    //Event
    Route::get('/event', [EventController::class, 'index']);
    Route::post('/event/store', [EventController::class, 'storeEvent']);
    Route::post('/event/update', [EventController::class, 'storeUpdateEvent']);
    Route::delete('/event/destroy/{id}', [EventController::class, 'destroyEvent']);
    Route::get('/event/detail/{id}', [EventController::class, 'detailEvent']);

    //Ticket Category
    Route::get('/ticket-category/{id}', [TicketCategoryController::class, 'index']);
    Route::post('/ticket-category/store/{id}', [TicketCategoryController::class, 'store']);
    Route::patch('/ticket-category/edit/{id}', [TicketCategoryController::class, 'edit']);
    Route::delete('/ticket-category/destroy/{id}', [TicketCategoryController::class, 'destroy']);

    //Ticket Excel
    Route::get('/download-template/{idEvent}/{idCategory}', [ExcelController::class, 'downloadTemplate']);
    Route::post('/import/{idEvent}/{idCategory}', [ExcelController::class, 'importData']);

    //Ticket Seats 
    Route::get('/list-seats/{id}', [SeatController::class, 'index']);

    //Ticket Payment
    Route::get('/ticket-payment/{id}', [TicketPaymentController::class, 'index']);
    Route::post('/ticket-payment/store/{id}', [TicketPaymentController::class, 'store']);
    Route::patch('/ticket-payment/edit/{idEvent}/{id}', [TicketPaymentController::class, 'edit']);
    Route::delete('/ticket-payment/destroy/{idEvent}/{id}', [TicketPaymentController::class, 'destroy']);

    //Show Time
    Route::get('/show-time/{id}', [ShowtimeController::class, 'index']);
    Route::post('/show-time/store/{id}/{idCategory}', [ShowtimeController::class, 'store']);
    Route::patch('/show-time/edit/{id}/{idEvent}', [ShowtimeController::class, 'edit']);
    Route::delete('/show-time/destroy/{id}/{idEvent}', [ShowtimeController::class, 'destroy']);

    //Referral Code
    Route::get('/ref-code', [RefCodeController::class, 'index']);
    Route::post('/ref-code/store', [RefCodeController::class, 'store']);
    Route::patch('/ref-code/edit/{id}', [RefCodeController::class, 'edit']);
    Route::delete('/ref-code/destroy/{id}', [RefCodeController::class, 'destroy']);

    //ajaxArea
    Route::get('/ajax/mappingCity/{province_id}', 'App\Http\Controllers\AjaxAreaController@searchCity')->name('mappingCity');
    Route::get('/ajax/mappingDistrict/{city_id}', 'App\Http\Controllers\AjaxAreaController@searchDistrict')->name('mappingDistrict');
    Route::get('/ajax/mappingSubDistrict/{district_id}', 'App\Http\Controllers\AjaxAreaController@searchSubDistrict')->name('mappingSubDistrict');
    Route::get('/ajax/mappingZipcode/{subdistrict_id}', 'App\Http\Controllers\AjaxAreaController@searchZipcode')->name('mappingZipcode');
});

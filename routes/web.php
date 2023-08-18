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
use App\Http\Controllers\TransactionController;

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
    Route::get('/dropdown', [DropdownController::class, 'index'])->middleware(['checkRole:Super Admin']);
    Route::post('/dropdown/store', [DropdownController::class, 'store'])->middleware(['checkRole:Super Admin']);
    Route::patch('/dropdown/update/{id}', [DropdownController::class, 'update'])->middleware(['checkRole:Super Admin']);
    Route::delete('/dropdown/delete/{id}', [DropdownController::class, 'delete'])->middleware(['checkRole:Super Admin']);

    //Rules Controller
    Route::get('/rule', [RulesController::class, 'index'])->middleware(['checkRole:Super Admin']);
    Route::post('/rule/store', [RulesController::class, 'store'])->middleware(['checkRole:Super Admin']);
    Route::patch('/rule/update/{id}', [RulesController::class, 'update'])->middleware(['checkRole:Super Admin']);
    Route::delete('/rule/delete/{id}', [RulesController::class, 'delete'])->middleware(['checkRole:Super Admin']);

    //User Controller
    Route::get('/user', [UserController::class, 'index'])->middleware(['checkRole:Super Admin']);
    Route::post('/user/store', [UserController::class, 'store'])->middleware(['checkRole:Super Admin']);
    Route::post('/user/store-partner', [UserController::class, 'storePartner'])->middleware(['checkRole:Super Admin']);
    Route::patch('/user/update/{user}', [UserController::class, 'update'])->middleware(['checkRole:Super Admin']);
    Route::get('/user/revoke/{user}', [UserController::class, 'revoke'])->middleware(['checkRole:Super Admin']);
    Route::get('/user/access/{user}', [UserController::class, 'access'])->middleware(['checkRole:Super Admin']);

    //Partner
    Route::get('/partner', [MstPartnerController::class, 'index'])->middleware(['checkRole:Super Admin']);
    Route::post('/partner/store', [MstPartnerController::class, 'storePartner'])->middleware(['checkRole:Super Admin']);
    Route::post('/partner/update', [MstPartnerController::class, 'StoreUpdatePartner'])->middleware(['checkRole:Super Admin']);
    Route::patch('/partner/active/{id}', [MstPartnerController::class, 'activePartner'])->middleware(['checkRole:Super Admin']);
    Route::patch('/partner/inactive/{id}', [MstPartnerController::class, 'destroyPartner'])->middleware(['checkRole:Super Admin']);
    Route::post('/contract', [MstPartnerController::class, 'storeContract'])->middleware(['checkRole:Super Admin']);
    Route::post('/contract/update', [MstPartnerController::class, 'updateContract'])->middleware(['checkRole:Super Admin']);

    //Event
    Route::get('/event', [EventController::class, 'index'])->middleware(['checkRole:User']);
    Route::post('/event/store', [EventController::class, 'storeEvent'])->middleware(['checkRole:User']);
    Route::post('/event/update', [EventController::class, 'storeUpdateEvent'])->middleware(['checkRole:User']);
    Route::delete('/event/destroy/{id}', [EventController::class, 'destroyEvent'])->middleware(['checkRole:User']);
    Route::patch('/event/active/{id}', [EventController::class, 'activeEvent'])->middleware(['checkRole:User']);
    Route::get('/event/detail/{id}', [EventController::class, 'detailEvent'])->middleware(['checkRole:User']);
    Route::post('/event/venue/{id}', [EventController::class, 'UploadAttachmentVenue'])->middleware(['checkRole:User']);

    //Ticket Category
    Route::get('/ticket-category/{id}', [TicketCategoryController::class, 'index'])->middleware(['checkRole:User']);
    Route::post('/ticket-category/store/{id}', [TicketCategoryController::class, 'store'])->middleware(['checkRole:User']);
    Route::patch('/ticket-category/edit/{id}', [TicketCategoryController::class, 'edit'])->middleware(['checkRole:User']);
    Route::delete('/ticket-category/destroy/{id}', [TicketCategoryController::class, 'destroy'])->middleware(['checkRole:User']);

    //Ticket Excel
    Route::get('/download-template/{idEvent}/{idCategory}', [ExcelController::class, 'downloadTemplate'])->middleware(['checkRole:User']);
    Route::post('/import/{idEvent}/{idCategory}', [ExcelController::class, 'importData'])->middleware(['checkRole:User']);

    //Ticket Seats
    Route::get('/list-seats/{id}', [SeatController::class, 'index'])->middleware(['checkRole:User']);

    //Ticket Transaction
    Route::get('/transaction', [TransactionController::class, 'index'])->middleware(['checkRole:User']);

    //Ticket Payment
    Route::get('/ticket-payment/{id}', [TicketPaymentController::class, 'index'])->middleware(['checkRole:User']);
    Route::post('/ticket-payment/store/{id}', [TicketPaymentController::class, 'store'])->middleware(['checkRole:User']);
    Route::patch('/ticket-payment/edit/{idEvent}/{id}', [TicketPaymentController::class, 'edit'])->middleware(['checkRole:User']);
    Route::delete('/ticket-payment/destroy/{idEvent}/{id}', [TicketPaymentController::class, 'destroy'])->middleware(['checkRole:User']);

    //Show Time
    Route::get('/show-time/{id}', [ShowtimeController::class, 'index'])->middleware(['checkRole:User']);
    Route::post('/show-time/store/{id}/{idCategory}', [ShowtimeController::class, 'store'])->middleware(['checkRole:User']);
    Route::patch('/show-time/edit/{id}/{idEvent}', [ShowtimeController::class, 'edit'])->middleware(['checkRole:User']);
    Route::delete('/show-time/destroy/{id}/{idEvent}', [ShowtimeController::class, 'destroy'])->middleware(['checkRole:User']);

    //Referral Code
    Route::get('/ref-code', [RefCodeController::class, 'index'])->middleware(['checkRole:User']);
    Route::post('/ref-code/store', [RefCodeController::class, 'store'])->middleware(['checkRole:User']);
    Route::patch('/ref-code/edit/{id}', [RefCodeController::class, 'edit'])->middleware(['checkRole:User']);
    Route::delete('/ref-code/destroy/{id}', [RefCodeController::class, 'destroy'])->middleware(['checkRole:User']);

    //ajaxArea
    Route::get('/ajax/mappingCity/{province_id}', 'App\Http\Controllers\AjaxAreaController@searchCity')->name('mappingCity');
    Route::get('/ajax/mappingDistrict/{city_id}', 'App\Http\Controllers\AjaxAreaController@searchDistrict')->name('mappingDistrict');
    Route::get('/ajax/mappingSubDistrict/{district_id}', 'App\Http\Controllers\AjaxAreaController@searchSubDistrict')->name('mappingSubDistrict');
    Route::get('/ajax/mappingZipcode/{subdistrict_id}', 'App\Http\Controllers\AjaxAreaController@searchZipcode')->name('mappingZipcode');
});

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DropdownController;
use App\Http\Controllers\RulesController;

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

//Home Controller
Route::get('/home', [HomeController::class, 'index']);

//Dropdown Controller
Route::get('/dropdown', [DropdownController::class, 'index']);

//Rules Controller
Route::get('/rule', [RulesController::class, 'index']);
Route::post('/rule/store', [RulesController::class, 'store']);
Route::patch('/rule/update/{id}', [RulesController::class, 'update']);
Route::delete('/rule/delete/{id}', [RulesController::class, 'delete']);

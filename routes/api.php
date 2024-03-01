<?php

use App\Http\Controllers\Api\NotificationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'App\Http\Controllers\Api\AuthController@register');
});

Route::controller(NotificationController::class)->group(function () {  
    Route::post('/supermarket_notification', 'supermarket_notification')->name('supermarket_notification');
});
<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [UserController::class, 'login']);


Route::group(['middleware' => ['auth:api']], function () {

    Route::group(['prefix' => 'order'], function () {
        Route::get('/', [OrderController::class, 'index']);
        Route::delete('/destroy/{id}', [OrderController::class, 'destroy'])->where('id', '[0-9]+');
        Route::post('/create', [OrderController::class, 'create']);
        Route::get('/discounts/{id}', [OrderController::class, 'discounts'])->where('id', '[0-9]+');
    });
});



<?php

use App\Http\Controllers\Api\V1\RentController;
use Illuminate\Support\Facades\Route;


Route::middleware('api')
    ->prefix('v1')
    ->group(function () {
        Route::prefix('rent')->group(function () {
            Route::post('/create', [RentController::class, 'create']);
            Route::patch('/change-status', [RentController::class, 'changeStatus']);
            Route::get('/history', [RentController::class, 'history']);
        });
    });

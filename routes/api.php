<?php

use App\Http\Controllers\Api\CourierLocationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {
    // Courier location tracking
    Route::post('/courier/location', [CourierLocationController::class, 'update']);
    Route::post('/courier/location/stop', [CourierLocationController::class, 'stopTracking']);
    Route::get('/orders/{order}/tracking', [CourierLocationController::class, 'getForOrder']);
});

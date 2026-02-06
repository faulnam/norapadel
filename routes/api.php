<?php

use App\Http\Controllers\Api\CourierLocationController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PushNotificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Notification check (requires web auth via session)
Route::middleware('web')->group(function () {
    Route::get('/notifications/check', [NotificationController::class, 'check']);
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead']);
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead']);
    
    // Push notification endpoints
    Route::get('/push/vapid-key', [PushNotificationController::class, 'getVapidKey']);
    Route::post('/push/subscribe', [PushNotificationController::class, 'subscribe']);
    Route::post('/push/unsubscribe', [PushNotificationController::class, 'unsubscribe']);
});

Route::middleware('auth:sanctum')->group(function () {
    // Courier location tracking
    Route::post('/courier/location', [CourierLocationController::class, 'update']);
    Route::post('/courier/location/stop', [CourierLocationController::class, 'stopTracking']);
    Route::get('/orders/{order}/tracking', [CourierLocationController::class, 'getForOrder']);
});

<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PageController;
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
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('profile', [PageController::class, 'profile']);
    Route::get('transaction', [PageController::class, 'transaction']);
    Route::get('transaction/{id}', [PageController::class, 'transactionDetail']);
    Route::get('notification', [PageController::class, 'notification']);
    Route::get('notification-detail/{id}', [PageController::class, 'notificationDetail']);
    Route::get('check-verify-account', [PageController::class, 'checkVerfiy']);

    Route::get('transfer/confirm', [PageController::class, 'transferConfirm']);
    Route::post('transfer/complete', [PageController::class, 'transferComplete']);
    Route::get('transfer', [PageController::class, 'transfer']); //scan and pay
});

<?php

use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Frontend\NotificationController;
use App\Http\Controllers\Frontend\PageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
 */

// user Auth
Auth::routes();

// admin Auth
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm']);
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// home page
Route::middleware('auth')->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/profile', [PageController::class, 'profile'])->name('profile');

    Route::get('/update-password', [PageController::class, 'updatePassword'])->name('update-password');
    Route::post('/update-password', [PageController::class, 'updatePasswordStore'])->name('update-password.store');
    Route::get('/wallet', [PageController::class, 'wallet'])->name('wallet');
    Route::get('/transfer', [PageController::class, 'transfer'])->name('transfer');
    Route::get('/transfer/confirm', [PageController::class, 'transferConfirm'])->name('transfer.confirm');
    Route::post('/transfer/complete', [PageController::class, 'transferComplete'])->name('transfer.complete');
    Route::get('/transaction', [PageController::class, 'transaction'])->name('transaction');
    Route::get('/transaction/detail/{id}', [PageController::class, 'transactionDetail'])->name('transaction.detail');
    Route::get('/my-qr', [PageController::class, 'myQr']);
    Route::get('/scan-to-pay', [PageController::class, 'scanToPay']);

    Route::get('/notification', [NotificationController::class, 'index'])->name('notification');
    Route::get('/notification-detail/{id}', [NotificationController::class, 'show'])->name('notification-detail');

// ajax call route
    Route::get('/password-check', [PageController::class, 'passwordCheck']);
    Route::get('/check-verify-account', [PageController::class, 'checkVerifyAccount']);
    Route::get('/transfer-check', [PageController::class, 'transferCheck']);

});

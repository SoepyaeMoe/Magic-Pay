<?php

use App\Http\Controllers\Backend\AdminUserController;
use App\Http\Controllers\Backend\PageController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\WalletController;
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
Route::middleware('auth:admin_user')->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');

    // admin users
    Route::resource('/admin-user', AdminUserController::class);
    Route::get('/admin-user/datatable/ssd', [AdminUserController::class, 'ssd']);

    // users
    Route::get('/user/datatable/ssd', [UserController::class, 'ssd']);
    Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
    Route::post('/user/store', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    Route::post('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
    Route::DELETE('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');

    // walle
    Route::get('/wallet/datatable/ssd', [WalletController::class, 'ssd']);
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
});

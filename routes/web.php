<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MekanikController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TrxMekanikController;
use App\Http\Controllers\TrxProductController;
use App\Models\Product;
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


Route::get('/test', function () {
    return 'This is a test route!';
});


Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'auth'])->name('login.store');


Route::middleware(['auth'])->group(function () {
    Route::get('/', function () {
        return view('welcome');
    });

    Route::get('/profile', [AccountController::class, 'profile'])->name('profile');
    Route::post('/profile', [AccountController::class, 'profileUpdate'])->name('profile.store');
    Route::post('/password-update', [AccountController::class, 'passwordUpdate'])->name('password.update');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});

// ADMIN GUDANG
Route::middleware(['auth', 'role:ADMIN_GUDANG'])->prefix('retail')->group(function () {

    Route::get('/', [TrxProductController::class, 'index'])->name('retail.dashboard');
    Route::post('trx/{id}/update', [TrxProductController::class, 'update'])->name('trx-retail.update');

    Route::resource('product', ProductController::class);

    Route::get('/transaction', [TrxProductController::class, 'riwayat'])->name('transaction.index');
});

// ADMIN GUDANG
Route::middleware(['auth', 'role:ADMIN_MEKANIK'])->prefix('bengkel')->group(function () {
    Route::get('/', [TrxMekanikController::class, 'dashboard'])->name('bengkel.dashboard');

    Route::post('trx/update', [TrxMekanikController::class, 'update'])->name('trx-bengkel.update');

    Route::resource('mekanik', MekanikController::class);

    Route::get('/transaction', [TrxMekanikController::class, 'riwayat'])->name('bengkel.transaction');
});

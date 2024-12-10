<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\TrxProductController;
use App\Http\Controllers\API\TrxWorkshopController;

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

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', [AuthController::class, 'user']);
    Route::post('change-password', [AuthController::class, 'changePassword']);
    Route::post('update-profile', [AuthController::class, 'updateProfile']);

    // Product
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/product', [ProductController::class, 'getProduct']);

    // Transaction Workshop
    Route::post('/trx/workshop', [TrxWorkshopController::class, 'store']);
    Route::get('/trx/workshop', [TrxWorkshopController::class, 'getTrx']);
    Route::get('/trx/all-workshop', [TrxWorkshopController::class, 'allTrx']);
    Route::post('/trx/workshop/rating', [TrxWorkshopController::class, 'rating']);

    // Transaction Product
    Route::post('/trx/product', [TrxProductController::class, 'store']);
    Route::get('/trx/product', [TrxProductController::class, 'getTrx']);
    Route::get('/trx/all-product', [TrxProductController::class, 'allTrx']);
    Route::post('/trx/product/rating', [TrxProductController::class, 'rating']);
});

// Authentication
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

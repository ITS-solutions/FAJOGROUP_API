<?php

use App\Http\Controllers\Administrative\RoleController;
use App\Http\Controllers\Administrative\TypeIdentificationController;
use App\Http\Controllers\Administrative\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\LotteryController;
use App\Http\Controllers\PaymentMethodsController;
use App\Http\Controllers\RaffleCategoryController;
use App\Http\Controllers\RaffleController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::group([
    'middleware' => ['auth:sanctum'],
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware('auth:sanctum');
    Route::get('me', [AuthController::class, 'me']);
    Route::get('/logout', [AuthController::class, 'logout']);
});

// Administrative Routes
Route::group([
    'middleware' => ['auth:sanctum'],
    'prefix' => 'administrative'
], function () {

    // Roles Routes
    Route::resource('roles', RoleController::class);
    Route::get('permissions/tree', [RoleController::class, 'tree']);

    // Type Identification Routes
    Route::resource('type-identifications', TypeIdentificationController::class);

    // User Routes
    Route::resource('users', UserController::class);    
});

// Raffles Routes
Route::resource('raffles', RaffleController::class);
Route::group([
    'prefix' => 'raffles'
], function () {
    // Categories Routes
    Route::resource('lotteries', LotteryController::class);
    Route::resource('categories', RaffleCategoryController::class);
});

// Settings Routes
Route::group([
    'prefix' => 'settings'
], function () {
    // Categories Routes
    Route::resource('payment-methods', PaymentMethodsController::class);
});
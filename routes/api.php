<?php

use App\Http\Controllers\Administrative\RoleController;
use App\Http\Controllers\Administrative\TypeIdentificationController;
use App\Http\Controllers\Administrative\UserController;
use App\Http\Controllers\Auth\AuthController;
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
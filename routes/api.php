<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group([
    'middleware' => ['auth:sanctum'],
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login'])->withoutMiddleware('auth:sanctum');
    Route::get('me', [AuthController::class, 'me']);
    Route::get('/logout', [AuthController::class, 'logout']);
});
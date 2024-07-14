<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Middleware\ApiMiddleware;
use Illuminate\Support\Facades\Route;


//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::prefix('auth')->withoutMiddleware(\App\Http\Middleware\PermissionMiddleware::class)->controller(AuthController::class)->group(function() {
    Route::post('register', 'register')->withoutMiddleware(ApiMiddleware::class);
    Route::post('login', 'login')->withoutMiddleware(ApiMiddleware::class);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('authenticate', 'authenticate');
        Route::post('logout', 'logout');
        Route::get('whoAmI', 'authenticate');
    });
});



Route::middleware('auth:sanctum')->controller(\App\Http\Controllers\API\RoleController::class)->group(function() {
    Route::get('roles', 'index')->middleware('permission:Admin');
});


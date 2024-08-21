<?php

use App\Http\Controllers\API\AuthUserController;
use App\Http\Controllers\API\FarmingToolController;
use App\Http\Controllers\API\RoleController;
use App\Http\Middleware\ApiMiddleware;
use App\Http\Middleware\PermissionMiddleware;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->withoutMiddleware(PermissionMiddleware::class)->controller(AuthUserController::class)->group(function() {
    Route::post('register', 'register')->withoutMiddleware(ApiMiddleware::class);
    Route::post('login', 'login')->withoutMiddleware(ApiMiddleware::class);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('authenticate', 'authenticate');
        Route::post('logout', 'logout');
        Route::get('whoAmI', 'authenticate');
    });
});

Route::middleware('auth:sanctum')->controller(RoleController::class)->group(function() {
    Route::get('roles', 'index')->middleware('permission:Admin');
});


Route::middleware('auth:sanctum')->controller(FarmingToolController::class)->group(function() {
    Route::get('farming-tools', 'index')->middleware('permission:Admin,Guest|User');
});

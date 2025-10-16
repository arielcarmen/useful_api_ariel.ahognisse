<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ShortLinkController;
use App\Http\Middleware\CheckModuleActive;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/modules', [ModuleController::class, 'index']);
    Route::post('/modules/{id}/activate', [ModuleController::class, 'activate']);
    Route::post('/modules/{id}/deactivate', [ModuleController::class, 'deactivate']);

    Route::middleware('module:1')->group(function() {
        Route::get('/links', [ShortLinkController::class, 'index']);
        Route::post('/shorten', [ShortLinkController::class, 'shorten']);
        Route::delete('/links/{id}', [ShortLinkController::class, 'delete']);
    });
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

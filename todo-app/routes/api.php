<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TodoController;
use App\Http\Controllers\Api\AuthController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Illuminate\Http\Request $request) {
        return $request->user();
    });
    Route::apiResource('todos', TodoController::class);
    Route::apiResource('categories', \App\Http\Controllers\Api\CategoryController::class); // Add this
});
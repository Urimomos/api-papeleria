<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

Route::apiResource('productos', ProductoController::class);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

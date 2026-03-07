<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VentaController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\DashboardController;

Route::apiResource('productos', ProductoController::class);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/ventas', [VentaController::class, 'store']);
Route::apiResource('usuarios', UsuarioController::class);
Route::get('/dashboard', [DashboardController::class, 'index']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

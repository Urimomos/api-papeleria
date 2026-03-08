<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ProductoController;
use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\VentaController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ForgotPasswordController;
use App\Http\Controllers\Api\ResetPasswordController;

Route::apiResource('productos', ProductoController::class);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/ventas', [VentaController::class, 'store']);
Route::apiResource('usuarios', UsuarioController::class);
Route::get('/dashboard', [DashboardController::class, 'index']);
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLink']);
Route::post('password/reset', [ResetPasswordController::class, 'reset']);

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

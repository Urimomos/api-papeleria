<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
    $credenciales = $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);

    // Buscamos al usuario por su username
    $usuario = \App\Models\User::where('username', $request->username)->first();

    // Verificamos si existe y si la contraseña coincide (usando Hash de Laravel)
    if (!$usuario || !\Hash::check($request->password, $usuario->password)) {
        return response()->json(['status' => 'error', 'message' => 'Credenciales incorrectas'], 401);
    }

    return response()->json([
    'status'  => 'success',
    'usuario' => [
        'id'       => $usuario->id,
        'nombre'   => $usuario->nombre,
        'ap'       => $usuario->ap,
        'am'       => $usuario->am,
        'username' => $usuario->username,
        'role'     => $usuario->role
    ]
    ], 200);
}
}

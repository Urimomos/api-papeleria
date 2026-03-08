<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function store(Request $request)
    {
        $validados = $request->validate([
            'nombre'   => 'required|string|max:255',
            'ap'       => 'required|string|max:255',
            'am'       => 'required|string|max:255',
            'username' => 'required|string|unique:users,username',
            'email' => 'required|email|unique:users,email,' . ($id ?? 'NULL'),
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,user'
        ]);

        // Encriptamos la contraseña antes de guardar [cite: 2025-11-23]
        $validados['password'] = Hash::make($request->password);

        $usuario = User::create($validados);

        return response()->json(['status' => 'success', 'data' => $usuario], 201);
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $validados = $request->validate([
            'nombre'   => 'sometimes|required|string',
            'ap'       => 'sometimes|required|string',
            'am'       => 'sometimes|required|string',
            'username' => 'sometimes|required|unique:users,username,'.$id,
            'email' => 'required|email|unique:users,email,' . ($id ?? 'NULL'),
            'role'     => 'sometimes|required|in:admin,user'
        ]);

        // Si mandas contraseña nueva, la encriptamos; si no, dejamos la anterior
        if ($request->filled('password')) {
            $validados['password'] = Hash::make($request->password);
        }

        $usuario->update($validados);

        return response()->json(['status' => 'success', 'message' => 'Usuario actualizado']);
    }

    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->delete();

       return response()->json([
        'status' => 'success',
        'message' => 'Usuario dado de baja (Acceso revocado)'
        ]);
    }
}

?>
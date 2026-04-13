<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UsuarioController extends Controller
{
    public function index()
    {
        return response()->json(User::all(), 200);
    }

    public function store(Request $request)
    {
        $validados = $request->validate([
            'nombre'   => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'], 
            'ap'       => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'], 
            'am'       => ['required', 'string', 'max:255', 'regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u'], 
            
            // Actualizamos username con Rule [cite: 2025-11-23]
            'username' => [
                'required', 
                'string', 
                Rule::unique('users', 'username')->whereNull('deleted_at'), 
                'regex:/^[a-zA-Z0-9.]+$/'
            ], 
            
            // Actualizamos email con Rule
            'email'    => [
                'required', 
                'email', 
                Rule::unique('users', 'email')->whereNull('deleted_at')
            ], 
            
            'password' => ['required', 'string', 'min:8'],
            'role'     => ['required', 'in:admin,user']
        ], [
            // Ajustamos el mensaje para que sea más claro
            'email.unique'    => 'Este correo ya está registrado por un usuario activo.',
            'username.unique' => 'Este nombre de usuario ya está en uso por un usuario activo.',
            'nombre.regex'    => 'El nombre solo debe contener letras.',
            'password.min'    => 'La contraseña debe tener al menos 8 caracteres.'
        ]);
    
        // Encriptamos la contraseña [cite: 2025-11-23]
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
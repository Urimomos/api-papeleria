<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Traemos todos los productos usando el modelo
        $productos = Producto::all(); 

        // Respondemos con un JSON profesional y código 200 (OK)
        return response()->json($productos, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validamos los datos antes de hacer nada
        $validados = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'precio'      => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);

        // Creamos el producto con los datos limpios
        $producto = Producto::create($validados);

        return response()->json([
            'status'  => 'success',
            'message' => 'Producto creado correctamente',
            'data'    => $producto
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Producto $producto)
    {
            $validados = $request->validate([
            'nombre'      => 'sometimes|required|string|max:255',
            'precio'      => 'sometimes|required|numeric|min:0',
            'stock'       => 'sometimes|required|integer|min:0',
            'activo'      => 'sometimes|boolean'
        ]);

        $producto->update($validados);

        return response()->json([
            'status'  => 'success',
            'message' => 'Producto actualizado',
            'data'    => $producto
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Producto $producto)
    {
        // Cambiamos el estado en lugar de borrar la fila
        $producto->update(['activo' => false]);
    
        return response()->json([
            'status'  => 'success',
            'message' => 'Producto dado de baja correctamente'
        ]);
    }
}

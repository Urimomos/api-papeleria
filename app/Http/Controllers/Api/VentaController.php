<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function store(Request $request)
    {
        // Usamos una transacción para asegurar que si algo falla (ej. falta stock), no se guarde nada [cite: 2026-02-20]
        return DB::transaction(function () use ($request) {
            
            // 1. Crear la Venta
            $venta = Venta::create([
                'user_id' => $request->user_id, // [cite: 2025-11-23]
                'total'   => $request->total,
            ]);

            // 2. Procesar los productos enviados desde Angular
            foreach ($request->productos as $item) {
                // Guardar detalle
                $venta->detalles()->create([
                    'producto_id'     => $item['id_producto'],
                    'cantidad'        => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal'        => $item['subtotal'],
                ]);

                // 3. Descontar del inventario [cite: 2026-02-21]
                $producto = Producto::lockForUpdate()->find($item['id_producto']);
                
                if ($producto->stock < $item['cantidad']) {
                    throw new \Exception("Stock insuficiente para: " . $producto->nombre);
                }

                $producto->decrement('stock', $item['cantidad']);
            }

            return response()->json([
                'status'  => 'success',
                'message' => '¡Venta procesada con éxito!'
            ], 201);
        });
    }
}

?>
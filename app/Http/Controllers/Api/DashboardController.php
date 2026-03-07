<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\Producto;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        
        $hoy = Carbon::today();
        $gananciasHoy = Venta::whereDate('created_at', $hoy)->sum('total');
        $ventasHoy = Venta::whereDate('created_at', $hoy)->count();

        $alertasStock = Producto::where('activo', true)
                                ->where('stock', '<=', 5)
                                ->count();

        
        $ventasDia = $ventasHoy;
        $ventasSemana = Venta::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->count();
        $ventasMes = Venta::whereMonth('created_at', Carbon::now()->month)->count();

        
        $ultimasVentas = Venta::with('user:id,nombre')
                             ->latest()
                             ->take(5)
                             ->get();

       
        $ultimaVenta = Venta::latest()->first();
        $minutosUltimaVenta = $ultimaVenta ? (int)$ultimaVenta->created_at->diffInMinutes(Carbon::now()) : '-';

        return response()->json([
            'ganancias_hoy' => (float)$gananciasHoy,
            'ventas_hoy' => $ventasHoy,
            'alertas_stock' => $alertasStock,
            'ventas_dia' => $ventasDia,
            'ventas_semana' => $ventasSemana,
            'ventas_mes' => $ventasMes,
            'ultimas_ventas' => $ultimasVentas,
            'minutos_ultima_venta' => $minutosUltimaVenta
        ], 200);
    }
}
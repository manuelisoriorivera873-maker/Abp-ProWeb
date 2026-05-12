<?php

namespace App\Http\Controllers;

use App\Models\corte_caja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CorteCajaController extends Controller
{
    public function index(Request $request)
    {
        // 1. Obtener la fecha del filtro o la de hoy
        $fecha = $request->get('fecha', now()->format('Y-m-d'));

        // 2. Sumar Ventas de Productos (Asegúrate que el campo se llame 'total' en tu DB)
        $totalVentas = DB::table('ventas')
                        ->whereDate('fecha', '=', $fecha)
                        ->sum('total');

        // 3. Sumar Recargas Telefónicas
        $totalRecargas = DB::table('recargas_telefonicas')
                        ->whereDate('fecha', '=', $fecha)
                        ->sum('monto');

        // 4. Sumar Pagos a Proveedores
        $totalPagos = DB::table('pagos_proveedores')
                        ->whereDate('fecha', '=', $fecha)
                        ->sum('monto');

        // 5. Calcular el total esperado (Saldo en caja)
        $totalEsperado = ($totalVentas + $totalRecargas) - $totalPagos;

        // 6. Obtener historial detallado para la tabla inferior
        $operaciones = $this->obtenerHistorial($fecha);

        // 7. Retornar la vista con TODOS los datos necesarios
        return view('corte_caja.index', compact(
            'totalVentas', 
            'totalRecargas', 
            'totalPagos', 
            'totalEsperado', 
            'operaciones', 
            'fecha'
        ));
    }

    private function obtenerHistorial($fecha)
    {
        // Nota: Si tus tablas tienen el campo 'fecha' como DATE, TIME(fecha) dará 00:00:00. 
        // Si quieres la hora real, el campo en la DB debe ser DATETIME.
        $ventas = DB::table('ventas')
            ->select('id_venta as id', DB::raw("'Venta' as tipo"), DB::raw("'Venta de productos' as descripcion"), 'total as monto', DB::raw("TIME(fecha) as hora"))
            ->whereDate('fecha', $fecha);

        $recargas = DB::table('recargas_telefonicas')
            ->select('id_recarga as id', DB::raw("'Recarga' as tipo"), DB::raw("CONCAT('Recarga ', compania) as descripcion"), 'monto', DB::raw("TIME(fecha) as hora"))
            ->whereDate('fecha', $fecha);

        $pagos = DB::table('pagos_proveedores')
            ->select('id_pago as id', DB::raw("'Pago proveedor' as tipo"), DB::raw("'Salida de efectivo' as descripcion"), 'monto', DB::raw("TIME(fecha) as hora"))
            ->whereDate('fecha', $fecha);

        return $ventas->union($recargas)->union($pagos)->orderBy('hora', 'desc')->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'total_real' => 'required|numeric|min:0',
        ]);

        corte_caja::create([
            'fecha_corte' => $request->fecha,
            'hora_cierre' => Carbon::now()->format('H:i:s'),
            'total_ventas' => $request->total_ventas,
            'total_recargas' => $request->total_recargas,
            'total_pagos' => $request->total_pagos,
            'total_esperado' => $request->total_esperado,
            'total_real' => $request->total_real,
            'diferencia' => $request->total_real - $request->total_esperado,
            'observaciones' => $request->observaciones
        ]);

        return redirect()->route('cortes_caja.index')
                         ->with('success', 'El corte de caja se ha guardado correctamente.');
    }
}
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
        $fecha = $request->get('fecha', Carbon::now()->format('Y-m-d'));
        
        $totalVentas = abs(DB::table('ventas')->whereDate('fecha', '=', $fecha)->sum('total'));
        $totalRecargas = abs(DB::table('recargas_telefonicas')->whereDate('fecha', '=', $fecha)->sum('monto'));
        $totalPagos = abs(DB::table('pagos_proveedores')->whereDate('fecha', '=', $fecha)->sum('monto'));
        
        $totalEsperado = max(0, ($totalVentas + $totalRecargas) - $totalPagos);
        
        // CORRECCIÓN: Tomamos solo el último corte del día
        $ultimoCorte = corte_caja::where('fecha_corte', $fecha)->orderBy('id_corte', 'desc')->first();
        $totalEfectivoIngresado = $ultimoCorte ? $ultimoCorte->total_real : 0;
        
        $historialCortes = corte_caja::where('fecha_corte', $fecha)->orderBy('hora_cierre', 'desc')->get();

        return view('corte_caja.index', compact('totalVentas', 'totalRecargas', 'totalPagos', 'totalEsperado', 'totalEfectivoIngresado', 'fecha', 'historialCortes'));
    }

    public function store(Request $request)
    {
        $request->validate(['total_real' => 'required|numeric']);
        
        corte_caja::create([
            'fecha_corte' => $request->fecha,
            'hora_cierre' => Carbon::now('America/Mexico_City')->format('H:i:s'),
            'total_ventas' => $request->total_ventas,
            'total_recargas' => $request->total_recargas,
            'total_pagos' => $request->total_pagos,
            'total_esperado' => $request->total_esperado,
            'total_real' => $request->total_real,
            'diferencia' => $request->total_real - $request->total_esperado,
        ]);
        return redirect()->back()->with('success', 'Auditoría registrada correctamente.');
    }

    public function destroy($id)
    {
        corte_caja::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Auditoría eliminada.');
    }
}
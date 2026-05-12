<?php

namespace App\Http\Controllers;

use App\Models\venta;
use App\Models\detalle_venta;
use App\Models\producto; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index()
    {
        $ventas = venta::orderBy('id_venta', 'desc')->get();
        return view('venta.index', compact('ventas'));
    }

    public function create()
    {
        $productos = producto::where('stock', '>', 0)->get(); 
        
        return view('venta.create', compact('productos'));
    }

    public function store(Request $request)
    {
        // Validar que lleguen productos
        if (!$request->codigo_producto || count($request->codigo_producto) == 0) {
            return back()->with('error', 'Agregue al menos un producto.');
        }

        try {
            DB::transaction(function () use ($request) {
                // 1. Crear Venta
                $nuevaVenta = venta::create([
                    'fecha'      => $request->fecha ?? now()->format('Y-m-d'),
                    'hora'       => $request->hora ?? now()->format('H:i:s'),
                    'total'      => $request->total,
                    'tipo_venta' => $request->tipo_venta ?? 'Contado'
                ]);

                // 2. Procesar Detalles
                foreach ($request->codigo_producto as $key => $codigo) {
                    $prod = producto::where('codigo', $codigo)->first();

                    if (!$prod) throw new \Exception("Producto $codigo no encontrado.");
                    
                    $cantidad = $request->cantidad[$key];

                    if ($prod->stock < $cantidad) {
                        throw new \Exception("Stock insuficiente para: {$prod->nombre}");
                    }

                    detalle_venta::create([
                        'id_venta'        => $nuevaVenta->id_venta,
                        'id_producto'     => $prod->id_producto,
                        'cantidad'        => $cantidad,
                        'precio_unitario' => $request->precio_unitario[$key]
                    ]);

                    $prod->decrement('stock', $cantidad);
                }
            });

            return redirect()->route('ventas.create')->with('success', 'Venta realizada con éxito.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $venta = venta::findOrFail($id);
        try {
            DB::transaction(function () use ($venta) {
                foreach($venta->detalles as $detalle) {
                    producto::where('id_producto', $detalle->id_producto)->increment('stock', $detalle->cantidad);
                }
                $venta->detalles()->delete();
                $venta->delete();
            });
            return back()->with('success', 'Venta anulada y stock devuelto.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al anular.');
        }
    }
}
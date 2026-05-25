<?php

namespace App\Http\Controllers;

use App\Models\venta;
use App\Models\detalle_venta;
use App\Models\producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $query = venta::query();
        if ($request->filled('valor')) {
            $valor = $request->valor;
            if ($request->tipo_busqueda == 'id_venta') {
                if ($valor <= 0) return back()->with('error', 'ID inválido');
                $query->where('id_venta', $valor);
            }
            if ($request->tipo_busqueda == 'fecha') {
                $query->where('fecha', 'like', "%$valor%");
            }
        }
        $ventas = $query->orderBy('id_venta', 'desc')->get();
        return view('venta.index', compact('ventas'));
    }

    public function create()
    {
        $productos = producto::all(); 
        $fechaActual = now()->format('d/m/Y');
        $horaActual = now()->format('h:i a');
        
        return view('venta.create', compact('productos', 'fechaActual', 'horaActual'));
    }

  public function store(Request $request)
    {
        if (!$request->codigo_producto || $request->total <= 0) {
            return back()->with('error', 'Datos inválidos');
        }

        DB::transaction(function () use ($request) {
            $venta = venta::create([
                // Usamos DB::raw para que la base de datos asigne la hora del sistema local
                'fecha' => DB::raw('CURDATE()'),
                'hora' => DB::raw('CURTIME()'), 
                'total' => $request->total,
                'tipo_venta' => $request->tipo_venta
            ]);

            foreach ($request->codigo_producto as $i => $codigo) {
                $prod = producto::where('codigo', $codigo)->first();
                if (!$prod) throw new \Exception("Producto con código $codigo no encontrado");
                
                $cantidad = $request->cantidad[$i];
                if ($cantidad <= 0 || $prod->stock < $cantidad) throw new \Exception("Stock insuficiente para: " . $prod->nombre);
                
                detalle_venta::create([
                    'id_venta' => $venta->id_venta,
                    'id_producto' => $prod->id_producto,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $request->precio_unitario[$i]
                ]);
                
                $prod->decrement('stock', $cantidad);
            }
        });
        
        return redirect()->route('ventas.index')->with('success', 'Venta registrada correctamente');
    }

    public function destroy($id)
    {
        $venta = venta::findOrFail($id);
        DB::transaction(function () use ($venta) {
            foreach ($venta->detalles as $d) {
                producto::where('id_producto', $d->id_producto)->increment('stock', $d->cantidad);
            }
            $venta->detalles()->delete();
            $venta->delete();
        });
        return back()->with('success', 'Venta anulada y stock recuperado');
    }

    public function show($id)
    {
        $venta = venta::with('detalles.producto')->findOrFail($id);
        return view('venta.show', compact('venta'));
    }
}
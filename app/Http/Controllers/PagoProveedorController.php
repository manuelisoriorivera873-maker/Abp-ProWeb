<?php

namespace App\Http\Controllers;

use App\Models\pago_proveedor;
use App\Models\proveedor; 
use Illuminate\Http\Request;

class PagoProveedorController extends Controller
{
    /**
     * Muestra el historial de pagos realizados.
     */
    public function index()
    {
        // Cargamos los pagos con la relación del proveedor para ver el nombre
        $pagos = pago_proveedor::with('proveedor')->get();
        // Cambiado a la carpeta 'pago_proveedor' (singular)
        return view('pago_proveedor.index', compact('pagos'));
    }

    /**
     * Muestra el formulario para registrar un nuevo pago.
     */
    public function create()
    {
        // Obtenemos los proveedores de la tabla 'proveedores'
        $proveedores = proveedor::all();
        // Cambiado a la carpeta 'pago_proveedor' (singular)
        return view('pago_proveedor.create', compact('proveedores'));
    }

    /**
     * Guarda el pago en la base de datos.
     */
    public function store(Request $request)
    {
        // Registro del pago usando los campos exactos de tu tabla 'pagos_proveedores'
        pago_proveedor::create([
            'fecha'        => $request->fecha,        // Según tu SQL
            'id_proveedor' => $request->id_proveedor, // Según tu SQL
            'metodo_pago'  => $request->metodo_pago,  // Según tu SQL
            'monto'        => $request->monto,        // Según tu SQL
        ]);

        // Redirigimos al index usando el nombre de tu ruta 'pagos_proveedores'
        return redirect()->route('pagos_proveedores.index')
                         ->with('success', 'Pago al proveedor registrado correctamente.');
    }

    /**
     * Muestra el detalle de un pago específico.
     */
    public function show(pago_proveedor $pago_proveedor)
    {
        return view('pago_proveedor.show', compact('pago_proveedor'));
    }

    /**
     * Muestra el formulario para editar un pago.
     */
   public function edit($id)
{
    $pago_proveedor = \App\Models\pago_proveedor::findOrFail($id);
    $proveedores = \App\Models\proveedor::all();
    return view('pago_proveedor.edit', compact('pago_proveedor', 'proveedores'));
}

    /**
     * Actualiza el registro de un pago.
     */
public function update(Request $request, $id) // Usamos $id para no fallar
{
    $pago = \App\Models\pago_proveedor::findOrFail($id);
    $pago->update($request->all());
    return redirect()->route('pagos_proveedores.index');
}

    /**
     * Elimina el registro de un pago.
     */
    public function destroy(pago_proveedor $pago_proveedor)
    {
        $pago_proveedor->delete();
        return redirect()->route('pagos_proveedores.index');
    }
}
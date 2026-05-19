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
        // Cargamos los pagos con la relación y ordenamos por fecha (más reciente primero)
        $pagos = pago_proveedor::with('proveedor')->orderBy('fecha', 'desc')->get();
        return view('pago_proveedor.index', compact('pagos'));
    }

    /**
     * Muestra el formulario para registrar un nuevo pago.
     */
    public function create()
    {
        $proveedores = proveedor::all();
        return view('pago_proveedor.create', compact('proveedores'));
    }

    /**
     * Guarda el pago con validación de coherencia.
     */
    public function store(Request $request)
    {
        // Validación en español para que los mensajes de SweetAlert sean claros
        $request->validate([
            'fecha'        => 'required|date',
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'metodo_pago'  => 'required|string',
            'monto'        => 'required|numeric|min:0.01',
        ], [
            'id_proveedor.exists' => 'El proveedor seleccionado no es válido.',
            'monto.min'           => 'El monto del pago debe ser mayor a cero.',
            'fecha.required'      => 'La fecha del pago es obligatoria.'
        ]);

        pago_proveedor::create([
            'fecha'        => $request->fecha,
            'id_proveedor' => $request->id_proveedor,
            'metodo_pago'  => $request->metodo_pago,
            'monto'        => $request->monto,
        ]);

        return redirect()->route('pagos_proveedores.index')
                         ->with('success', '¡Excelente! El pago al proveedor se registró correctamente.');
    }

    /**
     * Muestra el detalle de un pago específico.
     */
    public function show($id)
    {
        $pago_proveedor = pago_proveedor::with('proveedor')->findOrFail($id);
        return view('pago_proveedor.show', compact('pago_proveedor'));
    }

    /**
     * Muestra el formulario para editar un pago.
     */
    public function edit($id)
    {
        $pago_proveedor = pago_proveedor::findOrFail($id);
        $proveedores = proveedor::all();
        return view('pago_proveedor.edit', compact('pago_proveedor', 'proveedores'));
    }

    /**
     * Actualiza el registro de un pago.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha'        => 'required|date',
            'id_proveedor' => 'required|exists:proveedores,id_proveedor',
            'monto'        => 'required|numeric|min:0.01',
        ], [
            'monto.min' => 'El monto debe ser una cantidad válida.'
        ]);

        $pago = pago_proveedor::findOrFail($id);
        $pago->update($request->all());

        return redirect()->route('pagos_proveedores.index')
                         ->with('success', 'El registro del pago ha sido actualizado.');
    }

    /**
     * Elimina el registro de un pago.
     */
    public function destroy($id)
    {
        $pago = pago_proveedor::findOrFail($id);
        $pago->delete();

        return redirect()->route('pagos_proveedores.index')
                         ->with('success', 'El pago ha sido eliminado del historial.');
    }
}
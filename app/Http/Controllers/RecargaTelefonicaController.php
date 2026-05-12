<?php

namespace App\Http\Controllers;

use App\Models\recarga_telefonica;
use App\Models\saldo_disponible; // Importamos el modelo del saldo
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; // Para usar transacciones

class RecargaTelefonicaController extends Controller
{
    public function index()
    {
        $recargas = recarga_telefonica::orderBy('id_recarga', 'desc')->get();
        return view('recarga_telefonica.index', compact('recargas'));
    }

    public function create()
    {
        return view('recarga_telefonica.create');
    }

    public function store(Request $request)
    {
        // 1. Validar la entrada
        $request->validate([
            'numero_telefono' => 'required',
            'monto' => 'required|numeric|min:1',
            'compania' => 'required'
        ]);

        // 2. Buscar el saldo disponible en la caja (ID 1)
        $saldoCaja = saldo_disponible::find(1);

        // 3. Verificar si hay dinero suficiente antes de proceder
        if (!$saldoCaja || $saldoCaja->saldo_disponible < $request->monto) {
            return back()->with('error', 'Saldo insuficiente en caja para realizar esta recarga.');
        }

        // 4. Usar una transacción para asegurar que si falla el registro, no se descuente el dinero (y viceversa)
        DB::transaction(function () use ($request, $saldoCaja) {
            
            // A) Registrar la recarga
            $recarga = new recarga_telefonica();
            $recarga->numero_telefono = $request->numero_telefono;
            $recarga->compania = $request->compania;
            $recarga->monto = $request->monto;
            $recarga->fecha = $request->fecha ?? now(); // Si no viene fecha, usa la actual
            $recarga->id_venta = $request->id_venta; 
            $recarga->save();

            // B) DESCUENTO AUTOMÁTICO
            // Restamos el monto de la recarga al saldo de la caja
            $saldoCaja->decrement('saldo_disponible', $request->monto);
        });

        return redirect()->route('recargas_telefonicas.index')
                         ->with('success', 'Recarga registrada y saldo descontado con éxito');
    }

    // Los métodos show, edit, update y destroy pueden quedarse igual, 
    // pero recuerda que si editas un monto o eliminas una recarga, 
    // tendrías que decidir si devuelves el dinero a la caja o no.
}
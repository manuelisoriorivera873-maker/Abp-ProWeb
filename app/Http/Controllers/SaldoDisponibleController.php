<?php

namespace App\Http\Controllers;

use App\Models\saldo_disponible;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaldoDisponibleController extends Controller
{
    /**
     * Muestra la pantalla azul con el saldo actual (Tienda La Subidita).
     */
    public function index()
    {
        // Buscamos el registro único basado en tu tabla 'saldo_recargas'
        $saldo = saldo_disponible::find(1);

        // Si la tabla está vacía, creamos el registro inicial con 0
        if (!$saldo) {
            $saldo = new saldo_disponible();
            $saldo->id_saldo = 1;
            $saldo->saldo_disponible = 0;
            $saldo->save();
        }

        return view('saldo_disponible.index', [
            'monto' => $saldo->saldo_disponible
        ]);
    }

    /**
     * Muestra el formulario diseñado para añadir dinero.
     */
    public function create()
    {
        return view('saldo_disponible.create');
    }

    /**
     * Procesa el aumento de saldo.
     */
    public function store(Request $request)
    {
        // Validamos el campo 'monto' (el nombre que pusimos en el input de la vista)
        $request->validate([
            'monto' => 'required|numeric|min:0.01'
        ]);

        DB::transaction(function () use ($request) {
            $saldo = saldo_disponible::find(1);
            
            // Sumamos el valor ingresado al saldo_disponible de la BD
            $saldo->saldo_disponible += $request->monto;
            $saldo->save();
        });

        return redirect()->route('saldo_disponible.index')
            ->with('success', 'Se han abonado $' . number_format($request->monto, 2) . ' al saldo de recargas.');
    }

    // Los demás métodos (show, edit, update, destroy) se mantienen igual o vacíos.
}
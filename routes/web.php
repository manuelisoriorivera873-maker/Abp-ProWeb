<?php
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*Route::get('/', function () {
    return view('layouts.template');
});*/

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('layouts.template'); // Aquí pon tu vista principal
    })->name('inicio');
});

Route::resource('proveedores','App\Http\Controllers\ProveedorController');
Route::resource('productos','App\Http\Controllers\ProductoController');
Route::resource('inicio','App\Http\Controllers\InicioController');
Route::resource('ventas','App\Http\Controllers\VentaController');
Route::resource('detalle_venta','App\Http\Controllers\DetalleVentaController');
Route::resource('pagos_proveedores','App\Http\Controllers\PagoProveedorController');
Route::resource('inventarios_productos','App\Http\Controllers\InventarioProductoController');
Route::resource('recargas_telefonicas','App\Http\Controllers\RecargaTelefonicaController');
Route::resource('saldo_disponible','App\Http\Controllers\SaldoDisponibleController');
Route::resource('cortes_caja','App\Http\Controllers\CorteCajaController');
Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.store');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');